<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PermissionEnum;
use App\Http\Controllers\Controller;
use App\Models\QuestionBankType;
use App\Models\QuestionBankValue;
use App\Models\Questions;
use App\Models\School;
use App\Models\ValuesQuestions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class QuestionBankTypeController extends Controller
{
    public function index()
    {
        $data = [];
        $data['question_values'] = ValuesQuestions::all();
        return view('admin.question_bank_type.index' , $data);
    }

    public function getQuestionBankData()
    {

        $questionBank = QuestionBankType::all();

        return DataTables::of($questionBank)
            ->addColumn('name_ar', function ($questionBank) {
                return $questionBank->name['ar'];
            })
            ->addColumn('name_en', function ($questionBank) {
                return $questionBank->name['en'];
            })
            ->addColumn('actions', function ($questionBank) {
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

                    if (auth()->user()->hasPermissionTo(PermissionEnum::UPDATE_EXAMS->value)) {
                        $actions .= '<div class="menu-item px-3">
                            <a href="#"
                            class="menu-link px-3" data-user-id="' . $questionBank->id . '"
                            data-bs-toggle="modal"
                             data-bs-target="#kt_modal_update_school">
                                '.__("admin.questionBank.edit").'
                            </a>
                        </div>';
                    }

                    if (auth()->user()->hasPermissionTo(PermissionEnum::DELETE_EXAMS->value)) {
                        $actions .= '<div class="menu-item px-3">
                            <a href="#" class="menu-link px-3" data-kt-users-table-filter="delete_row"
                               data-user-id="' . $questionBank->id . '">'.__("admin.questionBank.delete").'</a>
                        </div>';
                    }

//                    if (auth()->user()->hasPermissionTo(PermissionEnum::UPDATE_EXAMS->value)) {
//                        $url = route('admin.question.index',  $questionBank->id);
//                        $actions .= '<div class="menu-item px-3">
//                              <a href="' . $url . '" class="menu-link px-3" data-user-id="' . $questionBank->id . '">'
//                            . __("admin.questionBank.add_question") .
//                            '</a>
//                            </div>';
//                    }


                    $actions .= '</div>';
                }
                return $actions;
            })
            ->rawColumns(['name_ar', 'name_en','actions'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'percentages' => 'required|array',
            'percentages.*' => 'numeric|min:0|max:100',
        ]);

        try {
            DB::beginTransaction();
            $bank = QuestionBankType::create([
                'name' => [
                    'ar'=>$request->name_ar,
                    'en'=>$request->name_en
                ]
            ]);

            if ($request->has('percentages')) {
                foreach ($request->percentages as $value_id => $percentage) {
                    QuestionBankValue::create([
                        'bank_id'   => $bank->id,
                        'value_id'  => $value_id,
                        'percentage'=> $percentage
                    ]);
                }
            }

            DB::commit();
            return response()->json(['message' => 'question bank created successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error creating question bank'] , 500);
        }
    }

    public function edit(string $id)
    {

        $selectedValues = QuestionBankValue::where('bank_id', $id)->pluck('value_id');
        $newValues = ValuesQuestions::whereNotIn('id', $selectedValues)->get();

        $questionBank = QuestionBankType::findOrFail($id);
        $bankValues = QuestionBankValue::get_bank_values($id);

        return response()->json([
            'question_bank' => $questionBank,
            'bank_values' => $bankValues,
            'new_values' => $newValues,
        ]);
    }

    public function update(Request $request, $QuestionBank)
    {
        $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
        ]);

        try {
            DB::beginTransaction();

             QuestionBankType::findOrFail($QuestionBank)->update([
                'name' => [
                    'ar' => $request->name_ar,
                    'en' => $request->name_en,
                ]
            ]);

            foreach ( $request->percentages as $value => $percentage ){
                $existValue = QuestionBankValue::where(['bank_id' => $QuestionBank , 'value_id'=> $value])->first();
                if ($existValue){
                    $existValue->update([
                       'bank_id'=> $QuestionBank,
                        'value_id'=>$value,
                        'percentage'=>$percentage
                    ]);
                }else{
                    QuestionBankValue::create([
                    'bank_id' => $QuestionBank,
                    'value_id' => $value,
                    'percentage' => $percentage
                ]);
                }
            }

            DB::commit();
            return response()->json(['message' => 'School updated successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error updating School'] , 500);
        }

    }

    public function destroy($QuestionBank)
    {

        try {
            DB::beginTransaction();
            QuestionBankType::findOrFail($QuestionBank)->delete();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'School deleted successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Error deleting School.'] , 500);
        }
    }

    public function get_exam_related_values($bank_id)
    {
        $bankValues = QuestionBankValue::get_bank_values($bank_id);
        return response()->json([
            'related_bank_values' => $bankValues,
        ]);
    }

    public function add_question(Request $request , $bank_id)
    {
//        return $request;
        foreach ($request->questions as $question) {
            Questions::create([
                'bank_id' => 10,
                'value_id' => 2,
                'text' => [
                    'ar' => $question['ar'],
                    'en' => $question['en']
                ]
            ]);
        }
        return response()->json(['data'=>$request ,'message' => 'question created successfully']);
    }

}
