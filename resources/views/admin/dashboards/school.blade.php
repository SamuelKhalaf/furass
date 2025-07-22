@extends('admin.layouts.master')
@section('title', __('dashboard.title'))
@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-4 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-dark fw-bold fs-2x flex-column justify-content-center my-0">
                        {{ __('dashboard.school_analytics') }}
                    </h1>
                </div>
            </div>
        </div>
        <!--end::Toolbar-->

        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-fluid">
                <!-- Student Status in Programs Section -->
                <div class="row g-5 g-xl-8 mb-5 mb-xl-10">
                    <div class="col-12">
                        <div class="card card-flush">
                            <div class="card-header pt-7">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold text-gray-800">{{ __('dashboard.student_program_status') }}</span>
                                </h3>
                            </div>
                            <div class="card-body pt-6">
                                <div class="row g-5">
                                    @foreach($programsStatus as $program)
                                        <div class="col-xl-4">
                                            <div class="card bg-light-{{ ['primary', 'success', 'info'][$loop->index] }}">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center mb-5">
                                                        <div class="symbol symbol-40px me-3">
                                                    <span class="symbol-label bg-{{ ['primary', 'success', 'info'][$loop->index] }}">
                                                        <i class="fas fa-book text-white fs-4"></i>
                                                    </span>
                                                        </div>
                                                        <div>
                                                            <span class="text-gray-800 fw-bold fs-5">{{ $program['program_name'] }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="mb-4">
                                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                                            <span class="text-gray-700 fs-6">{{ __('dashboard.total_students') }}</span>
                                                            <span class="fw-bold text-{{ ['primary', 'success', 'info'][$loop->index] }}">{{ $program['total_students'] }}</span>
                                                        </div>
                                                        <div class="progress h-6px bg-light-{{ ['primary', 'success', 'info'][$loop->index] }}">
                                                            <div class="progress-bar bg-{{ ['primary', 'success', 'info'][$loop->index] }}" style="width: 100%"></div>
                                                        </div>
                                                    </div>
                                                    <div class="mb-4">
                                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                                            <span class="text-gray-700 fs-6">{{ __('dashboard.average_progress') }}</span>
                                                            <span class="fw-bold text-{{ ['primary', 'success', 'info'][$loop->index] }}">{{ number_format($program['progress_average'],1) }}%</span>
                                                        </div>
                                                        <div class="progress h-6px bg-light-{{ ['primary', 'success', 'info'][$loop->index] }}">
                                                            <div class="progress-bar bg-{{ ['primary', 'success', 'info'][$loop->index] }}" style="width: {{ $program['progress_average'] }}%"></div>
                                                        </div>
                                                    </div>
                                                    <div class="row g-2">
                                                        <div class="col-6 text-center">
                                                            <span class="text-gray-500 fs-7 d-block">{{ __('dashboard.active') }}</span>
                                                            <span class="text-gray-800 fw-bold fs-6">{{ $program['status_distribution']['active'] }}</span>
                                                        </div>
                                                        <div class="col-6 text-center">
                                                            <span class="text-gray-500 fs-7 d-block">{{ __('dashboard.completed') }}</span>
                                                            <span class="text-gray-800 fw-bold fs-6">{{ $program['status_distribution']['completed'] }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Interest Distribution Section -->
                <div class="row g-5 g-xl-8 mb-5 mb-xl-10">
                    <div class="col-xl-6">
                        <div class="card card-flush h-xl-100">
                            <div class="card-header pt-7">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold text-gray-800">{{ __('dashboard.interest_distribution') }}</span>
                                </h3>
                            </div>
                            <div class="card-body pt-6">
                                @forelse($interestDistribution as $index => $program)
                                    <div class="d-flex align-items-center mb-6">
                                        <span class="bullet bullet-vertical h-40px bg-{{ ['primary', 'success', 'warning', 'danger', 'info'][$index] }} me-5"></span>
                                        <div class="flex-grow-1">
                                            <span class="text-gray-800 fw-bold d-block fs-6">{{ $program['program_name'] }}</span>
                                            <span class="text-gray-500 fw-semibold fs-7">{{ $program['enrollment_count'] }} {{ __('dashboard.students') }}</span>
                                        </div>
                                        <div class="min-w-70px text-end">
                                            <span class="text-{{ ['primary', 'success', 'warning', 'danger', 'info'][$index] }} fw-bold fs-6">{{ number_format($program['percentage'],1) }}%</span>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-10">
                                        <span class="text-muted fs-6">{{ __('dashboard.no_data') }}</span>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Activity Evaluations Section -->
                    <div class="col-xl-6">
                        <div class="card card-flush h-xl-100">
                            <div class="card-header pt-7">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold text-gray-800">{{ __('dashboard.activity_evaluations') }}</span>
                                </h3>
                            </div>
                            <div class="card-body pt-6">
                                @forelse($activityEvaluations as $activity)
                                    <div class="d-flex align-items-center justify-content-between mb-6">
                                        <div class="d-flex align-items-center flex-grow-1">
                                            <div class="symbol symbol-45px me-5">
                                        <span class="symbol-label bg-light-{{ $activity['type'] == 'trip' ? 'success' : 'primary' }}">
                                            <i class="fa fa-{{ $activity['type'] == 'trip' ? 'bus' : 'chalkboard-teacher' }} text-{{ $activity['type'] == 'trip' ? 'success' : 'primary' }} fs-3"></i>
                                        </span>
                                            </div>
                                            <div class="flex-grow-1">
                                                <span class="text-gray-800 fw-bold d-block fs-6">{{ Str::limit($activity['name'], 30) }}</span>
                                                <span class="text-gray-500 fw-semibold fs-7">{{ $activity['evaluation_count'] }} {{ __('dashboard.evaluations') }}</span>
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <div class="d-flex align-items-center justify-content-end mb-1">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $activity['rating_stars']['full'])
                                                        <i class="fa fa-star text-warning fs-7"></i>
                                                    @elseif($i == $activity['rating_stars']['full'] + 1 && $activity['rating_stars']['half'])
                                                        <i class="fa fa-star-half-alt text-warning fs-7"></i>
                                                    @else
                                                        <i class="fa fa-star text-gray-300 fs-7"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                            <span class="text-gray-800 fw-bold fs-6">{{ $activity['avg_rating'] }}/5</span>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-10">
                                        <span class="text-muted fs-6">{{ __('dashboard.no_data') }}</span>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Participation Rates Section -->
                <div class="row g-5 g-xl-8 mb-5 mb-xl-10">
                    <div class="col-12">
                        <div class="card card-flush">
                            <div class="card-header pt-7">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold text-gray-800">{{ __('dashboard.participation_rates') }}</span>
                                </h3>
                            </div>
                            <div class="card-body pt-6">
                                <div class="row g-5">
                                    <!-- Attendance Rate -->
                                    <div class="col-xl-4">
                                        <div class="card bg-light-info">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center mb-5">
                                                    <div class="symbol symbol-40px me-3">
                                                    <span class="symbol-label bg-info">
                                                        <i class="fas fa-calendar-check text-white fs-4"></i>
                                                    </span>
                                                    </div>
                                                    <div>
                                                        <span class="text-gray-800 fw-bold fs-5">{{ __('dashboard.attendance_rate') }}</span>
                                                    </div>
                                                </div>
                                                <div class="mb-4">
                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                        <span class="text-gray-700 fs-6">{{ __('dashboard.attended_students') }}</span>
                                                        <span class="fw-bold text-info">{{ $participationRates['attending_students'] }}</span>
                                                    </div>
                                                    <div class="progress h-6px bg-light-info">
                                                        <div class="progress-bar bg-info" style="width: {{ number_format($participationRates['attendance_rate'],1) }}%"></div>
                                                    </div>
                                                </div>
                                                <div class="row g-2">
                                                    <div class="col-6 text-center">
                                                        <span class="text-gray-500 fs-7 d-block">{{ __('dashboard.total_students') }}</span>
                                                        <span class="text-gray-800 fw-bold fs-6">{{ $participationRates['total_students'] }}</span>
                                                    </div>
                                                    <div class="col-6 text-center">
                                                        <span class="text-gray-500 fs-7 d-block">{{ __('dashboard.attendance_rate') }}</span>
                                                        <span class="text-gray-800 fw-bold fs-6">{{ $participationRates['attendance_rate'] }}%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Activity Rate -->
                                    <div class="col-xl-4">
                                        <div class="card bg-light-success">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center mb-5">
                                                    <div class="symbol symbol-40px me-3">
                                                    <span class="symbol-label bg-success">
                                                        <i class="fas fa-tasks text-white fs-4"></i>
                                                    </span>
                                                    </div>
                                                    <div>
                                                        <span class="text-gray-800 fw-bold fs-5">{{ __('dashboard.activity_rate') }}</span>
                                                    </div>
                                                </div>
                                                <div class="mb-4">
                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                        <span class="text-gray-700 fs-6">{{ __('dashboard.active_students') }}</span>
                                                        <span class="fw-bold text-success">{{ $participationRates['active_students'] }}</span>
                                                    </div>
                                                    <div class="progress h-6px bg-light-success">
                                                        <div class="progress-bar bg-success" style="width: {{ $participationRates['activity_rate'] }}%"></div>
                                                    </div>
                                                </div>
                                                <div class="row g-2">
                                                    <div class="col-6 text-center">
                                                        <span class="text-gray-500 fs-7 d-block">{{ __('dashboard.total_students') }}</span>
                                                        <span class="text-gray-800 fw-bold fs-6">{{ $participationRates['total_students'] }}</span>
                                                    </div>
                                                    <div class="col-6 text-center">
                                                        <span class="text-gray-500 fs-7 d-block">{{ __('dashboard.activity_rate') }}</span>
                                                        <span class="text-gray-800 fw-bold fs-6">{{ $participationRates['activity_rate'] }}%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Engagement Rate -->
                                    <div class="col-xl-4">
                                        <div class="card bg-light-warning">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center mb-5">
                                                    <div class="symbol symbol-40px me-3">
                                                    <span class="symbol-label bg-warning">
                                                        <i class="fas fa-chart-line text-white fs-4"></i>
                                                    </span>
                                                    </div>
                                                    <div>
                                                        <span class="text-gray-800 fw-bold fs-5">{{ __('dashboard.engagement_rate') }}</span>
                                                    </div>
                                                </div>
                                                <div class="mb-4">
                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                        <span class="text-gray-700 fs-6">{{ __('dashboard.progressing_students') }}</span>
                                                        <span class="fw-bold text-warning">{{ $participationRates['progressing_students'] }}</span>
                                                    </div>
                                                    <div class="progress h-6px bg-light-warning">
                                                        <div class="progress-bar bg-warning" style="width: {{ $participationRates['engagement_rate'] }}%"></div>
                                                    </div>
                                                </div>
                                                <div class="row g-2">
                                                    <div class="col-6 text-center">
                                                        <span class="text-gray-500 fs-7 d-block">{{ __('dashboard.total_students') }}</span>
                                                        <span class="text-gray-800 fw-bold fs-6">{{ $participationRates['total_students'] }}</span>
                                                    </div>
                                                    <div class="col-6 text-center">
                                                        <span class="text-gray-500 fs-7 d-block">{{ __('dashboard.engagement_rate') }}</span>
                                                        <span class="text-gray-800 fw-bold fs-6">{{ $participationRates['engagement_rate'] }}%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
