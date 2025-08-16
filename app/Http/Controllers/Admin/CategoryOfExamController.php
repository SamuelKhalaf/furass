<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PermissionEnum;
use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Models\categories_of_exam;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class CategoryOfExamController extends Controller
{
    public function index()
    {
        return view('admin.category_of_exam.index');
    }

    public function getCategoryData()
    {
        $category = categories_of_exam::all();
        return DataTables::of($category)
            ->addColumn('cat_name', function ($category) {
                return $category->cat_name[app()->getLocale()] /*?? $category->cat_name['en']*/;
            })
            ->addColumn('actions', function ($category) {
                $actions = '';
                if (auth()->user()->hasAnyPermission([
                    PermissionEnum::UPDATE_SCHOOLS->value,
                    PermissionEnum::DELETE_SCHOOLS->value
                ])) {
                    $actions = '<a href="#" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    Actions
                                    <span class="svg-icon svg-icon-5 m-0">
                                       <i class="fa-solid fa-caret-down"></i>
                                   </span>
                                </a>';

                    $actions .= '<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">';

                    if (auth()->user()->hasPermissionTo(PermissionEnum::UPDATE_SCHOOLS->value)) {
                        $actions .= '<div class="menu-item px-3">
                            <a href="#" class="menu-link px-3" data-user-id="' . $category->id . '" data-bs-toggle="modal" data-bs-target="#kt_modal_update_school">
                                Edit
                            </a>
                        </div>';
                    }

                    if (auth()->user()->hasPermissionTo(PermissionEnum::DELETE_SCHOOLS->value)) {
                        $actions .= '<div class="menu-item px-3">
                            <a href="#" class="menu-link px-3" data-kt-users-table-filter="delete_row"
                               data-user-id="' . $category->id . '">Delete</a>
                        </div>';
                    }

                    $actions .= '</div>';
                }
                return $actions;
            })
            ->rawColumns(['name', 'actions'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
        ]);

        try {
            categories_of_exam::create([
                'cat_name' => [
                    'ar' => $request->name_ar,
                    'en' => $request->name_en,
                ]
            ]);

            return response()->json(['message' => 'category created successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error creating School'] , 500);
        }
    }

    public function edit(string $id)
    {
        $school = categories_of_exam::findOrFail($id);
        return response()->json($school);
    }

    public function update(Request $request,$category_id)
    {
        $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
        ]);

        try {
            categories_of_exam::where('id' , $category_id)->update([
                'cat_name' => [
                    'ar' => $request->name_ar,
                    'en' => $request->name_en,
                ]
            ]);
            return response()->json(['message' => 'School updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error updating School'] , 500);
        }
    }

    public function destroy(categories_of_exam $category)
    {

        try {

            $category->delete();

            return response()->json(['success' => true, 'message' => 'School deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error deleting School.'] , 500);
        }
    }



}
