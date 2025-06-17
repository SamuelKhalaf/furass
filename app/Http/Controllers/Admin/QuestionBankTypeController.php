<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PermissionEnum;
use App\Http\Controllers\Controller;
use App\Models\QuestionBankType;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class QuestionBankTypeController extends Controller
{
    public function index()
    {
        return view('admin.question_bank_type.index');
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

                    if (auth()->user()->hasPermissionTo(PermissionEnum::UPDATE_SCHOOLS->value)) {
                        $actions .= '<div class="menu-item px-3">
                            <a href="#" class="menu-link px-3" data-user-id="' . $questionBank->id . '" data-bs-toggle="modal" data-bs-target="#kt_modal_update_school">
                                '.__("admin.questionBank.edit").'
                            </a>
                        </div>';
                    }

                    if (auth()->user()->hasPermissionTo(PermissionEnum::DELETE_SCHOOLS->value)) {
                        $actions .= '<div class="menu-item px-3">
                            <a href="#" class="menu-link px-3" data-kt-users-table-filter="delete_row"
                               data-user-id="' . $questionBank->id . '">'.__("admin.questionBank.delete").'</a>
                        </div>';
                    }

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
        ]);

        try {
            DB::beginTransaction();
            QuestionBankType::create([
                'name' => [
                    'ar'=>$request->name_ar,
                    'en'=>$request->name_en
                ]
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
        $questionBank = QuestionBankType::findOrFail($id);
        return response()->json($questionBank);
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

}
