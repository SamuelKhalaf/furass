<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PermissionEnum;
use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Models\PathPoint;
use App\Models\Event;
use App\Models\QuestionBankType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class PathPointController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::all();
        $questionBankTypes = QuestionBankType::all();
        return view('admin.path_points.index', compact('events', 'questionBankTypes'));
    }

    public function getPathPointsData()
    {
        $pathPoints = PathPoint::all();

        return DataTables::of($pathPoints)
            ->addColumn('title_display', function ($pathPoint) {
                return '<div class="d-flex flex-column">' .
                    '<span class="text-dark fw-bold">' . e($pathPoint->title_en) . '</span>' .
                    '<span class="text-muted fs-7">' . e($pathPoint->title_ar) . '</span>' .
                    '</div>';
            })
            ->addColumn('table_name', fn($pathPoint) => ucfirst(str_replace('_', ' ', $pathPoint->table_name)))
            ->addColumn('grade_display', function ($pathPoint) {
                if ($pathPoint->grade) {
                    return '<span class="badge badge-light-primary">Grade ' . $pathPoint->grade . '</span>';
                }
                return '<span class="text-muted">All Grades</span>';
            })
            ->addColumn('meta_display', function ($pathPoint) {
                if ($pathPoint->meta) {
                    $meta = $pathPoint->meta;
                    $display = '';
                    if (isset($meta['event_id'])) {
                        $event = Event::find($meta['event_id']);
                        $display = $event ? '<span class="badge badge-light-info">Event: ' . $event->event_name . '</span>' : '';
                    } elseif (isset($meta['question_bank_type_id'])) {
                        $questionBankType = QuestionBankType::find($meta['question_bank_type_id']);
                        $display = $questionBankType ? '<span class="badge badge-light-warning">Question Bank: ' . $questionBankType->name . '</span>' : '';
                    }
                    return $display;
                }
                return '<span class="text-muted">Not Assigned</span>';
            })
            ->addColumn('actions', function ($pathPoint) {
                $actions = '';
                if (auth()->user()->hasAnyPermission([
                    PermissionEnum::UPDATE_PATH_POINTS->value ?? 'update-path-points',
                    PermissionEnum::DELETE_PATH_POINTS->value ?? 'delete-path-points'
                ])) {
                    $actions = '<a href="#" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    Actions
                                    <span class="svg-icon svg-icon-5 m-0">
                                       <i class="fa-solid fa-caret-down"></i>
                                   </span>
                                </a>';

                    $actions .= '<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">';

                    if (auth()->user()->hasPermissionTo(PermissionEnum::UPDATE_PATH_POINTS->value ?? 'update-path-points')) {
                        $actions .= '<div class="menu-item px-3">
                            <a href="#" class="menu-link px-3" data-path-point-id="' . $pathPoint->id . '" data-bs-toggle="modal" data-bs-target="#kt_modal_update_path_point">
                                Edit
                            </a>
                        </div>';
                    }

                    if (auth()->user()->hasPermissionTo(PermissionEnum::DELETE_PATH_POINTS->value ?? 'delete-path-points')) {
                        $actions .= '<div class="menu-item px-3">
                            <a href="#" class="menu-link px-3" data-kt-path-points-table-filter="delete_row"
                               data-path-point-id="' . $pathPoint->id . '">Delete</a>
                        </div>';
                    }

                    $actions .= '</div>';
                }
                return $actions;
            })
            ->addColumn('created_at', function ($row) {
                return $row->created_at->format('Y-m-d H:i');
            })
            ->rawColumns(['actions', 'title_display', 'grade_display', 'meta_display'])
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title_ar' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'table_name' => 'required|in:evaluation_tests,consultations,events',
            'grade' => 'required|integer|min:10|max:12',
            'event_id' => 'required_if:table_name,events|nullable|exists:events,id',
            'question_bank_type_id' => 'required_if:table_name,evaluation_tests|nullable|exists:question_bank_types,id',
        ]);

        try {
            DB::beginTransaction();

            $meta = null;
            if ($request->table_name === 'events' && $request->event_id) {
                $meta = json_encode(['event_id' => $request->event_id]);
            } elseif ($request->table_name === 'evaluation_tests' && $request->question_bank_type_id) {
                $meta = json_encode(['question_bank_type_id' => $request->question_bank_type_id]);
            }

            PathPoint::create([
                'title_ar' => $request->title_ar,
                'title_en' => $request->title_en,
                'table_name' => $request->table_name,
                'meta' => $meta,
                'grade' => $request->grade,
            ]);

            DB::commit();

            return response()->json(['message' => 'Path point created successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error creating path point: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pathPoint = PathPoint::findOrFail($id);

        // Parse meta data
        $meta = $pathPoint->meta ?? null;
        $pathPoint->event_id = $meta['event_id'] ?? null;
        $pathPoint->question_bank_type_id = $meta['question_bank_type_id'] ?? null;

        return response()->json($pathPoint);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pathPoint = PathPoint::findOrFail($id);

        $request->validate([
            'title_ar' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'table_name' => 'required|in:evaluation_tests,consultations,events',
            'grade' => 'nullable|integer|min:10|max:12',
            'event_id' => 'required_if:table_name,events|nullable|exists:events,id',
            'question_bank_type_id' => 'required_if:table_name,evaluation_tests|nullable|exists:question_bank_types,id',
        ]);

        try {
            DB::beginTransaction();

            $meta = null;
            if ($request->table_name === 'events' && $request->event_id) {
                $meta = json_encode(['event_id' => $request->event_id]);
            } elseif ($request->table_name === 'evaluation_tests' && $request->question_bank_type_id) {
                $meta = json_encode(['question_bank_type_id' => $request->question_bank_type_id]);
            }

            $pathPoint->update([
                'title_ar' => $request->title_ar,
                'title_en' => $request->title_en,
                'table_name' => $request->table_name,
                'meta' => $meta,
                'grade' => $request->grade,
            ]);

            DB::commit();

            return response()->json(['message' => 'Path point updated successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error updating path point: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();

            $pathPoint = PathPoint::findOrFail($id);
            $pathPoint->delete();

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Path point deleted successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Error deleting path point: ' . $e->getMessage()], 500);
        }
    }
}
