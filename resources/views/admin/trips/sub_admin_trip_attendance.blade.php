@extends('admin.layouts.master')
@section('title', __('Trip Attendance Management'))

@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                        {{ __('Trip Attendance') }}
                    </h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">{{ __('Dashboard') }}</a>
                        </li>
                        <li class="breadcrumb-item"><span class="bullet bg-gray-400 w-5px h-2px"></span></li>
                        <li class="breadcrumb-item text-muted">{{ $event->event_name }}</li>
                    </ul>
                </div>
                <!--begin::Actions-->
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <a href="{{ route('admin.sub-admin.trip.students', [$program->id, $pathPoint->id]) }}" class="btn btn-sm btn-secondary">
                        <i class="fa-solid fa-arrow-left me-1"></i>{{ __('View Students List') }}
                    </a>
                </div>
            </div>
        </div>
        <!--end::Toolbar-->

        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-fluid">
                @if(session('success'))
                    <div class="alert alert-success d-flex align-items-center p-5 mb-10">
                        <div class="d-flex flex-column">
                            <h4 class="mb-1 text-dark">{{ __('Success') }}</h4>
                            <span>{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger d-flex align-items-center p-5 mb-10">
                        <div class="d-flex flex-column">
                            <h4 class="mb-1 text-dark">{{ __('Error') }}</h4>
                            <span>{{ session('error') }}</span>
                        </div>
                    </div>
                @endif

                <!--begin::Trip Info Card-->
                <div class="card mb-5">
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="fw-bold text-dark">
                                <i class="fa-solid fa-info-circle text-primary me-2"></i>{{ __('Trip Information') }}
                            </h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="d-flex flex-column">
                                    <span class="text-gray-600 fw-semibold">{{ __('Trip Name') }}</span>
                                    <span class="text-gray-800 fw-bold fs-6">{{ $event->event_name }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex flex-column">
                                    <span class="text-gray-600 fw-semibold">{{ __('Company/Organization') }}</span>
                                    <span class="text-gray-800 fw-bold fs-6">{{ $event->company_name }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="separator separator-dashed my-5"></div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="d-flex flex-column">
                                    <span class="text-gray-600 fw-semibold">{{ __('Location') }}</span>
                                    <span class="text-gray-800 fw-bold fs-6">{{ $event->location }}</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex flex-column">
                                    <span class="text-gray-600 fw-semibold">{{ __('Date') }}</span>
                                    <span class="text-gray-800 fw-bold fs-6">{{ \Carbon\Carbon::parse($event->start_date)->format('M d, Y') }}</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex flex-column">
                                    <span class="text-gray-600 fw-semibold">{{ __('Time') }}</span>
                                    <span class="text-gray-800 fw-bold fs-6">{{ \Carbon\Carbon::parse($event->start_date)->format('h:i A') }} - {{ \Carbon\Carbon::parse($event->end_date)->format('h:i A') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Trip Info Card-->

                <!--begin::Attendance Card-->
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="fw-bold text-dark">
                                <i class="fa-solid fa-clipboard-check text-primary me-2"></i>{{ __('Student Attendance') }}
                            </h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.sub-admin.trip.update-attendance', [$program->id, $pathPoint->id]) }}">
                            @csrf

                            <!--begin::Students List-->
                            <div class="table-responsive">
                                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                    <thead>
                                    <tr class="fw-bold text-muted">
                                        <th class="min-w-150px">{{ __('Student') }}</th>
                                        <th class="min-w-100px">{{ __('School') }}</th>
                                        <th class="min-w-120px">{{ __('Attendance') }}</th>
                                        <th class="min-w-200px">{{ __('Notes') }}</th>
                                        <th class="min-w-100px">{{ __('Status') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($students as $student)
                                        @php
                                            $attendance = $attendanceRecords->get($student->id);
                                        @endphp
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="symbol symbol-40px me-3">
                                                        <div class="symbol-label bg-light-primary">
                                                            <span class="text-primary fw-bold">{{ substr($student->user->name, 0, 2) }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex flex-column">
                                                        <span class="text-gray-800 fw-bold fs-6">{{ $student->user->name }}</span>
                                                        <span class="text-gray-600 fs-7">{{ $student->user->email }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="text-gray-800 fw-semibold">{{ $student->school->user->name ?? 'N/A' }}</span>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-3">
                                                    <label class="form-check form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="radio" name="attendance[{{ $student->id }}]" value="attended"
                                                            {{ $attendance && $attendance->status == 'attended' ? 'checked' : '' }}>
                                                        <span class="form-check-label fw-bold text-success">
                                                            <i class="fa-solid fa-check me-1"></i>{{ __('Attended') }}
                                                        </span>
                                                    </label>
                                                    <label class="form-check form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="radio" name="attendance[{{ $student->id }}]" value="absent"
                                                            {{ $attendance && $attendance->status == 'absent' ? 'checked' : '' }}>
                                                        <span class="form-check-label fw-bold text-danger">
                                                            <i class="fa-solid fa-times me-1"></i>{{ __('Absent') }}
                                                        </span>
                                                    </label>
                                                </div>
                                            </td>
                                            <td>
                                                <textarea class="form-control form-control-sm" name="notes[{{ $student->id }}]" rows="2"
                                                          placeholder="{{ __('Optional notes...') }}">{{ $attendance->notes ?? '' }}</textarea>
                                            </td>
                                            <td>
                                                @if($attendance)
                                                    @if($attendance->status == 'attended')
                                                        <span class="badge badge-light-success">
                                                            <i class="fa-solid fa-check me-1"></i>{{ __('Attended') }}
                                                        </span>
                                                    @else
                                                        <span class="badge badge-light-danger">
                                                            <i class="fa-solid fa-times me-1"></i>{{ __('Absent') }}
                                                        </span>
                                                    @endif
                                                    <div class="text-muted fs-7 mt-1">
                                                        {{ $attendance->recorded_at ? $attendance->recorded_at->format('M d, Y H:i') : '' }}
                                                    </div>
                                                @else
                                                    <span class="badge badge-light-warning">
                                                        <i class="fa-solid fa-clock me-1"></i>{{ __('Pending') }}
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!--end::Students List-->

                            <!--begin::Actions-->
                            <div class="d-flex justify-content-end mt-10">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fa-solid fa-save me-2"></i>{{ __('Save Attendance') }}
                                </button>
                            </div>
                            <!--end::Actions-->
                        </form>
                    </div>
                </div>
                <!--end::Attendance Card-->
            </div>
        </div>
        <!--end::Content-->
    </div>

    <style>
        .form-check-input:checked + .form-check-label {
            color: var(--bs-primary);
        }
    </style>
@endsection
