<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PermissionEnum;
use App\Http\Controllers\Controller;
use App\Models\Ckeditor;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class CkeditorController extends Controller
{
    //page about
    public function indexAbout()
    {
        return view('admin.ckeditor.about.index');
    }
    public function getAboutData()
    {
        $pages = Ckeditor::where('page', 'about')->get();

        $flattenedRows = [];

        foreach ($pages as $page) {
            $variables = $page->variables_en ?? [];

            foreach ($variables as $key => $value) {
                $flattenedRows[] = [
                    'id' => $page->id,
                    'page' => $page->page,
                    'key' => $key,
                    'value' => $value,
                ];
            }
        }

        return DataTables::of($flattenedRows)
            ->addColumn('actions', function ($flattenedRows) {
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
                            <a href="#" class="menu-link px-3" data-user-id="' . $flattenedRows['key'] . '" data-bs-toggle="modal" data-bs-target="#kt_modal_update_school">
                                '.__("pages.edit").'
                            </a>
                        </div>';
                    }
                    $actions .= '</div>';
                }
                return $actions;
            })
            ->rawColumns(['key','actions'])
            ->make(true);
    }

    public function edit(string $value)
    {
        $pages = Ckeditor::where('page', 'about')->first();
        $variables_en = $pages->variables_en[$value];
        $variables_ar = $pages->variables_ar[$value];

        return response()->json(['variables_en' =>$variables_en , 'variables_ar' =>$variables_ar  , 'key'=> $value]);
    }

    public function update(Request $request, $key)
    {
        $request->validate([
            'content_en' => 'required|string',
            'content_ar' => 'required|string',
        ]);

        try {
            DB::beginTransaction();
            // Get the page
            $page = Ckeditor::where('page', 'about')->first();

            $variables_en = $page->variables_en ?? [];
            $variables_ar = $page->variables_ar ?? [];

            $variables_en[$key] = $request->input('content_en');
            $variables_ar[$key] = $request->input('content_ar');

            $page->variables_en = $variables_en;
            $page->variables_ar = $variables_ar;

            $page->save();

            DB::commit();

            return response()->json(['data'=> $request->content_en,'message' => 'School updated successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['data'=> $request,'message' => 'Error updating School'] , 500);
        }

    }
}
