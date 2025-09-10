<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Consultant;
use App\Models\School;
use App\Models\Student;
use App\Enums\RoleEnum;
use App\Services\IStudentProgressService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    protected IStudentProgressService $progressService;

    public function __construct(IStudentProgressService $progressService)
    {
        $this->progressService = $progressService;
    }

    /**
     * Display the user's profile.
     */
    public function show()
    {
        $user = auth()->user();
        $profileData = $this->getUserProfileData($user);

        return view('admin.profile.show', compact('user', 'profileData'));
    }

    /**
     * Show the form for editing the user's profile.
     */
    public function edit()
    {
        $user = auth()->user();
        $profileData = $this->getUserProfileData($user);

        return view('admin.profile.edit', compact('user', 'profileData'));
    }

    /**
     * Update the user's profile.
     */
    public function update(Request $request)
    {
        $user = auth()->user();


        // Base validation rules
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone_number' => ['required', 'string', 'max:255'],
            'country_code' => ['required', 'string', 'max:10'],
        ];

        // Add role-specific validation rules
        $this->addRoleSpecificValidationRules($rules, $user);

        $validatedData = $request->validate($rules);

        try {
            DB::beginTransaction();

            // Update base user data
            $user->update([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'phone_number' => $validatedData['phone_number'],
                'country_code' => $validatedData['country_code'],
            ]);

            // Update role-specific data
            $this->updateRoleSpecificData($request, $user, $validatedData);

            DB::commit();

            return redirect()->route('admin.profile.show')
                ->with('success', __('Profile updated successfully.'));

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'An error occurred while updating the profile.');
        }
    }

    /**
     * Show the form for editing the user's password.
     */
    public function editPassword()
    {
        return view('admin.profile.edit-password');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        auth()->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.profile.show')
            ->with('success', __('Password updated successfully.'));
    }

    /**
     * Get user profile data based on their role.
     */
    private function getUserProfileData($user)
    {
        $profileData = [
            'type' => 'admin',
            'additional_data' => null,
            'has_avatar' => false,
            'avatar_path' => null,
        ];

        if ($user->hasRole(RoleEnum::CONSULTANT->value)) {
            $consultant = Consultant::where('user_id', $user->id)->first();
            $profileData['type'] = 'consultant';
            $profileData['additional_data'] = $consultant;
            $profileData['has_avatar'] = false;
        } elseif ($user->hasRole(RoleEnum::SCHOOL->value)) {
            $school = School::where('user_id', $user->id)->first();
            $profileData['type'] = 'school';
            $profileData['additional_data'] = $school;
            $profileData['has_avatar'] = true;
            $profileData['avatar_path'] = $school?->logo;
        } elseif ($user->hasRole(RoleEnum::STUDENT->value)) {
            $student = Student::where('user_id', $user->id)->first();
            $profileData['type'] = 'student';
            $profileData['additional_data'] = $student;
            $profileData['has_avatar'] = true;
            $profileData['avatar_path'] = $student?->avatar;
        } elseif ($user->hasRole(RoleEnum::SUB_ADMIN->value)) {
            $profileData['type'] = 'sub_admin';
            $profileData['has_avatar'] = false;
        } else {
            $profileData['type'] = 'admin';
            $profileData['has_avatar'] = false;
        }

        return $profileData;
    }

    /**
     * Add role-specific validation rules.
     */
    private function addRoleSpecificValidationRules(&$rules, $user)
    {
        if ($user->hasRole(RoleEnum::CONSULTANT->value)) {
            $rules['bio'] = ['nullable', 'string', 'max:255'];
        } elseif ($user->hasRole(RoleEnum::SCHOOL->value)) {
            $rules['address'] = ['nullable', 'string', 'max:255'];
            $rules['logo'] = ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'];
            $rules['logo_remove'] = ['nullable', 'string', 'in:1'];
        } elseif ($user->hasRole(RoleEnum::STUDENT->value)) {
            $rules['grade'] = ['required', 'in:10,11,12'];
            $rules['birth_date'] = ['nullable', 'date', 'before:today'];
            $rules['gender'] = ['required', 'in:male,female'];
            $rules['avatar'] = ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'];
            $rules['avatar_remove'] = ['nullable', 'string', 'in:1'];
        }
    }

    /**
     * Update role-specific data.
     */
    private function updateRoleSpecificData($request, $user, $validatedData)
    {
        if ($user->hasRole(RoleEnum::CONSULTANT->value)) {
            $consultant = Consultant::where('user_id', $user->id)->first();
            if ($consultant) {
                $consultant->update([
                    'bio' => $request->bio,
                ]);
            }
        } elseif ($user->hasRole(RoleEnum::SCHOOL->value)) {
            $school = School::where('user_id', $user->id)->first();
            if ($school) {
                $updateData = [
                    'address' => $request->address,
                ];

                // Handle logo removal
                if ($request->has('logo_remove') && $request->logo_remove == '1') {
                    // Delete old logo from storage
                    if ($school->logo && Storage::disk('public')->exists($school->logo)) {
                        Storage::disk('public')->delete($school->logo);
                    }
                    $updateData['logo'] = null;
                }
                // Handle logo upload
                elseif ($request->hasFile('logo')) {
                    
                    // Delete old logo
                    if ($school->logo && Storage::disk('public')->exists($school->logo)) {
                        Storage::disk('public')->delete($school->logo);
                    }

                    $logoPath = $request->file('logo')->store('logos', 'public');
                    $updateData['logo'] = $logoPath;
                    
                }

                $school->update($updateData);
            }
        } elseif ($user->hasRole(RoleEnum::STUDENT->value)) {
            $student = Student::where('user_id', $user->id)->first();

            if ($student) {
                $oldGrade = $student->grade;
                $updateData = [
                    'grade' => $request->grade,
                    'birth_date' => $request->birth_date,
                    'gender' => $request->gender,
                ];

                // Call refreshPathPointsForGradeChange if grade changed
                if ($oldGrade !== $request->grade) {
                    $this->progressService->refreshPathPointsForGradeChange($student->id);
                }

                // Handle avatar removal
                if ($request->has('avatar_remove') && $request->avatar_remove == '1') {
                    // Delete old avatar from storage
                    if ($student->avatar && Storage::disk('public')->exists($student->avatar)) {
                        Storage::disk('public')->delete($student->avatar);
                    }
                    $updateData['avatar'] = null;
                }
                // Handle avatar upload
                elseif ($request->hasFile('avatar')) {
                    
                    // Delete old avatar
                    if ($student->avatar && Storage::disk('public')->exists($student->avatar)) {
                        Storage::disk('public')->delete($student->avatar);
                    }

                    $avatarPath = $request->file('avatar')->store('avatars', 'public');
                    $updateData['avatar'] = $avatarPath;
                    
                }

                $student->update($updateData);
            }
        }
    }
}
