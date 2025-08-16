@php use App\Enums\RoleEnum; @endphp
@extends('admin.layouts.master')
@section('title', __('dashboard.title'))
@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-4 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-dark fw-bold fs-2x flex-column justify-content-center my-0">
                        {{ __('dashboard.multipurpose') }}
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
                    <div class="col-xl-3">
                        <div class="card card-flush h-xl-100 bg-body card-hover border-danger border-opacity-25 border border-dashed">
                            <div class="card-body d-flex flex-column justify-content-between">
                                <div class="d-flex flex-center rounded-circle h-70px w-70px mb-5 bg-danger bg-opacity-10">
                                    <i class="fa fa-user-tie text-danger fs-2x lh-0"></i>
                                </div>
                                <div>
                                    <span class="fs-6 fw-semibold text-gray-600 d-block">{{ __('dashboard.total_moderators') }}</span>
                                    <span class="fs-3x fw-bold text-gray-800">{{ $totalModerators }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3">
                        <div class="card card-flush h-xl-100 bg-body card-hover border-primary border-opacity-25 border border-dashed">
                            <div class="card-body d-flex flex-column justify-content-between">
                                <div class="d-flex flex-center rounded-circle h-70px w-70px mb-5 bg-primary bg-opacity-10">
                                    <i class="fa fa-headset text-primary fs-2x lh-0"></i>
                                </div>
                                <div>
                                    <span class="fs-6 fw-semibold text-gray-600 d-block">{{ __('dashboard.active_consultants') }}</span>
                                    <span class="fs-3x fw-bold text-gray-800">{{ $activeConsultants }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3">
                        <div class="card card-flush h-xl-100 bg-body card-hover border-success border-opacity-25 border border-dashed">
                            <div class="card-body d-flex flex-column justify-content-between">
                                <div class="d-flex flex-center rounded-circle h-70px w-70px mb-5 bg-success bg-opacity-10">
                                    <i class="fa fa-school text-success fs-2x lh-0"></i>
                                </div>
                                <div>
                                    <span class="fs-6 fw-semibold text-gray-600 d-block">{{ __('dashboard.registered_schools') }}</span>
                                    <span class="fs-3x fw-bold text-gray-800">{{ $registeredSchools }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3">
                        <div class="card card-flush h-xl-100 bg-body card-hover border-warning border-opacity-25 border border-dashed">
                            <div class="card-body d-flex flex-column justify-content-between">
                                <div class="d-flex flex-center rounded-circle h-70px w-70px mb-5 bg-warning bg-opacity-10">
                                    <i class="fa fa-users text-warning fs-2x lh-0"></i>
                                </div>
                                <div>
                                    <span class="fs-6 fw-semibold text-gray-600 d-block">{{ __('dashboard.total_students') }}</span>
                                    <span class="fs-3x fw-bold text-gray-800">{{ $totalStudents }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Statistics Row-->

                <!--begin::Analytics Row-->
                <div class="row g-5 g-xl-8 mb-5 mb-xl-10">
                    <div class="col-xl-6">
                        <div class="card card-flush h-xl-100">
                            <div class="card-header pt-7">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold text-gray-800">{{ __('dashboard.most_desired_programs') }}</span>
                                </h3>
                            </div>
                            <div class="card-body pt-6">
                                @forelse($mostDesiredPrograms as $index => $program)
                                    <div class="d-flex align-items-center mb-6">
                                        <span class="bullet bullet-vertical h-40px bg-{{ ['primary', 'success', 'warning', 'danger', 'info'][$index] }} me-5"></span>
                                        <div class="flex-grow-1">
                                            <span class="text-gray-800 fw-bold d-block fs-6">{{ $program['title'] }}</span>
                                            <span class="text-gray-500 fw-semibold fs-7">{{ $program['enrollment_count'] }} {{ __('dashboard.students_count') }}</span>
                                        </div>
                                        <div class="min-w-70px text-end">
                                            <span class="text-{{ ['primary', 'success', 'warning', 'danger', 'info'][$index] }} fw-bold fs-6">{{ $program['percentage'] }}%</span>
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

                    <div class="col-xl-6">
                        <div class="card card-flush h-xl-100">
                            <div class="card-header pt-7">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold text-gray-800">{{ __('dashboard.highest_rated_activities') }}</span>
                                </h3>
                            </div>
                            <div class="card-body pt-6">
                                @forelse($highestRatedActivities as $activity)
                                    <div class="d-flex align-items-center justify-content-between mb-6">
                                        <div class="d-flex align-items-center flex-grow-1">
                                            <div class="symbol symbol-45px me-5">
                                                <span class="symbol-label bg-light-{{ $activity['type'] == 'trip' ? 'success' : 'primary' }}">
                                                    <i class="fa fa-{{ $activity['type'] == 'trip' ? 'bus' : 'chalkboard-teacher' }} text-{{ $activity['type'] == 'trip' ? 'success' : 'primary' }} fs-3"></i>
                                                </span>
                                            </div>
                                            <div class="flex-grow-1">
                                                <span class="text-gray-800 fw-bold d-block fs-6">{{ Str::limit($activity['name'], 30) }}</span>
                                                <span class="text-gray-500 fw-semibold fs-7">{{ $activity['evaluation_count'] }} {{ __('dashboard.evaluations_count') }}</span>
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
                <!--end::Analytics Row-->

                <!--begin::Commitment Metrics Row-->
                <div class="row g-5 g-xl-8 mb-5 mb-xl-10">
                    <div class="col-12">
                        <div class="card card-flush">
                            <div class="card-header pt-7">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold text-gray-800">{{ __('dashboard.commitment_metrics') }}</span>
                                </h3>
                            </div>
                            <div class="card-body pt-6">
                                <div class="row g-5">
                                    <!-- Schools -->
                                    <div class="col-xl-4">
                                        <div class="card bg-light-info">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center mb-5">
                                                    <div class="symbol symbol-40px me-3">
                                                        <span class="symbol-label bg-info">
                                                            <i class="fa fa-school text-white fs-4"></i>
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <span class="text-gray-800 fw-bold fs-5">{{ __('dashboard.schools_commitment') }}</span>
                                                    </div>
                                                </div>
                                                <div class="mb-4">
                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                        <span class="text-gray-700 fs-6">{{ __('dashboard.activity_rate') }}</span>
                                                        <span class="fw-bold text-info">{{ $commitmentMetrics['schools']['commitment_rate'] }}%</span>
                                                    </div>
                                                    <div class="progress h-6px bg-light-info">
                                                        <div class="progress-bar bg-info" style="width: {{ $commitmentMetrics['schools']['commitment_rate'] }}%"></div>
                                                    </div>
                                                </div>
                                                <div class="mb-4">
                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                        <span class="text-gray-700 fs-6">{{ __('dashboard.overall_activity_rate') }}</span>
                                                        <span class="fw-bold text-info">{{ $commitmentMetrics['schools']['activity_rate'] }}%</span>
                                                    </div>
                                                    <div class="progress h-6px bg-light-info">
                                                        <div class="progress-bar bg-info" style="width: {{ $commitmentMetrics['schools']['activity_rate'] }}%"></div>
                                                    </div>
                                                </div>
                                                <div class="row g-2">
                                                    <div class="col-6 text-center">
                                                        <span class="text-gray-500 fs-7 d-block">{{ __('dashboard.active_schools') }}</span>
                                                        <span class="text-gray-800 fw-bold fs-6">{{ $commitmentMetrics['schools']['recently_active'] }}</span>
                                                    </div>
                                                    <div class="col-6 text-center">
                                                        <span class="text-gray-500 fs-7 d-block">{{ __('dashboard.total_schools') }}</span>
                                                        <span class="text-gray-800 fw-bold fs-6">{{ $commitmentMetrics['schools']['total'] }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Consultants -->
                                    <div class="col-xl-4">
                                        <div class="card bg-light-success">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center mb-5">
                                                    <div class="symbol symbol-40px me-3">
                                                        <span class="symbol-label bg-success">
                                                            <i class="fa fa-headset text-white fs-4"></i>
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <span class="text-gray-800 fw-bold fs-5">{{ __('dashboard.consultants_commitment') }}</span>
                                                    </div>
                                                </div>
                                                <div class="mb-4">
                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                        <span class="text-gray-700 fs-6">{{ __('dashboard.completed_sessions_rate') }}</span>
                                                        <span class="fw-bold text-success">{{ $commitmentMetrics['consultants']['commitment_rate'] }}%</span>
                                                    </div>
                                                    <div class="progress h-6px bg-light-success">
                                                        <div class="progress-bar bg-success" style="width: {{ $commitmentMetrics['consultants']['commitment_rate'] }}%"></div>
                                                    </div>
                                                </div>
                                                <div class="mb-4">
                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                        <span class="text-gray-700 fs-6">{{ __('dashboard.activity_rate') }}</span>
                                                        <span class="fw-bold text-success">{{ $commitmentMetrics['consultants']['activity_rate'] }}%</span>
                                                    </div>
                                                    <div class="progress h-6px bg-light-success">
                                                        <div class="progress-bar bg-success" style="width: {{ $commitmentMetrics['consultants']['activity_rate'] }}%"></div>
                                                    </div>
                                                </div>
                                                <div class="row g-2">
                                                    <div class="col-6 text-center">
                                                        <span class="text-gray-500 fs-7 d-block">{{ __('dashboard.completed_sessions') }}</span>
                                                        <span class="text-gray-800 fw-bold fs-6">{{ $commitmentMetrics['consultants']['completed_sessions'] }}</span>
                                                    </div>
                                                    <div class="col-6 text-center">
                                                        <span class="text-gray-500 fs-7 d-block">{{ __('dashboard.active_consultants_this_month') }}</span>
                                                        <span class="text-gray-800 fw-bold fs-6">{{ $commitmentMetrics['consultants']['active_this_month'] }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Students -->
                                    <div class="col-xl-4">
                                        <div class="card bg-light-warning">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center mb-5">
                                                    <div class="symbol symbol-40px me-3">
                                                        <span class="symbol-label bg-warning">
                                                            <i class="fa fa-users text-white fs-4"></i>
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <span class="text-gray-800 fw-bold fs-5">{{ __('dashboard.students_commitment') }}</span>
                                                    </div>
                                                </div>
                                                <div class="mb-4">
                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                        <span class="text-gray-700 fs-6">{{ __('dashboard.progress_rate') }}</span>
                                                        <span class="fw-bold text-warning">{{ $commitmentMetrics['students']['commitment_rate'] }}%</span>
                                                    </div>
                                                    <div class="progress h-6px bg-light-warning">
                                                        <div class="progress-bar bg-warning" style="width: {{ $commitmentMetrics['students']['commitment_rate'] }}%"></div>
                                                    </div>
                                                </div>
                                                <div class="mb-4">
                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                        <span class="text-gray-700 fs-6">{{ __('dashboard.engagement_rate') }}</span>
                                                        <span class="fw-bold text-warning">{{ $commitmentMetrics['students']['engagement_rate'] }}%</span>
                                                    </div>
                                                    <div class="progress h-6px bg-light-warning">
                                                        <div class="progress-bar bg-warning" style="width: {{ $commitmentMetrics['students']['engagement_rate'] }}%"></div>
                                                    </div>
                                                </div>
                                                <div class="row g-2">
                                                    <div class="col-6 text-center">
                                                        <span class="text-gray-500 fs-7 d-block">{{ __('dashboard.progressing_students') }}</span>
                                                        <span class="text-gray-800 fw-bold fs-6">{{ $commitmentMetrics['students']['making_progress'] }}</span>
                                                    </div>
                                                    <div class="col-6 text-center">
                                                        <span class="text-gray-500 fs-7 d-block">{{ __('dashboard.active_enrollments') }}</span>
                                                        <span class="text-gray-800 fw-bold fs-6">{{ $commitmentMetrics['students']['active_enrollments'] }}</span>
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
