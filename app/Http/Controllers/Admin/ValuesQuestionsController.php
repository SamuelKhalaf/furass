<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PermissionEnum;
use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Models\QuestionBankType;
use App\Models\School;
use App\Models\User;
use App\Models\ValuesQuestions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class ValuesQuestionsController extends Controller
{
    public function index()
    {
        return view('admin.values_questions.index');
    }

    public function getValueQuestionData()
    {
        $valueQuestion = ValuesQuestions::get_relation_data();

        return DataTables::of($valueQuestion)
            ->addColumn('valueQuestionName', function ($valueQuestion) {
                $name = json_decode($valueQuestion->valueQuestionName, true);
                return $name[app()->getLocale()] ?? '';
            })
            ->addColumn('questionBankName', function ($valueQuestion) {
                $name = json_decode($valueQuestion->questionBankName, true);
                return $name[app()->getLocale()] ?? '';
            })
            ->addColumn('parentName', function ($valueQuestion) {
                $name = json_decode($valueQuestion->parentName, true);
                return $name[app()->getLocale()] ?? '';
            })
            ->addColumn('actions', function ($valueQuestion) {
                $actions = '';
                if (auth()->user()->hasAnyPermission([
                    PermissionEnum::UPDATE_SCHOOLS->value,
                    PermissionEnum::DELETE_SCHOOLS->value
                ])) {
                    $actions = '<a href="#" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    '.__("schools.actions").'
                                    <span class="svg-icon svg-icon-5 m-0">
                                       <i class="fa-solid fa-caret-down"></i>
                                   </span>
                                </a>';

                    $actions .= '<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">';

                    if (auth()->user()->hasPermissionTo(PermissionEnum::UPDATE_SCHOOLS->value)) {
                        $actions .= '<div class="menu-item px-3">
                            <a href="#" class="menu-link px-3" data-user-id="' . $valueQuestion->id . '" data-bs-toggle="modal" data-bs-target="#kt_modal_update_school">
                                '.__("valueQuestion.edit").'
                            </a>
                        </div>';
                    }

                    if (auth()->user()->hasPermissionTo(PermissionEnum::DELETE_SCHOOLS->value)) {
                        $actions .= '<div class="menu-item px-3">
                            <a href="#" class="menu-link px-3" data-kt-users-table-filter="delete_row"
                               data-user-id="' . $valueQuestion->id . '">'.__("valueQuestion.delete").'</a>
                        </div>';
                    }

                    $actions .= '</div>';
                }
                return $actions;
            })
            ->rawColumns(['questionBankName', 'valueQuestionName' , 'parentName','actions'])
            ->make(true);
    }

    public function getDataForCreate()
    {
        $questionBankType = QuestionBankType::all();
        $parentValues = ValuesQuestions::where('parent_id' , 0)->get();
        return response()->json([
            'data' => [
                'questionBankType' => $questionBankType,
                'parentValues' => $parentValues
            ]
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'question_bank_type_id' => 'required|integer',
            'parent_id' => 'nullable',
        ]);
        $parentId = $request->filled('parent_id') ? $request->parent_id : 0;

        try {
            DB::beginTransaction();
             ValuesQuestions::create([
                'name'          => [
                    'ar'=>$request->name_ar,
                    'en'=>$request->name_en,
                ],
                'parent_id' => $parentId,
                'question_bank_type_id'=>$request->question_bank_type_id
            ]);

            DB::commit();

            return response()->json(['message' => 'School created successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error creating School'] , 500);
        }
    }

    public function edit(string $id)
    {
        $questionBankType = QuestionBankType::all();
        $parentValues = ValuesQuestions::where('parent_id' , 0)->get();
        $valuesQuestions = ValuesQuestions::get_relation_data($id);
        return response()->json([
            'valuesQuestions'=>$valuesQuestions,
            'questionBankType'=>$questionBankType,
            'parentValues'=>$parentValues,
        ]);
    }

    public function update(Request $request, $value)
    {
        $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'question_bank_type_id' => 'required|integer',
            'parent_id' => 'nullable',
        ]);
        $parentId = $request->filled('parent_id') ? $request->parent_id : 0;

        try {
            DB::beginTransaction();
            ValuesQuestions::where('id' ,$value)->update([
                'name'          => [
                    'ar'=>$request->name_ar,
                    'en'=>$request->name_en,
                ],
                'parent_id' => $parentId,
                'question_bank_type_id'=>$request->question_bank_type_id
            ]);

            DB::commit();

            return response()->json(['data'=> $value,'message' => 'School updated successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error updating School'] , 500);
        }

    }

    public function destroy($value)
    {

        try {
            DB::beginTransaction();

            $valueQuestion = ValuesQuestions::findOrFail($value);

            if ($valueQuestion->parent_id == 0) {
                return response()->json(['success' => false, 'message' => 'Error deleting School.'] , 500);
            }
            $valueQuestion->delete();
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Value Question deleted successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Error deleting School.'] , 500);
        }
    }
}
