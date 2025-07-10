<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\EvaluationTest;
use App\Models\PathPoint;
use App\Models\Program;
use App\Models\QuestionBankType;
use App\Models\QuestionBankValue;
use App\Models\Questions;
use App\Models\Student;
use App\Models\StudentPathProgress;
use App\Models\ValuesQuestions;
use App\Services\IStudentProgressService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EvaluationController extends Controller
{

    protected IStudentProgressService $progressService;

    public function __construct(IStudentProgressService $progressService)
    {
        $this->progressService = $progressService;
    }

    public function listQuestionBank()
    {
        $data['banks'] = QuestionBankType::all();
        return view('admin.evaluation.list_exams', $data);
    }

    public function displayTest($bank_id, $program_id = null, $path_point_id = null)
    {
        $user = auth()->user();

        if (! $user || $user->role !== 'Student') {
            abort(403, 'Only students can access this test.');
        }

        $student = Student::where('user_id', $user->id)->first();
        if (! $student) {
            abort(403, 'Student record not found.');
        }

        // Check if enrolled in this program
        $isEnrolled = Enrollment::where('student_id', $student->id)
            ->where('program_id', $program_id)
            ->exists();

        if (! $isEnrolled) {
            abort(403, 'You are not enrolled in this program.');
        }

        // Check if path point is active for this student
        $progress = StudentPathProgress::where('student_id', $student->id)
            ->where('program_id', $program_id)
            ->where('path_point_id', $path_point_id)
            ->first();

        if (! $progress || $progress->status == 1) {
            abort(403, 'This path point is locked');
        }

//        session()->put("start_time_{$path_point_id}", now());

        // Enforce max attempt logic
        $MAX_ATTEMPTS = 2;

        $questionIds = Questions::where('bank_id', $bank_id)->pluck('id');

        $attemptCount = EvaluationTest::where('student_id', $student->id)
            ->where('bank_id' , $bank_id)
            ->whereIn('question_id', $questionIds)
            ->max('trying') ?? 0;

//        if ($attemptCount >= $MAX_ATTEMPTS) {
//            abort(403, 'You have reached the maximum number of attempts for this test.');
//        }

        // Fetch questions if everything is OK
        $questions = Questions::where('bank_id', $bank_id)
            ->where('action', 'select')
            ->orderBy('order')
            ->get();

        $program = Program::find($program_id);
        $pathPoint = PathPoint::find($path_point_id);

        return view('admin.evaluation.evaluation_test', compact(
            'bank_id',
            'questions',
            'program',
            'pathPoint',
            'program_id',
            'path_point_id'
        ));
    }


    public function evaluation(Request $request)
    {
        $user = auth()->user();

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 401);
        }

        if ($user->role != 'Student') {
            return response()->json([
                'success' => true,
                'message' => 'You Must Be Student',
            ], 200);
        }

        $student = Student::where('user_id' , $user->id)->first();
        if (! $student) {
            return response()->json([
                'success' => false,
                'message' => 'Student not found.',
            ], 404);
        }

        $result = $request->input('answers', []);
        $program_id = $request->input('program_id');
        $path_point_id = $request->input('path_point_id');

        if (empty($result)) {
            return response()->json([
                'success' => false,
                'message' => 'No answers submitted',
            ], 422);
        }

        $questionIds = array_keys($result);

        $nextTrying = EvaluationTest::where('student_id', $student->id)
            ->where('bank_id' , $request->bank_id)
            ->whereIn('question_id', $questionIds)
            ->max('trying') ?? 0;

        $nextTrying++;

        DB::beginTransaction();

        try {
            $totalScore = 0;
            $maxScore = 0;

            foreach ($result as $questionId => $answer) {

                $question = Questions::find($questionId);
                if (! $question) {
                    throw new \Exception("Question ID {$questionId} not found");
                }

                $bank = QuestionBankType::find($question->bank_id);
                if (! $bank) {
                    throw new \Exception("Bank for Question ID {$questionId} not found");
                }

                $value = ValuesQuestions::find($question->value_id);
                if (! $value) {
                    throw new \Exception("Value for Question ID {$questionId} not found");
                }

                // Calculate score based on a question type
                $questionScore = 0;
                if ($question->type === 'rating') {
                    $questionScore = $answer; // For rating questions, the answer is the score
                    $maxScore += 5; // Assuming the max rating is 5
                } elseif ($question->type === 'true_and_false') {
                    $questionScore = ($answer == 0) ? 1 : 0; // True = 1 point, False = 0 points
                    $maxScore += 1;
                }

                $totalScore += $questionScore;

                EvaluationTest::create([
                    'student_id'   => $student->id,
                    'question_id'  => $questionId,
                    'bank_id'      => $bank->id,
                    'value_id'     => $value->id,
                    'evaluation'   => $answer,
                    'trying'       => $nextTrying,
                ]);
            }

            // Update path point progress if program_id and path_point_id are provided
            if ($program_id && $path_point_id) {
                $progress = StudentPathProgress::where('student_id', $student->id)
                    ->where('program_id', $program_id)
                    ->where('path_point_id', $path_point_id)
                    ->first();

//                $startTime = session()->pull("start_time_{$path_point_id}");
//                $timeSpent = $startTime ? now()->diffInMinutes(Carbon::parse($startTime)) : 1;

                if ($progress) {
                    $progress->update([
                        'status' => 3,
                        'score' => null, // Can be calculated later
                        'attempt_count' => $progress->attempt_count + 1,
                        'completion_date' => now(),
                        'time_spent' => 0, // Can be calculated later
                    ]);

                    $this->progressService->unlockNextPathPoint($student->id, $program_id, $path_point_id);
                    $this->progressService->updateProgramProgress($student->id, $program_id);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Evaluation submitted successfully',
                'score' => $totalScore,
                'max_score' => $maxScore,
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('Evaluation submission failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Evaluation failed: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function getQuestionRelated($bank_id , $value_question = null)
    {
        if ($value_question == null){
            $questions = Questions::where('bank_id', $bank_id)->orderBy('order')->get();
        }else{
            $questions = Questions::where('bank_id', $bank_id)->where('value_id' , $value_question)->orderBy('order')->get();
        }


        $selected = Questions::where('bank_id', $bank_id)->where('action', 'select')->pluck('id');
        $values = QuestionBankValue::get_bank_values($bank_id);

        if ($questions->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No questions found for this bank.',
                'questions' => [],
            ], 200);
        }

        return response()->json([
            'success' => true,
            'message' => 'Questions retrieved successfully.',
            'questions' => $questions,
            'selected_questions' => $selected,
            'values'=> $values ,
        ], 200);
    }

    public function select(Request $request)
    {
        $validated = $request->validate([
            'question_id' => 'required|integer|exists:questions,id',
            'action' => 'required|in:select,deselect',
        ]);

        $question = Questions::findOrFail($validated['question_id']);
        $question->action = $validated['action'];
        $question->save();

        return response()->json([
            'success' => true,
            'message' => "Question {$validated['action']}ed successfully.",
            'question' => [
                'id' => $question->id,
                'action' => $question->action,
            ]
        ]);
    }

    public function reorder(Request $request)
    {
        $validated = $request->validate([
            'order' => 'required|array',
            'order.*.id' => 'required|integer|exists:questions,id',
            'order.*.order' => 'required|integer',
        ]);

        foreach ($validated['order'] as $item) {
            Questions::where('id', $item['id'])->update(['order' => $item['order']]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Question order updated successfully.'
        ]);
    }



}
