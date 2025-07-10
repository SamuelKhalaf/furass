<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EvaluationTest;
use App\Models\QuestionBankType;
use App\Models\QuestionBankValue;
use App\Models\Questions;
use App\Models\Student;
use App\Models\ValuesQuestions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EvaluationController extends Controller
{

    public function listQuestionBank()
    {
        $data['banks'] = QuestionBankType::all();
        return view('admin.evaluation.list_exams', $data);
    }

    public function displayTest($bank_id)
    {
        $data['questions'] = Questions::where('bank_id', $bank_id)->where('action', 'select')->orderBy('order')->get();
        $data['bank_id'] = $bank_id ;
        return view('admin.evaluation.evaluation_test', $data);
    }

    public function evaluation(Request $request)
    {
        $student = auth()->user();

        if (! $student) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 401);
        }

        if ($student->role != 'Student') {
            return response()->json([
                'success' => true,
                'message' => 'You Must Be Student',
            ], 200);
        }

        $student_id = Student::where('user_id' , $student->id)->first();

        $result = $request->input('answers', []);

        if (empty($result)) {
            return response()->json([
                'success' => false,
                'message' => 'No answers submitted',
            ], 422);
        }

        DB::beginTransaction();

        try {
            // check if this student already took this exam
            $latestAttempt = EvaluationTest::where([
                'student_id' => $student_id->id,
                'bank_id'    => $request->bank_id,
            ])->orderByDesc('trying')->first();

            $nextTrying = 1;

            if ($latestAttempt) {
                $nextTrying = $latestAttempt->trying + 1;
            }

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

                EvaluationTest::create([
                    'student_id'   => $student_id->id,
                    'question_id'  => $questionId,
                    'bank_id'      => $bank->id,
                    'value_id'     => $value->id,
                    'evaluation'   => $answer,
                    'trying'       => $nextTrying,
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Evaluation submitted successfully',
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
