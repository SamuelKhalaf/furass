@extends('admin.layouts.master')
@section('title', __('Trip Students List'))
@section('content')
    <!--begin::Content wrapper-->
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                        {{ __('Trip Students List') }}
                    </h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">{{ __('Dashboard') }}</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.sub-admin.trips.index') }}" class="text-muted text-hover-primary">{{ __('Manage Trips') }}</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">{{ $event->event_name }}</li>
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
                <!--begin::Actions-->
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <a href="{{ route('admin.sub-admin.trips.index') }}" class="btn btn-sm btn-secondary">
                        <i class="fa-solid fa-arrow-left me-1"></i>{{ __('Back to Trips') }}
                    </a>
                    <a href="{{ route('admin.sub-admin.trip.attendance', [$program->id, $pathPoint->id]) }}" class="btn btn-sm btn-primary">
                        <i class="fa-solid fa-user-check me-1"></i>{{ __('Manage Attendance') }}
                    </a>
                </div>
                <!--end::Actions-->
            </div>
            <!--end::Toolbar container-->
        </div>
        <!--end::Toolbar-->

        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-fluid">
                <!--begin::Row-->
                <div class="row g-5 g-xl-8">
                    <!--begin::Col-->
                    <div class="col-xl-4">
                        <!--begin::Trip Details Card-->
                        <div class="card card-flush h-md-100">
                            <!--begin::Card header-->
                            <div class="card-header">
                                <!--begin::Card title-->
                                <div class="card-title">
                                    <h3 class="fw-bold text-dark">{{ __('Trip Details') }}</h3>
                                </div>
                                <!--end::Card title-->
                            </div>
                            <!--end::Card header-->

                            <!--begin::Card body-->
                            <div class="card-body pt-0">
                                <!--begin::Trip Info-->
                                <div class="d-flex flex-stack mb-4">
                                    <span class="text-gray-700 fw-bold fs-6">{{ __('Trip Name') }}</span>
                                    <span class="text-gray-800 fw-bolder fs-6">{{ $event->event_name }}</span>
                                </div>

                                <div class="d-flex flex-stack mb-4">
                                    <span class="text-gray-700 fw-bold fs-6">{{ __('Company') }}</span>
                                    <span class="text-gray-800 fw-bolder fs-6">{{ $event->company_name }}</span>
                                </div>

                                <div class="d-flex flex-stack mb-4">
                                    <span class="text-gray-700 fw-bold fs-6">{{ __('Location') }}</span>
                                    <span class="text-gray-800 fw-bolder fs-6">{{ $event->location }}</span>
                                </div>

                                <div class="d-flex flex-stack mb-4">
                                    <span class="text-gray-700 fw-bold fs-6">{{ __('Date') }}</span>
                                    <span class="text-gray-800 fw-bolder fs-6">{{ \Carbon\Carbon::parse($event->start_date)->format('M d, Y') }}</span>
                                </div>

                                <div class="d-flex flex-stack mb-4">
                                    <span class="text-gray-700 fw-bold fs-6">{{ __('Time') }}</span>
                                    <span class="text-gray-800 fw-bolder fs-6">
                                        {{ \Carbon\Carbon::parse($event->start_date)->format('h:i A') }} -
                                        {{ \Carbon\Carbon::parse($event->end_date)->format('h:i A') }}
                                    </span>
                                </div>

                                <div class="d-flex flex-stack mb-4">
                                    <span class="text-gray-700 fw-bold fs-6">{{ __('Total Students') }}</span>
                                    <span class="text-gray-800 fw-bolder fs-6">{{ $students->count() }}</span>
                                </div>

                                <!--begin::Statistics-->
                                <div class="separator separator-dashed my-5"></div>

                                @php
                                    $attendedCount = $students->filter(function($student) {
                                        return $student->tripAttendances->where('status', 'attended')->count() > 0;
                                    })->count();

                                    $absentCount = $students->filter(function($student) {
                                        return $student->tripAttendances->where('status', 'absent')->count() > 0;
                                    })->count();

                                    $evaluatedCount = $students->filter(function($student) {
                                        return $student->tripEvaluations->count() > 0;
                                    })->count();
                                @endphp

                                <div class="d-flex flex-stack mb-4">
                                    <div class="d-flex align-items-center me-2">
                                        <div class="symbol symbol-30px me-3">
                                            <div class="symbol-label bg-light-success">
                                                <i class="fa-solid fa-user-check text-success fs-5"></i>
                                            </div>
                                        </div>
                                        <span class="text-gray-700 fw-bold fs-6">{{ __('Attended') }}</span>
                                    </div>
                                    <span class="text-gray-800 fw-bolder fs-6">{{ $attendedCount }}</span>
                                </div>

                                <div class="d-flex flex-stack mb-4">
                                    <div class="d-flex align-items-center me-2">
                                        <div class="symbol symbol-30px me-3">
                                            <div class="symbol-label bg-light-danger">
                                                <i class="fa-solid fa-user-times text-danger fs-5"></i>
                                            </div>
                                        </div>
                                        <span class="text-gray-700 fw-bold fs-6">{{ __('Absent') }}</span>
                                    </div>
                                    <span class="text-gray-800 fw-bolder fs-6">{{ $absentCount }}</span>
                                </div>

                                <div class="d-flex flex-stack mb-4">
                                    <div class="d-flex align-items-center me-2">
                                        <div class="symbol symbol-30px me-3">
                                            <div class="symbol-label bg-light-warning">
                                                <i class="fa-solid fa-star text-warning fs-5"></i>
                                            </div>
                                        </div>
                                        <span class="text-gray-700 fw-bold fs-6">{{ __('Evaluated') }}</span>
                                    </div>
                                    <span class="text-gray-800 fw-bolder fs-6">{{ $evaluatedCount }}</span>
                                </div>
                                <!--end::Statistics-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Trip Details Card-->
                    </div>
                    <!--end::Col-->

                    <!--begin::Col-->
                    <div class="col-xl-8">
                        <!--begin::Students List Card-->
                        <div class="card card-flush h-md-100">
                            <!--begin::Card header-->
                            <div class="card-header">
                                <!--begin::Card title-->
                                <div class="card-title">
                                    <h3 class="fw-bold text-dark">{{ __('Students List') }}</h3>
                                </div>
                                <!--end::Card title-->
                            </div>
                            <!--end::Card header-->

                            <!--begin::Card body-->
                            <div class="card-body pt-0">
                                <!--begin::Table-->
                                <div class="table-responsive">
                                    <table class="table table-striped table-row-bordered gy-5 gs-7">
                                        <thead>
                                        <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                            <th class="min-w-200px">{{ __('Student Name') }}</th>
                                            <th class="min-w-150px">{{ __('School') }}</th>
                                            <th class="min-w-100px">{{ __('Attendance') }}</th>
                                            <th class="min-w-100px">{{ __('Evaluation') }}</th>
{{--                                            <th class="min-w-100px">{{ __('Certificate') }}</th>--}}
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($students as $student)
                                            @php
                                                $attendance = $student->tripAttendances->first();
                                                $evaluation = $student->tripEvaluations->first();
                                            @endphp
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="symbol symbol-50px me-3">
                                                            <div class="symbol-label bg-light-primary">
                                                                <i class="fa-solid fa-user text-primary fs-2"></i>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex flex-column">
                                                            <span class="text-gray-800 fw-bold">{{ $student->user->name }}</span>
                                                            <span class="text-gray-600 fw-semibold">{{ $student->user->email }}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="text-gray-800 fw-semibold">{{ $student->school->user->name ?? 'N/A' }}</span>
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
                                                    @else
                                                        <span class="badge badge-light-secondary">
                                                                <i class="fa-solid fa-clock me-1"></i>{{ __('Pending') }}
                                                            </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($evaluation)
                                                        <span class="badge badge-light-success">
                                                                <i class="fa-solid fa-star me-1"></i>{{ __('Completed') }}
                                                            </span>
                                                        <div class="text-muted fs-7 mt-1">
                                                            {{ __('Rating') }}: {{ $evaluation->rating }}/5
                                                        </div>
                                                    @else
                                                        <span class="badge badge-light-warning">
                                                                <i class="fa-solid fa-hourglass-half me-1"></i>{{ __('Pending') }}
                                                            </span>
                                                    @endif
                                                </td>
{{--                                                <td>--}}
{{--                                                    @if($attendance && $attendance->status == 'attended' && $evaluation)--}}
{{--                                                        <span class="badge badge-light-info">--}}
{{--                                                            <i class="fa-solid fa-certificate me-1"></i>{{ __('Available') }}--}}
{{--                                                        </span>--}}
{{--                                                    @else--}}
{{--                                                        <span class="badge badge-light-secondary">--}}
{{--                                                            <i class="fa-solid fa-lock me-1"></i>{{ __('Locked') }}--}}
{{--                                                        </span>--}}
{{--                                                    @endif--}}
{{--                                                </td>--}}
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!--end::Table-->

                                @if($students->isEmpty())
                                    <div class="d-flex flex-column flex-center py-10">
                                        <div class="symbol symbol-100px mb-5">
                                            <div class="symbol-label bg-light-info">
                                                <i class="fa-solid fa-users text-info fs-1"></i>
                                            </div>
                                        </div>
                                        <div class="fs-1 fw-bolder text-gray-400 mb-5">{{ __('No Students Found') }}</div>
                                        <div class="fs-6 text-gray-600 text-center">
                                            {{ __('No students are enrolled in this program yet.') }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Students List Card-->
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Row-->
            </div>
            <!--end::Content container-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Content wrapper-->
@endsection
