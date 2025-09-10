@extends('admin.layouts.master')
@section('title', __('trips.management.manage_trips'))
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
                        {{ __('trips.management.manage_trips') }}
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
                        <li class="breadcrumb-item text-muted">{{ __('trips.management.manage_trips') }}</li>
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
            </div>
            <!--end::Toolbar container-->
        </div>
        <!--end::Toolbar-->

        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-fluid">
                <!--begin::Row-->
                <div class="row g-6 g-xl-9">
                    @forelse($trips as $trip)
                        @foreach($trip->programs_data as $programData)
                            <div class="col-md-6 col-xl-4">
                                <!--begin::Card-->
                                <div class="card card-flush h-md-100">
                                    <!--begin::Card header-->
                                    <div class="card-header">
                                        <!--begin::Card title-->
                                        <div class="card-title">
                                            <h3 class="fw-bold text-dark">{{ $trip->event->event_name }}</h3>
                                        </div>
                                        <!--end::Card title-->
                                        <!--begin::Card toolbar-->
                                        <div class="card-toolbar">
                                            <span class="badge badge-light-primary fs-8 fw-bold">
                                                {{ $trip->event->event_type }}
                                            </span>
                                        </div>
                                        <!--end::Card toolbar-->
                                    </div>
                                    <!--end::Card header-->

                                    <!--begin::Card body-->
                                    <div class="card-body pt-0">
                                        <!--begin::Trip Info-->
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="symbol symbol-30px me-3">
                                                <div class="symbol-label bg-light-info">
                                                    <i class="fa-solid fa-building text-info fs-5"></i>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <span class="text-gray-800 fw-bold fs-7">{{ $trip->event->company_name }}</span>
                                                <span class="text-gray-600 fw-semibold fs-8">{{ $trip->event->location }}</span>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center mb-3">
                                            <div class="symbol symbol-30px me-3">
                                                <div class="symbol-label bg-light-warning">
                                                    <i class="fa-solid fa-calendar text-warning fs-5"></i>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <span class="text-gray-800 fw-bold fs-7">{{ \Carbon\Carbon::parse($trip->event->start_date)->format('M d, Y') }}</span>
                                                <span class="text-gray-600 fw-semibold fs-8">
                                                    {{ \Carbon\Carbon::parse($trip->event->start_date)->format('h:i A') }} -
                                                    {{ \Carbon\Carbon::parse($trip->event->end_date)->format('h:i A') }}
                                                </span>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center mb-4">
                                            <div class="symbol symbol-30px me-3">
                                                <div class="symbol-label bg-light-success">
                                                    <i class="fa-solid fa-graduation-cap text-success fs-5"></i>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <span class="text-gray-800 fw-bold fs-7">{{ $programData['program']->{app()->getLocale() == 'ar' ? 'title_ar' : 'title_en'} }}</span>
                                                <span class="text-gray-600 fw-semibold fs-8">{{ __('Program') }}</span>
                                            </div>
                                        </div>

                                        <!--begin::Statistics-->
                                        <div class="separator separator-dashed my-4"></div>

                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="text-gray-600 fw-semibold fs-7">{{ __('trips.management.total_students') }}</span>
                                            <span class="text-gray-800 fw-bold fs-7">{{ $programData['total_students'] }}</span>
                                        </div>

                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="text-success fw-semibold fs-7">{{ __('trips.management.attended') }}</span>
                                            <span class="text-success fw-bold fs-7">{{ $programData['attended_count'] }}</span>
                                        </div>

                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="text-danger fw-semibold fs-7">{{ __('trips.management.absent') }}</span>
                                            <span class="text-danger fw-bold fs-7">{{ $programData['absent_count'] }}</span>
                                        </div>

                                        <div class="d-flex justify-content-between mb-4">
                                            <span class="text-warning fw-semibold fs-7">{{ __('trips.management.pending') }}</span>
                                            <span class="text-warning fw-bold fs-7">{{ $programData['pending_count'] }}</span>
                                        </div>

                                        <!--begin::Progress-->
                                        @php
                                            $completionPercentage = $programData['total_students'] > 0
                                                ? (($programData['attended_count'] + $programData['absent_count']) / $programData['total_students']) * 100
                                                : 0;
                                        @endphp
                                        <div class="d-flex align-items-center mb-4">
                                            <span class="text-gray-600 fw-semibold fs-7 me-2">{{ __('trips.management.progress') }}</span>
                                            <div class="progress bg-light-primary flex-grow-1 me-2" style="height: 6px">
                                                <div class="progress-bar bg-primary" style="width: {{ $completionPercentage }}%"></div>
                                            </div>
                                            <span class="text-gray-800 fw-bold fs-7">{{ round($completionPercentage) }}%</span>
                                        </div>
                                        <!--end::Progress-->
                                    </div>
                                    <!--end::Card body-->

                                    <!--begin::Card footer-->
                                    <div class="card-footer">
{{--                                        <div class="d-flex justify-content-between">--}}
                                            <a href="{{ route('admin.sub-admin.trip.students', [$programData['program']->id, $trip->id]) }}"
                                               class="btn btn-sm btn-light-primary">
                                                <i class="fa-solid fa-users me-1"></i>{{ __('trips.management.view_students') }}
                                            </a>
{{--                                            <a href="{{ route('admin.consultant.trip.attendance', [$programData['program']->id, $trip->id]) }}"--}}
{{--                                               class="btn btn-sm btn-primary">--}}
{{--                                                <i class="fa-solid fa-user-check me-1"></i>{{ __('Manage Attendance') }}--}}
{{--                                            </a>--}}
{{--                                        </div>--}}
                                    </div>
                                    <!--end::Card footer-->
                                </div>
                                <!--end::Card-->
                            </div>
                        @endforeach
                    @empty
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex flex-column flex-center py-10">
                                        <div class="symbol symbol-100px mb-5">
                                            <div class="symbol-label bg-light-primary">
                                                <i class="fa-solid fa-route text-primary fs-1"></i>
                                            </div>
                                        </div>
                                        <div class="fs-1 fw-bolder text-gray-400 mb-5">{{ __('trips.management.no_trips_found') }}</div>
                                        <div class="fs-6 text-gray-600 text-center">
                                            {{ __('trips.management.no_trips_enrolled') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>
                <!--end::Row-->
            </div>
            <!--end::Content container-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Content wrapper-->
@endsection
