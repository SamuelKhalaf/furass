<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PermissionEnum;
use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use App\Services\IStudentProgressService;

class StudentController extends Controller
{
    protected IStudentProgressService $progressService;

    public function __construct(IStudentProgressService $progressService)
    {
        $this->progressService = $progressService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        if ($user->hasRole(RoleEnum::ADMIN->value)) {
            $schools = School::all();
        } elseif ($user->hasRole(RoleEnum::SCHOOL->value)) {
            $schools = School::where('user_id', $user->id)->get();
        } else {
            $schools = collect();
        }
        return view('admin.students.index', compact('schools'));
    }

    public function getStudentsData()
    {
        if(auth()->user()->hasRole(RoleEnum::ADMIN->value)) {
            $students = Student::with(['user','school'])->get();
        } elseif(auth()->user()->hasRole(RoleEnum::SCHOOL->value)) {
            $school = School::where('user_id', auth()->user()->id)->first();
            $students = Student::with(['user','school'])
                ->where('school_id', $school->id)
                ->get();
        } else {
            return response()->json(['success' => false , 'message' => 'You do not have permission to view this page']);
        }

        return DataTables::of($students)
            ->addColumn('avatar_name', function ($student) {
                if ($student->avatar) {
                    $avatarUrl = asset('storage/' . $student->avatar);
                    $imgTag = '<img src="' . $avatarUrl . '" alt="Avatar" width="40" class="me-3 border" style="object-fit:cover; background:#f3f6f9; border-radius:6px;">';
                } else {
                    $imgTag = '<span class="rounded-circle me-3 border" style="width:40px;height:40px;background:#f3f6f9;display:flex;align-items:center;justify-content:center;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="8" r="4" fill="#b5b5c3"/>
                            <rect x="4" y="16" width="16" height="6" rx="3" fill="#b5b5c3"/>
                        </svg>
                    </span>';
                }
                $html = '<div class="d-flex align-items-center">';
                $html .= $imgTag;
                $html .= '<span>' . e($student->user->name) . '</span>';
                $html .= '</div>';
                return $html;
            })
            ->addColumn('student_id_number', fn($student) => $student->student_id_number)
            ->addColumn('school.name', fn($student) => $student->school->user->name)
            ->addColumn('grade', fn($student) => $student->grade)
            ->addColumn('birth_date', fn($student) => $student->birth_date)
            ->addColumn('gender', fn($student) => ucfirst($student->gender))
            ->addColumn('actions', function ($student) {
                $actions = '';
                if (auth()->user()->hasAnyPermission([
                    PermissionEnum::UPDATE_STUDENTS->value,
                    PermissionEnum::DELETE_STUDENTS->value
                ])) {
                    $actions = '<a href="#" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    '.__("students.actions").'
                                    <span class="svg-icon svg-icon-5 m-0">
                                       <i class="fa-solid fa-caret-down"></i>
                                   </span>
                                </a>';

                    $actions .= '<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">';

                    if (auth()->user()->hasPermissionTo(PermissionEnum::UPDATE_STUDENTS->value)) {
                        $actions .= '<div class="menu-item px-3">
                            <a href="#" class="menu-link px-3" data-user-id="' . $student->id . '" data-bs-toggle="modal" data-bs-target="#kt_modal_update_details">
                                '.__("students.edit").'
                            </a>
                        </div>';
                    }

                    if (auth()->user()->hasPermissionTo(PermissionEnum::DELETE_STUDENTS->value)) {
                        $actions .= '<div class="menu-item px-3">
                            <a href="#" class="menu-link px-3" data-kt-users-table-filter="delete_row"
                               data-user-id="' . $student->id . '">'.__("students.delete").'</a>
                        </div>';
                    }

                    $actions .= '</div>';
                }
                return $actions;
            })
            ->addColumn('parent_info', function ($student) {
                if ($student->parent_name) {
                    $relationship = $student->parent_relationship ?
                        \App\Models\Student::relationshipOptions()[$student->parent_relationship] : '';
                    return '<div class="d-flex flex-column">' .
                        '<span class="fw-bold">' . e($student->parent_name) . '</span>' .
                        '<small class="text-muted">' . e($student->parent_phone) . '</small>' .
                        '<small class="text-muted">' . e($relationship) . '</small>' .
                        '</div>';
                }
                return '<span class="text-muted">-</span>';
            })
            ->addColumn('created_at' , function ($row) {
                return $row->created_at->format('Y-m-d');
            })
            ->rawColumns(['actions', 'avatar_name', 'parent_info'])
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone_number' => 'required|string|max:20|unique:users',
            'country_code' => 'required|string|max:10',
            'password' => 'required|string|min:6|confirmed',
            'school_id' => 'required|exists:schools,id',
            'student_id_number' => 'required|string|max:30|unique:students,student_id_number',
            'grade' => 'required|string|max:50',
            'birth_date' => 'required|date',
            'gender' => 'required|in:male,female',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'nullable|boolean',
            'parent_name' => 'nullable|string|max:255',
            'parent_phone' => 'nullable|string|max:20',
            'parent_country_code' => 'nullable|string|max:10',
            'parent_relationship' => 'nullable|integer|in:1,2,3,4',
        ]);

        if ($request->has('is_active')) {
            $is_active = $request->is_active;
        } else {
            $is_active = false;
        }

        try {
            // Check if school has reached maximum students limit
            $school = School::findOrFail($request->school_id);
            if ($school->wouldExceedMaxStudents()) {
                $currentCount = $school->getCurrentStudentsCount();
                $maxStudents = $school->max_students;
                return response()->json([
                    'message' => "Cannot add student. This school has reached its maximum student limit of {$maxStudents} students. Current count: {$currentCount}.",
                    'error' => 'max_students_exceeded'
                ], 422);
            }

            DB::beginTransaction();
            // Create user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'country_code' => $request->country_code,
                'password' => Hash::make($request->password),
                'role' => RoleEnum::STUDENT->value,
                'is_active' => $is_active
            ]);
            if ($user) {
                $user->assignRole(RoleEnum::STUDENT);
            }
            // Handle avatar upload
            $avatarPath = null;
            if ($request->hasFile('avatar')) {
                $avatarPath = $request->file('avatar')->store('students/avatars', 'public');
            }

            // Create student
            Student::create([
                'user_id' => $user->id,
                'school_id' => $request->school_id,
                'student_id_number' => $request->student_id_number,
                'grade' => $request->grade,
                'birth_date' => $request->birth_date,
                'gender' => $request->gender,
                'avatar' => $avatarPath,
                'parent_name' => $request->parent_name,
                'parent_phone' => $request->parent_phone,
                'parent_country_code' => $request->parent_country_code,
                'parent_relationship' => $request->parent_relationship,
            ]);

            DB::commit();

            return response()->json(['message' => 'Student created successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error creating student'], 500);

        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $student = Student::with(['user', 'school'])->findOrFail($id);
        return response()->json($student);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $student = Student::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $student->user_id,
            'phone_number' => 'required|string|max:20',
            'country_code' => 'required|string|max:10',
            'school_id' => 'required|exists:schools,id',
            'student_id_number' => 'required|string|max:30|unique:students,student_id_number,' . $student->id,
            'grade' => 'required|string|max:50',
            'birth_date' => 'required|date',
            'gender' => 'required|in:male,female',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'nullable|boolean',
            'parent_name' => 'nullable|string|max:255',
            'parent_phone' => 'nullable|string|max:20',
            'parent_country_code' => 'nullable|string|max:10',
            'parent_relationship' => 'nullable|integer|in:1,2,3,4',
        ]);

        if ($request->has('is_active')) {
            $is_active = $request->is_active;
        } else {
            $is_active = false;
        }
        try {
            // Check if changing to a different school and if that school has reached maximum students limit
            if ($request->school_id != $student->school_id) {
                $newSchool = School::findOrFail($request->school_id);
                if ($newSchool->wouldExceedMaxStudents()) {
                    $currentCount = $newSchool->getCurrentStudentsCount();
                    $maxStudents = $newSchool->max_students;
                    return response()->json([
                        'message' => "Cannot move student to this school. The school has reached its maximum student limit of {$maxStudents} students. Current count: {$currentCount}.",
                        'error' => 'max_students_exceeded'
                    ], 422);
                }
            }

            DB::beginTransaction();

            // Update user
            $student->user->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'country_code' => $request->country_code,
                'is_active' => $is_active
            ]);
            $student->user->assignRole(RoleEnum::STUDENT);

            // Handle avatar upload
            if ($request->hasFile('avatar')) {
                // Delete old avatar if exists
                if ($student->avatar) {
                    Storage::disk('public')->delete($student->avatar);
                }
                $avatarPath = $request->file('avatar')->store('students/avatars', 'public');
                $student->avatar = $avatarPath;
            }

            // Update student
            $oldGrade = $student->grade;
            $student->update([
                'school_id' => $request->school_id,
                'student_id_number' => $request->student_id_number,
                'grade' => $request->grade,
                'birth_date' => $request->birth_date,
                'gender' => $request->gender,
                'parent_name' => $request->parent_name,
                'parent_phone' => $request->parent_phone,
                'parent_country_code' => $request->parent_country_code,
                'parent_relationship' => $request->parent_relationship,
            ]);

            // Call refreshPathPointsForGradeChange if grade changed
            if ($oldGrade !== $request->grade) {
                $this->progressService->refreshPathPointsForGradeChange($student->id);
            }

            DB::commit();

            return response()->json(['message' => 'Student updated successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error updating student: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();

            $student = Student::findOrFail($id);

            // Delete avatar if exists
            if ($student->avatar) {
                Storage::disk('public')->delete($student->avatar);
            }

            // Delete associated user
            $student->user->delete();

            // Student will be deleted automatically due to foreign key constraint

            DB::commit();

            return response()->json(['success' => true , 'message' => 'Student deleted successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false , 'message' => 'Error deleting student: ' . $e->getMessage()], 500);
        }
    }
}
