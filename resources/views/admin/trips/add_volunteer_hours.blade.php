@extends('admin.layouts.master')
@section('title', __('Add Volunteer Hours - Trip'))

@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                        {{ __('Add Volunteer Hours') }}
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
                                    <span class="text-gray-600 fw-semibold">{{ __('Program') }}</span>
                                    <span class="text-gray-800 fw-bold fs-6">{{ $program->title_en }}</span>
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
                                    <span class="text-gray-600 fw-semibold">{{ __('Total Students') }}</span>
                                    <span class="text-gray-800 fw-bold fs-6">{{ $students->count() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Trip Info Card-->

                <!--begin::Volunteer Hours Card-->
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="fw-bold text-dark">
                                <i class="fa-solid fa-clock text-success me-2"></i>{{ __('Student Volunteer Hours') }}
                            </h3>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($students->count() > 0)
                            <form method="POST" action="{{ route('admin.sub-admin.volunteer-hours.store', [$program->id, $pathPoint->id]) }}">
                                @csrf

                                <!--begin::Students List-->
                                <div class="table-responsive">
                                    <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                        <thead>
                                        <tr class="fw-bold text-muted">
                                            <th class="min-w-150px">{{ __('Student') }}</th>
                                            <th class="min-w-100px">{{ __('Student ID Number') }}</th>
                                            <th class="min-w-100px">{{ __('Volunteer Hours') }}</th>
                                            <th class="min-w-120px">{{ __('Volunteer Date') }}</th>
                                            <th class="min-w-200px">{{ __('Description') }}</th>
                                            <th class="min-w-100px">{{ __('Current Hours') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($students as $index => $student)
                                            @php
                                                $existingVolunteerHour = $student->volunteerHours->first();
                                            @endphp
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="symbol symbol-40px me-3">
                                                            <div class="symbol-label bg-light-success">
                                                                <span class="text-success fw-bold">{{ substr($student->user->name, 0, 2) }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex flex-column">
                                                            <span class="text-gray-800 fw-bold fs-6">{{ $student->user->name }}</span>
                                                            <span class="text-gray-600 fs-7">{{ $student->user->email }}</span>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="volunteer_hours[{{ $index }}][student_id]" value="{{ $student->id }}">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                           name="volunteer_hours[{{ $index }}][student_id_number]"
                                                           value="{{ $existingVolunteerHour->student_id_number ?? '' }}"
                                                           placeholder="{{ __('Enter ID Number') }}" required>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control form-control-sm"
                                                           name="volunteer_hours[{{ $index }}][hours]"
                                                           value="{{ $existingVolunteerHour->hours ?? '' }}"
                                                           step="1" min="1" max="100"
                                                           placeholder="0.0" required>
                                                </td>
                                                <td>
                                                    <input type="date" class="form-control form-control-sm"
                                                           name="volunteer_hours[{{ $index }}][volunteer_date]"
                                                           value="{{ $existingVolunteerHour ? $existingVolunteerHour->volunteer_date->format('Y-m-d') : \Carbon\Carbon::parse($event->start_date)->format('Y-m-d') }}"
                                                           required>
                                                </td>
                                                <td>
                                                    <textarea class="form-control form-control-sm"
                                                              name="volunteer_hours[{{ $index }}][description]"
                                                              rows="2" placeholder="{{ __('Optional description...') }}">{{ $existingVolunteerHour->description ?? '' }}</textarea>
                                                </td>
                                                <td>
                                                    @if($existingVolunteerHour)
                                                        <span class="badge badge-light-success">
                                                            <i class="fa-solid fa-clock me-1"></i>{{ $existingVolunteerHour->hours }} {{ __('hours') }}
                                                        </span>
                                                        <div class="text-muted fs-7 mt-1">
                                                            {{ $existingVolunteerHour->volunteer_date->format('M d, Y') }}
                                                        </div>
                                                    @else
                                                        <span class="badge badge-light-secondary">
                                                            <i class="fa-solid fa-plus me-1"></i>{{ __('New Entry') }}
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
                                    <button type="submit" class="btn btn-success btn-lg">
                                        <i class="fa-solid fa-save me-2"></i>{{ __('Save Volunteer Hours') }}
                                    </button>
                                </div>
                                <!--end::Actions-->
                            </form>
                        @else
                            <div class="d-flex flex-column flex-center py-10">
                                <div class="symbol symbol-100px mb-5">
                                    <div class="symbol-label bg-light-warning">
                                        <i class="fa-solid fa-exclamation-triangle text-warning fs-1"></i>
                                    </div>
                                </div>
                                <div class="fs-1 fw-bolder text-gray-400 mb-5">{{ __('No Attended Students') }}</div>
                                <div class="fs-6 text-gray-600 text-center">
                                    {{ __('Only students who have attended the trip can have volunteer hours recorded.') }}<br>
                                    {{ __('Please mark attendance first.') }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <!--end::Volunteer Hours Card-->
            </div>
        </div>
        <!--end::Content-->
    </div>
@endsection
