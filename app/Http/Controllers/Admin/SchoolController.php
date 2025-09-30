<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PermissionEnum;
use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\Program;
use App\Models\School;
use App\Models\Student;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class SchoolController extends Controller
{
    public function index()
    {
        return view('admin.schools.index');
    }

    public function getSchoolsData()
    {
        $schools = School::with('user')->where('entity_type', 'school')->get();

        return DataTables::of($schools)
            ->addColumn('name', function ($school) {
                if ($school->logo) {
                    $logoUrl = asset('storage/' . $school->logo);
                    $imgTag = '<img src="' . $logoUrl . '" alt="Avatar" width="40" class="me-3 border" style="object-fit:cover; background:#f3f6f9; border-radius:6px;">';
                } else {
                    // Inline SVG placeholder
                    $imgTag = '<span class="rounded-circle me-3 border" style="width:40px;height:40px;background:#f3f6f9;display:flex;align-items:center;justify-content:center;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="8" r="4" fill="#b5b5c3"/>
                            <rect x="4" y="16" width="16" height="6" rx="3" fill="#b5b5c3"/>
                        </svg>
                    </span>';
                }
                $html = '<div class="d-flex align-items-center">';
                $html .= $imgTag;
                $html .= '<span>' . e($school->user->name) . '</span>';
                $html .= '</div>';
                return $html;
            })
            ->addColumn('address', function ($school) {
                return $school->address;
            })
            ->addColumn('email', function ($school) {
                return $school->user->email;
            })
            ->addColumn('phone', function ($school) {
                return $school->user->phone_number;
            })
            ->addColumn('entity_type', function ($school) {
                return $school->entity_type;
            })
            ->addColumn('actions', function ($school) {
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
                            <a href="#" class="menu-link px-3" data-user-id="' . $school->id . '" data-bs-toggle="modal" data-bs-target="#kt_modal_update_school">
                                '.__("schools.edit").'
                            </a>
                        </div>';
                    }

                    if (auth()->user()->hasPermissionTo(PermissionEnum::DELETE_SCHOOLS->value)) {
                        $actions .= '<div class="menu-item px-3">
                            <a href="#" class="menu-link px-3" data-kt-users-table-filter="delete_row"
                               data-user-id="' . $school->id . '">'.__("schools.delete").'</a>
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'phone_number' => 'required|string|max:20|unique:users',
            'country_code' => 'required|string|max:10',
            'entity_type' => 'nullable|in:school,company,educational_institution,consulting_firm,other',
            'address' => 'required|string',
            'max_students' => 'nullable|integer|min:1|max:999999',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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
                'role'          => RoleEnum::SCHOOL->value,
                'password'      => Hash::make($request->password),
                'is_active'     => $is_active
            ]);

            $user->assignRole(RoleEnum::SCHOOL->value);

            $school = new School();

            $school->user_id = $user->id;
            $school->address = $request->address;
            $school->entity_type = $request->entity_type ?? 'school';
            $school->max_students = $request->max_students;

            if ($request->hasFile('logo')) {
                $logo = $request->file('logo');
                $logoName = time() . '.' . $logo->getClientOriginalExtension();
                $logo->storeAs('public/schools/logos', $logoName);
                $school->logo = 'schools/logos/' . $logoName;
            }
            $school->save();
            DB::commit();
            if ($request->ajax()) {
                return response()->json(['message' => 'School created successfully']);
            }

            return redirect()->back()->with('success', 'Your Partnership requested successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            if ($request->ajax()) {
                return response()->json(['message' => 'Error creating school'], 500);
            }

            return redirect()->back()->with('error', 'Something went wrong. Please try again.');        }
    }

    public function edit(string $id)
    {
        $school = School::with(['user'])->findOrFail($id);
        return response()->json($school);
    }

    public function update(Request $request, School $school)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $school->user_id,
            'phone_number' => 'required|string|max:20|unique:users,phone_number,' . $school->user_id,
            'country_code' => 'required|string|max:10',
            'address' => 'required|string',
            'entity_type' => 'nullable|in:school,company,educational_institution,consulting_firm,other',
            'max_students' => 'nullable|integer|min:1|max:999999',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->has('is_active')) {
            $is_active = $request->is_active;
        } else {
            $is_active = false;
        }
        try {
            DB::beginTransaction();

            $user = $school->user;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone_number = $request->phone_number;
            $user->country_code = $request->country_code;
            $user->is_active = $is_active;
            $user->save();

            $school->address = $request->address;
            $school->entity_type = $request->entity_type ?? 'school';
            $school->max_students = $request->max_students;

            if ($request->hasFile('logo')) {
                if ($school->logo) {
                    Storage::delete('public/' . $school->logo);
                }

                $logo = $request->file('logo');
                $logoName = time() . '.' . $logo->getClientOriginalExtension();
                $logo->storeAs('public/schools/logos', $logoName);
                $school->logo = 'schools/logos/' . $logoName;
            }
            $school->save();
            DB::commit();

            return response()->json(['message' => 'School updated successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error updating School'] , 500);
        }

    }

    public function destroy(School $school)
    {
        try {
            DB::beginTransaction();

            if ($school->logo) {
                Storage::delete('public/' . $school->logo);
            }
            $school->user->delete();
            $school->delete();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'School deleted successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Error deleting School.'] , 500);
        }
    }

    public function inActiveStudents()
    {
        $schoolId = School::where('user_id', auth()->id())->first()->id;
        $inactiveStudents = $this->getInactiveStudents($schoolId);

        return view('admin.schools.in_active_students', [
            'inactiveStudents' => $inactiveStudents,
            'inactiveDaysThreshold' => 30
        ]);
    }

    public function getInactiveStudents($schoolId, $daysThreshold = 30)
    {
        return Student::where('school_id', $schoolId)
            ->where(function ($query) use ($daysThreshold) {
                // Students with no recent path progress
                $query->whereDoesntHave('studentPathProgress', function ($subQuery) use ($daysThreshold) {
                    $subQuery->where('updated_at', '>=', Carbon::now()->subDays($daysThreshold));
                })
                    ->orWhereHas('enrollments', function ($subQuery) {
                        // Students with active enrollments but no progress
                        $subQuery->where('status', 'active')
                            ->where('progress', 0);
                    });
            })
            ->with(['user', 'enrollments' => function ($query) {
                $query->where('status', 'active');
            }, 'studentPathProgress' => function ($query) {
                $query->orderBy('updated_at', 'desc')->limit(1);
            }])
            ->orderBy('created_at', 'asc')
            ->paginate(10);
    }

    public function studentProgramStatus()
    {
        $schoolId = School::where('user_id', auth()->id())->first()->id;

        $students = Student::where('school_id', $schoolId)
            ->with(['user', 'enrollments' => function($query) {
                $query->with('program')
                    ->orderBy('progress', 'desc');
            }, 'studentPathProgress'])
            ->orderBy('created_at', 'asc')
            ->paginate(10);

        return view('admin.schools.student_program_status', compact('students'));
    }

    // Companies methods
    public function companiesIndex()
    {
        return view('admin.schools.companies.index');
    }

    public function getCompaniesData()
    {
        $companies = School::with('user')->where('entity_type', 'company')->get();
        return $this->getEntityData($companies, false); // false = no edit button
    }

    // Educational Institutions methods
    public function educationalInstitutionsIndex()
    {
        return view('admin.schools.educational_institutions.index');
    }

    public function getEducationalInstitutionsData()
    {
        $institutions = School::with('user')->where('entity_type', 'educational_institution')->get();
        return $this->getEntityData($institutions, false); // false = no edit button
    }

    // Consulting Firms methods
    public function consultingFirmsIndex()
    {
        return view('admin.schools.consulting_firms.index');
    }

    public function getConsultingFirmsData()
    {
        $firms = School::with('user')->where('entity_type', 'consulting_firm')->get();
        return $this->getEntityData($firms, false); // false = no edit button
    }

    // Other Entities methods
    public function otherEntitiesIndex()
    {
        return view('admin.schools.other_entities.index');
    }

    public function getOtherEntitiesData()
    {
        $entities = School::with('user')->where('entity_type', 'other')->get();
        return $this->getEntityData($entities, false); // false = no edit button
    }

    // Helper method to generate DataTable for different entity types
    private function getEntityData($entities, $allowEdit = true)
    {
        return DataTables::of($entities)
            ->addColumn('name', function ($entity) {
                if ($entity->logo) {
                    $logoUrl = asset('storage/' . $entity->logo);
                    $imgTag = '<img src="' . $logoUrl . '" alt="Avatar" width="40" class="me-3 border" style="object-fit:cover; background:#f3f6f9; border-radius:6px;">';
                } else {
                    // Inline SVG placeholder
                    $imgTag = '<span class="rounded-circle me-3 border" style="width:40px;height:40px;background:#f3f6f9;display:flex;align-items:center;justify-content:center;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="8" r="4" fill="#b5b5c3"/>
                            <rect x="4" y="16" width="16" height="6" rx="3" fill="#b5b5c3"/>
                        </svg>
                    </span>';
                }
                $html = '<div class="d-flex align-items-center">';
                $html .= $imgTag;
                $html .= '<span>' . e($entity->user->name) . '</span>';
                $html .= '</div>';
                return $html;
            })
            ->addColumn('address', function ($entity) {
                return $entity->address;
            })
            ->addColumn('email', function ($entity) {
                return $entity->user->email;
            })
            ->addColumn('phone', function ($entity) {
                return $entity->user->phone_number;
            })
            ->addColumn('entity_type', function ($entity) {
                return ucfirst(str_replace('_', ' ', $entity->entity_type));
            })
            ->addColumn('actions', function ($entity) use ($allowEdit) {
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

                    if ($allowEdit && auth()->user()->hasPermissionTo(PermissionEnum::UPDATE_SCHOOLS->value)) {
                        $actions .= '<div class="menu-item px-3">
                            <a href="#" class="menu-link px-3" data-user-id="' . $entity->id . '" data-bs-toggle="modal" data-bs-target="#kt_modal_update_school">
                                '.__("schools.edit").'
                            </a>
                        </div>';
                    }

                    if (auth()->user()->hasPermissionTo(PermissionEnum::DELETE_SCHOOLS->value)) {
                        $actions .= '<div class="menu-item px-3">
                            <a href="#" class="menu-link px-3" data-kt-users-table-filter="delete_row"
                               data-user-id="' . $entity->id . '">'.__("schools.delete").'</a>
                        </div>';
                    }

                    $actions .= '</div>';
                }
                return $actions;
            })
            ->rawColumns(['name', 'actions'])
            ->make(true);
    }
}
