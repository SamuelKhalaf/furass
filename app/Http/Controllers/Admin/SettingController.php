<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PermissionEnum;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class SettingController extends Controller
{
    public function index()
    {
        return view('admin.setting.index');
    }

    public function getSettingData()
    {
        $setting = Setting::all();

        return DataTables::of($setting)

            ->addColumn('name', function ($setting) {
                return $setting->key;
            })
            ->addColumn('value', function ($setting) {
                return $setting->value;
            })

            ->addColumn('actions', function ($setting) {
                $actions = '';
                if (auth()->user()->hasAnyPermission([
                    PermissionEnum::UPDATE_PAGES->value,
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
                            <a href="#" class="menu-link px-3" data-user-id="' . $setting->id . '" data-bs-toggle="modal" data-bs-target="#kt_modal_update_school">
                                '.__("schools.edit").'
                            </a>
                        </div>';
                    }

                    $actions .= '</div>';
                }
                return $actions;
            })
            ->rawColumns(['name', 'value', 'actions'])
            ->make(true);
    }

    public function edit(string $id)
    {
        $setting = Setting::findOrFail($id);
        return response()->json($setting);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'value' => 'required|string|max:255',
        ]);
        try {
            DB::beginTransaction();
            Setting::where('id', $id)->update([
                'value'=>$request->value,
            ]);

            DB::commit();

            return response()->json(['message' => 'School updated successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error updating School'] , 500);
        }

    }

}
