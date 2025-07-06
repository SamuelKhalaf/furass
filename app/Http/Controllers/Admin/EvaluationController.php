<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EvaluationTest;
use App\Models\QuestionBankType;
use App\Models\Questions;
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
        $questions = Questions::where('bank_id' , $bank_id)->get();
        return view('admin.evaluation.evaluation_test',compact('questions') );
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

        $result = $request->input('answers', []);

        if (empty($result)) {
            return response()->json([
                'success' => false,
                'message' => 'No answers submitted',
            ], 422);
        }

        DB::beginTransaction();

        try {
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
                    'student_id'   => $student->id,
                    'question_id'  => $questionId,
                    'bank_id'      => $bank->id,
                    'value_id'     => $value->id,
                    'evaluation'   => $answer,
                    'trying'       => 1,
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
}
