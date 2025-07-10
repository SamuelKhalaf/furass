<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EvaluationTest;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EvaluationResultController extends Controller
{
    public function allQuestionBank()
    {
        return view('admin.evaluation_result.all_Question_bank');
    }

    public function evaluationResult($bank_id, $student_id = null)
    {
        $user = auth()->user();

        if (! $user) {
            return view('admin.evaluation_result.evaluation_result', [
                'error' => 'Unauthorized access. Please log in.',
            ]);
        }

        $studentId = null;

        if ($user->role === 'Consultant') {
            if (! $student_id) {
                return view('admin.evaluation_result.evaluation_result', [
                    'error' => 'Student ID is required for consultants.',
                ]);
            }
            $studentId = $student_id;
        } elseif ($user->role === 'Student') {
            $student = Student::where('user_id', $user->id)->first();
            if (! $student) {
                return view('admin.evaluation_result.evaluation_result', [
                    'error' => 'Student record not found for this user.',
                ]);
            }
            $studentId = $student->id;
            $examExist = EvaluationTest::where(['bank_id' => $bank_id , 'student_id'=>$studentId])->first();
            if (!$examExist){
                return view('admin.evaluation_result.evaluation_result', [
                    'error' => 'You have not  taken this exam yet. Go take it first. ',
                ]);
            }
        } else {
            return view('admin.evaluation_result.evaluation_result', [
                'error' => 'Your role is not authorized to view evaluation results.',
            ]);
        }

        // Validate bank ID if needed
        if (! is_numeric($bank_id)) {
            return view('admin.evaluation_result.evaluation_result', [
                'error' => 'Invalid bank ID.',
            ]);
        }

        try {
            $questions = $this->get_evaluation_questions($bank_id, $studentId);
            $tryingNumber = $this->get_trying_numbers($bank_id, $studentId);
        } catch (\Throwable $e) {
            return view('admin.evaluation_result.evaluation_result', [
                'error' => 'An error occurred while retrieving evaluation data: ' . $e->getMessage(),
            ]);
        }

        if (empty($questions)) {
            return view('admin.evaluation_result.evaluation_result', [
                'error' => 'No evaluation questions found for this student and bank.',
            ]);
        }

        return view('admin.evaluation_result.evaluation_result', [
            'questions' => $questions,
            'tryingNumber' => $tryingNumber,
            'bank_id' => $bank_id,
            'studentId' => $studentId,
        ]);
    }


    public function get_trying_numbers($bank_id, $student_id)
    {
        return DB::table('evaluation_tests')
            ->where([
                'student_id' => $student_id,
                'bank_id'    => $bank_id,
            ])
            ->select('trying')
            ->distinct()
            ->pluck('trying');
    }

    public function get_evaluation_questions($bank_id , $student_id , $trying = null)
    {
        if ($trying == null){
            $questions =  DB::table('evaluation_tests')
                ->where(['student_id' => $student_id , 'evaluation_tests.bank_id' => $bank_id , 'trying'=> 1 ])
                ->join('questions' , 'evaluation_tests.question_id' , '=' , 'questions.id')
                ->get();

            $evaluations =  DB::table('evaluation_tests')
                ->where('student_id', $student_id)
                ->where('bank_id', $bank_id)
                ->where('trying', 1)
                ->select('value_id', DB::raw('SUM(evaluation) as total_evaluation'))
                ->groupBy('value_id')
                ->get();

            return [$questions , $evaluations];
        }

        $questions =  DB::table('evaluation_tests')
            ->where(['student_id' => $student_id , 'evaluation_tests.bank_id' => $bank_id , 'trying'=> $trying ])
            ->join('questions' , 'evaluation_tests.question_id' , '=' , 'questions.id')
            ->get();

        $evaluations =  DB::table('evaluation_tests')
            ->where('student_id', $student_id)
            ->where('bank_id', $bank_id)
            ->where('trying', $trying)
            ->join('values_questions' , 'evaluation_tests.value_id' , '=' ,'values_questions.id')
            ->select('value_id', DB::raw('SUM(evaluation) as total_evaluation') , 'name')
            ->groupBy('value_id', 'name')
            ->get();

        return [$questions , $evaluations];
    }

}
