@extends('admin.layouts.master')

@section('title', __('dashboard.consultant_dashboard'))

@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-4 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-dark fw-bold fs-2x flex-column justify-content-center my-0">
                        {{ __('dashboard.consultant_dashboard') }}
                    </h1>
                </div>
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <div class="d-flex align-items-center">
                        <span class="text-muted fs-7 fw-semibold d-none d-md-inline">{{ now()->format('l, F j, Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Toolbar-->

        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-fluid">
                <!--begin::Statistics Row-->
                <div class="row g-5 g-xl-8 mb-5 mb-xl-10">
                    <!-- Total Students Card -->
                    <div class="col-xl-4">
                        <div class="card card-flush h-xl-100 bg-body card-hover border-primary border-opacity-25 border border-dashed">
                            <div class="card-body d-flex flex-column justify-content-between">
                                <div class="d-flex flex-center rounded-circle h-70px w-70px mb-5 bg-primary bg-opacity-10">
                                    <i class="fa fa-users text-primary fs-2x lh-0"></i>
                                </div>
                                <div>
                                    <span class="fs-6 fw-semibold text-gray-600 d-block">{{ __('dashboard.total_students') }}</span>
                                    <span class="fs-3x fw-bold text-gray-800">{{ $totalStudents }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Upcoming Sessions Card -->
                    <div class="col-xl-4">
                        <div class="card card-flush h-xl-100 bg-body card-hover border-warning border-opacity-25 border border-dashed">
                            <div class="card-body d-flex flex-column justify-content-between">
                                <div class="d-flex flex-center rounded-circle h-70px w-70px mb-5 bg-warning bg-opacity-10">
                                    <i class="fa fa-calendar-alt text-warning fs-2x lh-0"></i>
                                </div>
                                <div>
                                    <span class="fs-6 fw-semibold text-gray-600 d-block">{{ __('dashboard.upcoming_sessions') }}</span>
                                    <span class="fs-3x fw-bold text-gray-800">{{ $upcomingSessions }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Completed Sessions Card -->
                    <div class="col-xl-4">
                        <div class="card card-flush h-xl-100 bg-body card-hover border-success border-opacity-25 border border-dashed">
                            <div class="card-body d-flex flex-column justify-content-between">
                                <div class="d-flex flex-center rounded-circle h-70px w-70px mb-5 bg-success bg-opacity-10">
                                    <i class="fa fa-check-circle text-success fs-2x lh-0"></i>
                                </div>
                                <div>
                                    <span class="fs-6 fw-semibold text-gray-600 d-block">{{ __('dashboard.completed_sessions') }}</span>
                                    <span class="fs-3x fw-bold text-gray-800">{{ $completedSessions }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Statistics Row-->

                <!--begin::Recent Consultations Row-->
                <div class="row g-5 g-xl-8 mb-5 mb-xl-10">
                    <div class="col-xl-6">
                        <div class="card card-flush h-xl-100">
                            <div class="card-header pt-7">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold text-gray-800">{{ __('dashboard.recent_consultations') }}</span>
                                </h3>
                            </div>
                            <div class="card-body pt-6">
                                @forelse($recentConsultations as $consultation)
                                    <div class="d-flex align-items-center mb-6">
                                        <div class="symbol symbol-45px me-5">
                                            <span class="symbol-label bg-light-{{ $consultation['status'] == 'done' ? 'success' : 'primary' }}">
                                                <i class="fa fa-{{ $consultation['status'] == 'done' ? 'check' : 'calendar' }} text-{{ $consultation['status'] == 'done' ? 'success' : 'primary' }} fs-3"></i>
                                            </span>
                                        </div>
                                        <div class="flex-grow-1">
                                            <span class="text-gray-800 fw-bold d-block fs-6">{{ $consultation['student_name'] }}</span>
                                            <span class="text-gray-500 fw-semibold fs-7">{{ $consultation['date'] }}</span>
                                        </div>
                                        <div class="text-end">
                                            <span class="text-gray-800 fw-bold fs-6">
                                                {{ $consultation['has_notes'] ? __('dashboard.has_notes') : __('dashboard.no_notes') }}
                                            </span>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-10">
                                        <span class="text-muted fs-6">{{ __('dashboard.no_recent_consultations') }}</span>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Student Progress -->
                    <div class="col-xl-6">
                        <div class="card card-flush h-xl-100">
                            <div class="card-header pt-7">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold text-gray-800">{{ __('dashboard.student_progress') }}</span>
                                </h3>
                            </div>
                            <div class="card-body pt-6">
                                <div class="mb-6">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="text-gray-700 fs-6">{{ __('dashboard.active_students') }}</span>
                                        <span class="fw-bold text-primary">{{ $studentProgress['active_percentage'] }}%</span>
                                    </div>
                                    <div class="progress h-6px bg-light-primary">
                                        <div class="progress-bar bg-primary" style="width: {{ $studentProgress['active_percentage'] }}%"></div>
                                    </div>
                                    <div class="d-flex justify-content-between mt-2">
                                        <span class="text-gray-500 fs-7">{{ $studentProgress['active_students'] }} {{ __('dashboard.of') }} {{ $studentProgress['total_students'] }}</span>
                                    </div>
                                </div>

                                <div class="mb-6">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="text-gray-700 fs-6">{{ __('dashboard.making_progress') }}</span>
                                        <span class="fw-bold text-success">{{ $studentProgress['progress_percentage'] }}%</span>
                                    </div>
                                    <div class="progress h-6px bg-light-success">
                                        <div class="progress-bar bg-success" style="width: {{ $studentProgress['progress_percentage'] }}%"></div>
                                    </div>
                                    <div class="d-flex justify-content-between mt-2">
                                        <span class="text-gray-500 fs-7">{{ $studentProgress['progressing_students'] }} {{ __('dashboard.of') }} {{ $studentProgress['active_students'] }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Recent Consultations Row-->

                <!--begin::Students by Grade Row-->
                <div class="row g-5 g-xl-8 mb-5 mb-xl-10">
                    <div class="col-12">
                        <div class="card card-flush">
                            <div class="card-header pt-7">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold text-gray-800">{{ __('dashboard.students_by_grade') }}</span>
                                </h3>
                            </div>
                            <div class="card-body pt-6">
                                <div class="row g-5">
                                    <!-- Grade 10 -->
                                    <div class="col-md-4">
                                        <div class="d-flex align-items-center mb-6">
                                            <span class="bullet bullet-vertical h-40px bg-primary me-5"></span>
                                            <div class="flex-grow-1">
                                                <span class="text-gray-800 fw-bold d-block fs-6">{{ __('dashboard.grade_10') }}</span>
                                                <span class="text-gray-500 fw-semibold fs-7">{{ $studentsByGrade['grade_10'] }} {{ __('dashboard.students') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Grade 11 -->
                                    <div class="col-md-4">
                                        <div class="d-flex align-items-center mb-6">
                                            <span class="bullet bullet-vertical h-40px bg-success me-5"></span>
                                            <div class="flex-grow-1">
                                                <span class="text-gray-800 fw-bold d-block fs-6">{{ __('dashboard.grade_11') }}</span>
                                                <span class="text-gray-500 fw-semibold fs-7">{{ $studentsByGrade['grade_11'] }} {{ __('dashboard.students') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Grade 12 -->
                                    <div class="col-md-4">
                                        <div class="d-flex align-items-center mb-6">
                                            <span class="bullet bullet-vertical h-40px bg-warning me-5"></span>
                                            <div class="flex-grow-1">
                                                <span class="text-gray-800 fw-bold d-block fs-6">{{ __('dashboard.grade_12') }}</span>
                                                <span class="text-gray-500 fw-semibold fs-7">{{ $studentsByGrade['grade_12'] }} {{ __('dashboard.students') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Students by Grade Row-->
            </div>
        </div>
    </div>
@endsection
