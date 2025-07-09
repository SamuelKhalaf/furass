<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PermissionEnum;
use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Models\PathPoint;
use App\Models\Program;
use App\Models\Student;
use App\Rules\ValidPathPoint;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ProgramsController extends Controller
{
    public function index()
    {
        return view('admin.programs.index');
    }

    public function getProgramsData()
    {
        $programs = Program::get();

        return DataTables::of($programs)
            ->addColumn('title_ar', function ($program) {
                return $program->title_ar;
            })
            ->addColumn('title_en', function ($program) {
                return $program->title_en;
            })
            ->addColumn('description_ar', function ($program) {
                return $program->description_ar;
            })
            ->addColumn('description_en', function ($program) {
                return $program->description_en;
            })
            ->addColumn('actions', function ($program) {
                $actions = '';
                if (auth()->user()->hasAnyPermission([
                    PermissionEnum::UPDATE_PROGRAMS->value,
                ])) {
                    $actions = '<a href="#" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    '.__("programs.actions").'
                                    <span class="svg-icon svg-icon-5 m-0">
                                       <i class="fa-solid fa-caret-down"></i>
                                   </span>
                                </a>';

                    $actions .= '<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-2" data-kt-menu="true">';

                    if (auth()->user()->hasPermissionTo(PermissionEnum::UPDATE_PROGRAMS->value)) {
                        $actions .= '<div class="menu-item px-3">
                            <a href="#" class="menu-link " data-program-id="' . $program->id . '" data-bs-toggle="modal" data-bs-target="#kt_modal_update_program">
                                '.__("programs.edit").'
                            </a>
                        </div>';
                    }
                    $actions .= '</div>';
                }
                return $actions;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function edit($id)
    {
        $program = Program::with(['pathPoints' => function($query) {
            $query->orderBy('pivot_order');
        }])->findOrFail($id);

        $pathPoints = PathPoint::all();

        return response()->json([
            'program' => $program,
            'path_points' => $pathPoints
        ]);
    }

    /**
     * Update the specified program in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        // Validate the request data
        $validated = $request->validate([
            'title_ar' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'description_ar' => 'required|string',
            'description_en' => 'required|string',
            'path_points' => 'nullable|array',
            'path_points.*.id' => 'required|integer|exists:path_points,id',
            'path_points.*.order' => 'required|integer|min:1',
        ]);

        try {
            // Find the program
            $program = Program::findOrFail($id);

            // Update basic program info
            $program->update([
                'title_ar' => $validated['title_ar'],
                'title_en' => $validated['title_en'],
                'description_ar' => $validated['description_ar'],
                'description_en' => $validated['description_en']
            ]);

            // Sync path points with order if they exist in request
            if ($request->has('path_points') && !empty($request->path_points)) {
                $pathPointsData = [];

                // Prepare the pivot data with order
                foreach ($request->path_points as $pathPoint) {
                    $pathPointsData[$pathPoint['id']] = ['order' => $pathPoint['order']];
                }

                $program->pathPoints()->sync($pathPointsData);
            }

            return response()->json([
                'success' => true,
                'message' => __('Program updated successfully')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Error updating program')
            ], 500);
        }
    }
}
