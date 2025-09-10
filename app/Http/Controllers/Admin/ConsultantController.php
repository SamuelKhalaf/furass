<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PermissionEnum;
use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Models\Consultant;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class ConsultantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.consultants.index');
    }

    public function getConsultantsData()
    {
        $consultants = Consultant::with('user')->get();

        return DataTables::of($consultants)
            ->addColumn('name', function ($consultant) {
                return $consultant->user->name;
            })
            ->addColumn('bio', function ($consultant) {
                return $consultant->bio;
            })
            ->addColumn('email', function ($consultant) {
                return $consultant->user->email;
            })
            ->addColumn('phone', function ($consultant) {
                return $consultant->user->phone_number;
            })
            ->addColumn('actions', function ($consultant) {
                $actions = '';
                if (auth()->user()->hasAnyPermission([
                    PermissionEnum::UPDATE_CONSULTANTS->value,
                    PermissionEnum::DELETE_CONSULTANTS->value
                ])) {
                    $actions = '<a href="#" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    '.__("consultants.actions").'
                                    <span class="svg-icon svg-icon-5 m-0">
                                       <i class="fa-solid fa-caret-down"></i>
                                   </span>
                                </a>';

                    $actions .= '<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">';

                    if (auth()->user()->hasPermissionTo(PermissionEnum::UPDATE_CONSULTANTS->value)) {
                        $actions .= '<div class="menu-item px-3">
                            <a href="#" class="menu-link px-3" data-user-id="' . $consultant->id . '" data-bs-toggle="modal" data-bs-target="#kt_modal_update_consultant">
                                '.__("consultants.edit").'
                            </a>
                        </div>';
                    }

                    if (auth()->user()->hasPermissionTo(PermissionEnum::DELETE_CONSULTANTS->value)) {
                        $actions .= '<div class="menu-item px-3">
                            <a href="#" class="menu-link px-3" data-kt-users-table-filter="delete_row"
                               data-user-id="' . $consultant->id . '">'.__("consultants.delete").'</a>
                        </div>';
                    }

                    $actions .= '</div>';
                }
                return $actions;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $schools = \App\Models\School::with('user')->get();
        return response()->json(['schools' => $schools]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'phone_number' => 'required|string|max:20|unique:users',
            'country_code' => 'required|string|max:10',
            'bio' => 'required|string',
            'school_ids' => 'array',
            'school_ids.*' => 'exists:schools,id',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->has('is_active')) {
            $is_active = $request->is_active;
        } else {
            $is_active = false;
        }

        try {
            DB::beginTransaction();
            $user = User::create([
                'name'          => $request->name,
                'email'         => $request->email,
                'phone_number'  => $request->phone_number,
                'country_code'  => $request->country_code,
                'role'          => RoleEnum::CONSULTANT->value,
                'password'      => Hash::make($request->password),
                'is_active'     => $is_active
            ]);

            $user->assignRole(RoleEnum::CONSULTANT->value);

            $consultant = new Consultant();

            $consultant->user_id = $user->id;
            $consultant->bio = $request->bio;

            $consultant->save();

            if ($request->has('school_ids')) {
                $consultant->schools()->sync($request->school_ids);
            }

            DB::commit();

            return response()->json(['message' => 'Consultant created successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error creating Consultant'] , 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $consultant = Consultant::with('user', 'consultations')->findOrFail($id);
        return view('admin.consultants.show', compact('consultant'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $consultant = Consultant::with('user', 'schools')->findOrFail($id);
        $schools = \App\Models\School::with('user')->get();
        $assignedSchoolIds = $consultant->schools->pluck('id');
        return response()->json([
            'consultant' => $consultant,
            'schools' => $schools,
            'assignedSchoolIds' => $assignedSchoolIds,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Consultant $consultant)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $consultant->user_id,
            'phone_number' => 'required|string|max:20|unique:users,phone_number,' . $consultant->user_id,
            'country_code' => 'required|string|max:10',
            'bio' => 'required|string',
            'school_ids' => 'array',
            'school_ids.*' => 'exists:schools,id',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->has('is_active')) {
            $is_active = $request->is_active;
        } else {
            $is_active = false;
        }

        try {
            DB::beginTransaction();

            $user = $consultant->user;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone_number = $request->phone_number;
            $user->country_code = $request->country_code;
            $user->is_active = $is_active;
            $user->save();

            $consultant->bio = $request->bio;
            $consultant->save();

            if ($request->has('school_ids')) {
                $consultant->schools()->sync($request->school_ids);
            } else {
                $consultant->schools()->sync([]);
            }

            DB::commit();

            return response()->json(['message' => 'Consultant updated successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error updating Consultant'] , 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Consultant $consultant)
    {
        try {
            DB::beginTransaction();

            // Detach consultant from all schools
            $consultant->schools()->detach();

            // Delete the user and the consultant
            $consultant->user->delete();
            $consultant->delete();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Consultant deleted successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Error deleting Consultant.'] , 500);
        }
    }

    /**
     * view the students results for the assessments
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function viewStudentsResult(Request $request)
    {
        $user = auth()->user();
        $consultant = Consultant::where('user_id', $user->id)->first();
        $schools = $consultant->schools;

        // Start building the query
        $studentsQuery = Student::whereIn('school_id', $schools->pluck('id'))
            ->with(['user', 'school.user', 'evaluationTests'])
            // Filter students who are enrolled in programs that have path points managing evaluation_tests
            ->whereHas('studentPathProgress.pathPoint', function ($query) {
            $query->where('table_name', 'evaluation_tests');
        });
        // Apply school filter if provided
        if ($request->filled('school_id')) {
            $studentsQuery->where('school_id', $request->school_id);
        }

        $students = $studentsQuery->paginate(9);

        // Process students data with simplified structure
        $students->getCollection()->transform(function ($student) {
            // Group evaluation tests by bank_id and get simplified data
            $groupedTests = $student->evaluationTests
                ->groupBy('bank_id')
                ->map(function ($tests, $bankId) {
                    // Get the latest attempt for this bank_id
                    $latestTest = $tests->sortByDesc('trying')->first();

                    // Simplified: Just check if there are any tests for this bank
                    $hasTests = $tests->count() > 0;

                    return [
                        'bank_id' => $bankId,
                        'has_tests' => $hasTests,
                        'latest_attempt' => $latestTest->trying ?? 1,
                        'last_updated' => $latestTest->updated_at ?? $latestTest->created_at,
                    ];
                });

            // Add simplified test statistics to student
            $student->total_tests = $groupedTests->count();
            $student->has_any_tests = $student->total_tests > 0;

            // Keep the grouped tests for detailed view if needed
            $student->grouped_evaluation_tests = $groupedTests;

            return $student;
        });

        return view('admin.consultants.list_students', compact('students', 'schools'));
    }
}
