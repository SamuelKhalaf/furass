<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PermissionEnum;
use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;


class PagesController extends Controller
{
    public function index()
    {
        return view('admin.pages.index');
    }

    public function getPagesData()
    {
        $pages = Page::all();

        return DataTables::of($pages)
            ->addColumn('title_en', function ($pages) {
                return $pages->title_en;
            })
            ->addColumn('title_ar', function ($pages) {
                return $pages->title_ar;
            })
            ->addColumn('actions', function ($pages) {
                $actions = '';
                if (auth()->user()->hasAnyPermission([
                    PermissionEnum::UPDATE_PAGES->value,
                    PermissionEnum::DELETE_PAGES->value
                ])) {
                    $actions = '<a href="#" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    '.__("schools.actions").'
                                    <span class="svg-icon svg-icon-5 m-0">
                                       <i class="fa-solid fa-caret-down"></i>
                                   </span>
                                </a>';

                    $actions .= '<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">';

                    if (auth()->user()->hasPermissionTo(PermissionEnum::UPDATE_PAGES->value)) {
                        $actions .= '<div class="menu-item px-3">
                            <a href="#" class="menu-link px-3" data-user-id="' . $pages->id . '" data-bs-toggle="modal" data-bs-target="#kt_modal_update_school">
                                '.__("valueQuestion.edit").'
                            </a>
                        </div>';
                    }

                    if (auth()->user()->hasPermissionTo(PermissionEnum::DELETE_PAGES->value)) {
                        $actions .= '<div class="menu-item px-3">
                            <a href="#" class="menu-link px-3" data-kt-users-table-filter="delete_row"
                               data-user-id="' . $pages->id . '">'.__("valueQuestion.delete").'</a>
                        </div>';
                    }

                    $actions .= '</div>';
                }
                return $actions;
            })
            ->rawColumns(['title_en','title_en' ,'actions'])
            ->make(true);
    }

    public function store(Request $request)
    {
        dd($request);
//        $request->validate([
//            'name_ar' => 'required|string|max:255',
//            'name_en' => 'required|string|max:255',
//            'question_bank_type_id' => 'required|integer',
//            'parent_id' => 'nullable',
//        ]);
//        $parentId = $request->filled('parent_id') ? $request->parent_id : 0;

        try {
            DB::beginTransaction();
            Page::create([
                'title_en' =>$request->title_en,
                'title_ar' =>$request->title_ar,
                'content_en' =>$request->content_en,
                'content_ar' =>$request->content_ar,
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
