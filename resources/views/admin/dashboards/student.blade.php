@extends('admin.layouts.master')
@section('title', __('dashboard.student_dashboard'))
@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-4 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-dark fw-bold fs-2x flex-column justify-content-center my-0">
                        {{ __('dashboard.welcome_back') }}, {{ $student->user->name }}
                    </h1>
                    <span class="text-muted fs-6 fw-semibold">{{ __('dashboard.track_your_learning_journey') }}</span>
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

                <!--begin::Progress Overview Row-->
                <div class="row g-5 g-xl-8 mb-5 mb-xl-10">
                    <div class="col-xl-3">
                        <div class="card card-flush h-xl-100 bg-primary bg-opacity-10 card-hover border-primary border-opacity-25 border border-dashed">
                            <div class="card-body d-flex flex-column justify-content-between">
                                <div class="d-flex flex-center rounded-circle h-70px w-70px mb-5 bg-primary bg-opacity-10">
                                    <i class="fa fa-graduation-cap text-primary fs-2x lh-0"></i>
                                </div>
                                <div>
                                    <span class="fs-6 fw-semibold text-gray-600 d-block">{{ __('dashboard.enrollment_progress') }}</span>
                                    <span class="fs-3x fw-bold text-gray-800">{{ $overallProgress['enrollment_completion_rate'] }}%</span>
                                    <span class="fs-7 text-muted d-block">{{ $overallProgress['completed_enrollments'] }}/{{ $overallProgress['total_enrollments'] }} {{ __('dashboard.programs') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3">
                        <div class="card card-flush h-xl-100 bg-success bg-opacity-10 card-hover border-success border-opacity-25 border border-dashed">
                            <div class="card-body d-flex flex-column justify-content-between">
                                <div class="d-flex flex-center rounded-circle h-70px w-70px mb-5 bg-success bg-opacity-10">
                                    <i class="fa fa-route text-success fs-2x lh-0"></i>
                                </div>
                                <div>
                                    <span class="fs-6 fw-semibold text-gray-600 d-block">{{ __('dashboard.path_progress') }}</span>
                                    <span class="fs-3x fw-bold text-gray-800">{{ $overallProgress['path_completion_rate'] }}%</span>
                                    <span class="fs-7 text-muted d-block">{{ $overallProgress['completed_path_points'] }}/{{ $overallProgress['total_path_points'] }} {{ __('dashboard.points') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3">
                        <div class="card card-flush h-xl-100 bg-info bg-opacity-10 card-hover border-info border-opacity-25 border border-dashed">
                            <div class="card-body d-flex flex-column justify-content-between">
                                <div class="d-flex flex-center rounded-circle h-70px w-70px mb-5 bg-info bg-opacity-10">
                                    <i class="fa fa-headset text-info fs-2x lh-0"></i>
                                </div>
                                <div>
                                    <span class="fs-6 fw-semibold text-gray-600 d-block">{{ __('dashboard.consultations') }}</span>
                                    <span class="fs-3x fw-bold text-gray-800">{{ $consultationStats['completion_rate'] }}%</span>
                                    <span class="fs-7 text-muted d-block">{{ $consultationStats['completed'] }}/{{ $consultationStats['total'] }} {{ __('dashboard.consultations') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3">
                        <div class="card card-flush h-xl-100 bg-warning bg-opacity-10 card-hover border-warning border-opacity-25 border border-dashed">
                            <div class="card-body d-flex flex-column justify-content-between">
                                <div class="d-flex flex-center rounded-circle h-70px w-70px mb-5 bg-warning bg-opacity-10">
                                    <i class="fa fa-calendar-check text-warning fs-2x lh-0"></i>
                                </div>
                                <div>
                                    <span class="fs-6 fw-semibold text-gray-600 d-block">{{ __('dashboard.event_attendance') }}</span>
                                    <span class="fs-3x fw-bold text-gray-800">{{ $eventStats['attendance_rate'] }}%</span>
                                    <span class="fs-7 text-muted d-block">{{ $eventStats['attended'] }}/{{ $eventStats['total_events'] }} {{ __('dashboard.events') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Progress Overview Row-->

                <!--begin::Performance & Activities Row-->
                <div class="row g-5 g-xl-8 mb-5 mb-xl-10">
                    <div class="col-xl-8">
                        <div class="card card-flush h-xl-100">
                            <div class="card-header pt-7">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold text-gray-800">{{ __('dashboard.learning_path_progress') }}</span>
                                    <span class="text-muted fs-7">{{ __('dashboard.your_progress_by_program') }}</span>
                                </h3>
                            </div>
                            <div class="card-body pt-6">
                                @forelse($pathProgress as $program)
                                    <div class="mb-8">
                                        <div class="d-flex align-items-center justify-content-between mb-4">
                                            <div>
                                                <span class="text-gray-800 fw-bold fs-6">{{ $program['program_title'] }}</span>
                                                <div class="text-muted fs-7">
                                                    {{ $program['completed_points'] }}/{{ $program['total_points'] }} {{ __('dashboard.points_completed') }}
                                                </div>
                                            </div>
                                            <div class="text-end">
                                                <span class="text-gray-800 fw-bold fs-6">{{ $program['completion_rate'] }}%</span>
                                            </div>
                                        </div>
                                        <div class="progress h-8px bg-light mb-2">
                                            <div class="progress-bar bg-primary" style="width: {{ $program['completion_rate'] }}%"></div>
                                        </div>
                                        @if($program['active_points'] > 0)
                                            <div class="text-primary fs-7 fw-semibold">
                                                <i class="fa fa-play-circle me-1"></i>
                                                {{ $program['active_points'] }} {{ __('dashboard.active_points') }}
                                            </div>
                                        @endif
                                    </div>
                                @empty
                                    <div class="text-center py-10">
                                        <span class="text-muted fs-6">{{ __('dashboard.no_enrolled_programs') }}</span>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4">
                        <div class="card card-flush h-xl-100">
                            <div class="card-header pt-7">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold text-gray-800">{{ __('dashboard.monthly_performance') }}</span>
                                </h3>
                            </div>
                            <div class="card-body pt-6">
                                <div class="mb-6">
                                    <div class="d-flex align-items-center mb-2">
                                        <span class="text-gray-700 fs-6 me-3">{{ __('dashboard.progress_this_month') }}</span>
                                        <span class="badge badge-light-primary fs-7">{{ $performanceMetrics['progress_this_month'] }}</span>
                                    </div>
                                    @if($performanceMetrics['progress_trend'] > 0)
                                        <div class="text-success fs-7">
                                            <i class="fa fa-arrow-up me-1"></i>
                                            +{{ $performanceMetrics['progress_trend'] }}% {{ __('dashboard.from_last_month') }}
                                        </div>
                                    @elseif($performanceMetrics['progress_trend'] < 0)
                                        <div class="text-danger fs-7">
                                            <i class="fa fa-arrow-down me-1"></i>
                                            {{ $performanceMetrics['progress_trend'] }}% {{ __('dashboard.from_last_month') }}
                                        </div>
                                    @else
                                        <div class="text-muted fs-7">{{ __('dashboard.no_change_from_last_month') }}</div>
                                    @endif
                                </div>

                                <div class="separator my-4"></div>

                                <div class="d-flex align-items-center justify-content-between mb-4">
                                    <span class="text-gray-700 fs-6">{{ __('dashboard.consultations_this_month') }}</span>
                                    <span class="text-gray-800 fw-bold">{{ $performanceMetrics['consultations_this_month'] }}</span>
                                </div>

                                <div class="d-flex align-items-center justify-content-between mb-4">
                                    <span class="text-gray-700 fs-6">{{ __('dashboard.events_attended') }}</span>
                                    <span class="text-gray-800 fw-bold">{{ $performanceMetrics['events_this_month'] }}</span>
                                </div>

                                <div class="d-flex align-items-center justify-content-between mb-4">
                                    <span class="text-gray-700 fs-6">{{ __('dashboard.total_tests') }}</span>
                                    <span class="text-gray-800 fw-bold">{{ number_format($performanceMetrics['total_tests']) }}</span>
                                </div>

                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="text-gray-700 fs-6">{{ __('dashboard.avg_attempts') }}</span>
                                    <span class="text-gray-800 fw-bold">{{ number_format($performanceMetrics['total_attempts']) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Performance & Activities Row-->

                <!--begin::Current Activities Row-->
                <div class="row g-5 g-xl-8 mb-5 mb-xl-10">

                    <!--begin::Certificates-->
                    <div class="col-xl-6">
                        <div class="card card-flush h-xl-100">
                            <div class="card-header pt-7">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold text-gray-800">
                                        <i class="fa fa-certificate text-primary me-2"></i>{{ __('dashboard.certificates') }}
                                    </span>
                                    <span class="text-muted fs-7">{{ __('dashboard.your_completed_events') }}</span>
                                </h3>
                            </div>
                            <div class="card-body pt-6">
                                @if(isset($certificates) && $certificates->count() > 0)
                                    <div class="scroll-y mh-300px pe-2">
                                        @foreach($certificates as $cert)
                                            <div class="d-flex align-items-center mb-5 p-3 bg-light rounded hover-elevate-up transition">
                                                <!--begin::Icon-->
                                                <div class="symbol symbol-40px me-4">
                                                    <span class="symbol-label bg-light-primary">
                                                        <i class="fa fa-award text-primary fs-4"></i>
                                                    </span>
                                                </div>
                                                <!--end::Icon-->

                                                <!--begin::Details-->
                                                <div class="flex-grow-1">
                                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                                        <span class="text-gray-800 fw-bold fs-6">{{ $cert->event_name }}</span>
                                                        <span class="badge badge-light-{{ $cert->event_type === 'trip' ? 'success' : 'info' }}">
                                                            {{ $cert->event_type === 'trip' ? __('dashboard.trip') : __('dashboard.workshop') }}
                                                        </span>
                                                    </div>
                                                    <div class="text-muted fs-8">
                                                        <i class="fa fa-calendar-alt me-1"></i>
                                                        {{ \Carbon\Carbon::parse($cert->start_date)->format('d M Y') }}
                                                    </div>
                                                </div>
                                                <!--end::Details-->

                                                <!--begin::Download/Action-->
                                                <div class="ms-3">
                                                    <a target="_blank" href="{{ route('admin.student.trip.certificate', ['program' => $cert->program_id, 'pathPoint' => $cert->path_point_id]) }}" class="btn btn-icon btn-sm btn-light-primary" title="{{ __('dashboard.download_certificate') }}">
                                                        <i class="fa fa-download"></i>
                                                    </a>
                                                </div>
                                                <!--end::Download/Action-->
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-10">
                                        <i class="fa fa-info-circle text-muted fs-2 mb-3"></i>
                                        <div class="text-muted fs-6">{{ __('dashboard.no_certificates') }}</div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!--end::Certificates-->

                    <!--begin::Recent Evaluations-->
                    <div class="col-xl-6">
                        <div class="card card-flush h-xl-100">
                            <div class="card-header pt-7">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold text-gray-800">{{ __('dashboard.recent_evaluations') }}</span>
                                    <span class="text-muted fs-7">{{ __('dashboard.your_event_feedback') }}</span>
                                </h3>
                            </div>
                            <div class="card-body pt-6">
                                @forelse($recentEvaluations as $evaluation)
                                    <div class="d-flex align-items-start mb-6">
                                        <div class="symbol symbol-40px me-4">
                                            <span class="symbol-label bg-light-{{ $evaluation['event_type'] == 'trip' ? 'success' : 'primary' }}">
                                                <i class="fa fa-{{ $evaluation['event_type'] == 'trip' ? 'bus' : 'chalkboard-teacher' }} text-{{ $evaluation['event_type'] == 'trip' ? 'success' : 'primary' }} fs-4"></i>
                                            </span>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <span class="text-gray-800 fw-bold fs-6">{{ $evaluation['event_name'] }}</span>
                                                <div class="d-flex align-items-center">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= $evaluation['rating'])
                                                            <i class="fa fa-star text-warning fs-7"></i>
                                                        @else
                                                            <i class="fa fa-star text-gray-300 fs-7"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                            </div>
                                            @if($evaluation['feedback'])
                                                <p class="text-gray-600 fs-7 mb-2">{{ Str::limit($evaluation['feedback'], 80) }}</p>
                                            @endif
                                            <div class="text-muted fs-8">{{ $evaluation['created_at']->diffForHumans() }}</div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-10">
                                        <span class="text-muted fs-6">{{ __('dashboard.no_evaluations') }}</span>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    <!--end::Recent Evaluations-->
                </div>
                <!--end::Current Activities Row-->
            </div>
        </div>
    </div>
@endsection

