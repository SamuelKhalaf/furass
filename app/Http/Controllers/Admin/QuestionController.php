<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PermissionEnum;
use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Models\QuestionBankType;
use App\Models\Questions;
use App\Models\School;
use App\Models\User;
use App\Models\ValuesQuestions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class QuestionController extends Controller
{
    public function index()
    {
        return view('admin.questions.index');
    }

    public function getQuestionsData()
    {
        $questions = Questions::getData();

        return DataTables::of($questions)
            ->addColumn('text', function ($questions) {
                $text = json_decode($questions->text, true);
                return $text[app()->getLocale()] ?? '';
            })
            ->addColumn('value', function ($questions) {
                $value = json_decode($questions->value, true);
                return $value[app()->getLocale()] ?? '';
            })
            ->addColumn('bank', function ($questions) {
                $bank = json_decode($questions->bank, true);
                return $bank[app()->getLocale()] ?? '';
            })
            ->addColumn('actions', function ($questions) {
                $actions = '';
                if (auth()->user()->hasAnyPermission([
                    PermissionEnum::UPDATE_EXAMS->value,
                    PermissionEnum::DELETE_EXAMS->value
                ])) {
                    $actions = '<a href="#" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    '.__("schools.actions").'
                                    <span class="svg-icon svg-icon-5 m-0">
                                       <i class="fa-solid fa-caret-down"></i>
                                   </span>
                                </a>';

                    $actions .= '<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">';

                    if (auth()->user()->hasPermissionTo(PermissionEnum::UPDATE_EXAMS->value)) {
                        $actions .= '<div class="menu-item px-3">
                            <a href="#" class="menu-link px-3" data-user-id="' . $questions->id . '" data-bs-toggle="modal" data-bs-target="#kt_modal_update_school">
                                '.__("schools.edit").'
                            </a>
                        </div>';
                    }

                    if (auth()->user()->hasPermissionTo(PermissionEnum::DELETE_EXAMS->value)) {
                        $actions .= '<div class="menu-item px-3">
                            <a href="#" class="menu-link px-3" data-kt-users-table-filter="delete_row"
                               data-user-id="' . $questions->id . '">'.__("schools.delete").'</a>
                        </div>';
                    }

                    $actions .= '</div>';
                }
                return $actions;
            })
            ->rawColumns(['text', 'value', 'bank','actions'])
            ->make(true);
    }

    public function getDataOfBankValue()
    {
        try {
            $banks = QuestionBankType::all();
            $values = ValuesQuestions::all();

            return response()->json([
                'status' => true,
                'message' => 'Data retrieved successfully.',
                'data' => [
                    'banks' => $banks,
                    'values' => $values
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to fetch data.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'bank_id' => 'required|integer',
            'value_id' => 'required|integer',
            'text_en' => 'required|string|max:255',
            'text_ar' => 'required|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            Questions::create([
                'bank_id'=>$request->bank_id,
                'value_id'=>$request->value_id,
                'text'=>[
                    'ar'=>$request->text_ar,
                    'en'=>$request->text_en,
                ],
            ]);

            DB::commit();
            if ($request->ajax()) {
                return response()->json(['message' => 'Question created successfully']);
            }

            return redirect()->back()->with('success', 'Your Partnership requested successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            if ($request->ajax()) {
                return response()->json(['message' => 'Error creating Question'], 500);
            }

            return redirect()->back()->with('error', 'Something went wrong. Please try again.');        }
    }

    public function edit(string $id)
    {
        $banks = QuestionBankType::all();
        $values = ValuesQuestions::all();
        $question = Questions::findOrFail($id);

        return response()->json([
            'question'=>$question,
            'banks'=>$banks,
            'values'=>$values
        ]);
    }

    public function update(Request $request, $question)
    {
        $request->validate([
            'bank_id' => 'required|integer',
            'value_id' => 'required|integer',
            'text_en' => 'required|string|max:255',
            'text_ar' => 'required|string|max:255',
        ]);

        try {
            DB::beginTransaction();
            $question = Questions::findOrFail($question);
            $question->update([
                'bank_id'=>$request->bank_id,
                'value_id'=>$request->value_id,
                'text'=>[
                    'ar'=>$request->text_ar,
                    'en'=>$request->text_en,
                ],
            ]);
            DB::commit();

            return response()->json(['message' => 'Question updated successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error updating Question'] , 500);
        }

    }

    public function destroy($question)
    {
        try {
            DB::beginTransaction();

            Questions::findOrFail($question)->delete();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'question deleted successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Error deleting question.'] , 500);
        }
    }

}
