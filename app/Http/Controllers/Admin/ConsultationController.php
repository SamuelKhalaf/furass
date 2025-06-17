<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PermissionEnum;
use App\Http\Controllers\Controller;
use App\Models\Consultant;
use App\Models\Consultation;
use App\Models\Student;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class ConsultationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.consultations.index');
    }

    public function getConsultationsData()
    {
        $consultations = Consultation::with(['consultant', 'student'])->get();

        return DataTables::of($consultations)
            ->addColumn('consultant.name', function ($consultation) {
                return $consultation->consultant->user->name;
            })
            ->addColumn('student.name', function ($consultation) {
                return $consultation->student->user->name;
            })
            ->addColumn('scheduled_at', function ($consultation) {
                return Carbon::parse($consultation->scheduled_at)->format('Y-m-d h:i A');
            })
            ->addColumn('status', function ($consultation) {
                return $consultation->status;
            })
            ->addColumn('actions', function ($consultation) {
                $actions = '';
                if (auth()->user()->hasAnyPermission([
                    PermissionEnum::UPDATE_CONSULTATIONS->value,
                    PermissionEnum::DELETE_CONSULTATIONS->value
                ])) {
                    $actions = '<a href="#" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    '.__("consultations.actions").'
                                    <span class="svg-icon svg-icon-5 m-0">
                                       <i class="fa-solid fa-caret-down"></i>
                                   </span>
                                </a>';

                    $actions .= '<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">';

                    if (auth()->user()->hasPermissionTo(PermissionEnum::UPDATE_CONSULTATIONS->value)) {
                        $actions .= '<div class="menu-item px-3">
                            <a href="#" class="menu-link px-3" data-user-id="' . $consultation->id . '" data-bs-toggle="modal" data-bs-target="#kt_modal_update_consultation">
                                '.__("consultations.edit").'
                            </a>
                        </div>';
                    }

                    if (auth()->user()->hasPermissionTo(PermissionEnum::DELETE_CONSULTATIONS->value)) {
                        $actions .= '<div class="menu-item px-3">
                            <a href="#" class="menu-link px-3" data-kt-users-table-filter="delete_row"
                               data-user-id="' . $consultation->id . '">'.__("consultations.delete").'</a>
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'consultant_id' => 'required|exists:consultants,id',
            'scheduled_at' => 'required|date',
            'status' => 'required|string',
            'zoom_meeting_id' => 'nullable|string',
            'zoom_join_url' => 'nullable|url',
            'zoom_start_url' => 'nullable|url',
            'zoom_password' => 'nullable|string',
        ]);
        Consultation::create($validated);
        return redirect()->route('consultations.index')->with('success', 'Consultation created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $consultation = Consultation::with(['consultant.user', 'student', 'notes'])->findOrFail($id);
        return view('admin.consultations.show', compact('consultation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $consultation = Consultation::findOrFail($id);
        $consultants = Consultant::with('user')->get();
        $students = Student::with('user')->get();
        return view('admin.consultations.edit', compact('consultation', 'consultants', 'students'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $consultation = Consultation::findOrFail($id);
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'consultant_id' => 'required|exists:consultants,id',
            'scheduled_at' => 'required|date',
            'status' => 'required|string',
            'zoom_meeting_id' => 'nullable|string',
            'zoom_join_url' => 'nullable|url',
            'zoom_start_url' => 'nullable|url',
            'zoom_password' => 'nullable|string',
        ]);
        $consultation->update($validated);
        return redirect()->route('consultations.index')->with('success', 'Consultation updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $consultation = Consultation::findOrFail($id);
        $consultation->delete();
        return redirect()->route('consultations.index')->with('success', 'Consultation deleted successfully.');
    }
}
