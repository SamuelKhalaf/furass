@extends('admin.layouts.master')
@section('title', $event->event_name)
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
                        {{ $event->event_name }}
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
                            <a href="{{ route('admin.student.enrollments.index') }}" class="text-muted text-hover-primary">{{ __('My Programs') }}</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.student.enrollments.show', $program->id) }}" class="text-muted text-hover-primary">{{ $program->{app()->getLocale() == 'ar' ? 'title_ar' : 'title_en'} }}</a>
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
                    <a href="{{ route('admin.student.enrollments.show', $program->id) }}" class="btn btn-sm btn-secondary">
                        <i class="fa-solid fa-arrow-left me-1"></i>{{ __('workshops.management.back_to_program') }}
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

                @if(session('success'))
                    <div class="alert alert-success d-flex align-items-center p-5 mb-10">
                        <i class="fa-solid fa-check-circle fs-3 text-success me-3"></i>
                        <div class="d-flex flex-column">
                            <h4 class="mb-1 text-success">{{ __('Success') }}</h4>
                            <span>{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger d-flex align-items-center p-5 mb-10">
                        <i class="fa-solid fa-exclamation-triangle fs-3 text-danger me-3"></i>
                        <div class="d-flex flex-column">
                            <h4 class="mb-1 text-danger">{{ __('Error') }}</h4>
                            <span>{{ session('error') }}</span>
                        </div>
                    </div>
                @endif

                <!--begin::Row-->
                <div class="row g-5 g-xl-8">
                    <!--begin::Col-->
                    <div class="col-xl-4">
                        <!--begin::Workshop Status Card-->
                        <div class="card card-flush h-md-100">
                            <!--begin::Card header-->
                            <div class="card-header">
                                <!--begin::Card title-->
                                <div class="card-title">
                                    <h3 class="fw-bold text-dark">{{ __('workshops.management.workshop_status') }}</h3>
                                </div>
                                <!--end::Card title-->
                            </div>
                            <!--end::Card header-->

                            <!--begin::Card body-->
                            <div class="card-body pt-0">
                                @php
                                    $statusConfig = [
                                        1 => ['class' => 'secondary', 'icon' => 'lock', 'text' => 'Locked'],
                                        2 => ['class' => 'warning', 'icon' => 'clock', 'text' => 'Scheduled'],
                                        3 => ['class' => 'success', 'icon' => 'check', 'text' => 'Completed'],
                                        4 => ['class' => 'danger', 'icon' => 'times', 'text' => 'Missed'],
                                    ];
                                    $config = $statusConfig[$progress->status] ?? $statusConfig[1];
                                @endphp

                                    <!--begin::Status-->
                                <div class="d-flex flex-stack mb-5">
                                    <span class="text-gray-700 fw-bold fs-6">{{ __('workshops.management.status') }}</span>
                                    <span class="badge badge-light-{{ $config['class'] }} fs-7 fw-bold">
                                        <i class="fa-solid fa-{{ $config['icon'] }} me-1"></i>{{ __($config['text']) }}
                                    </span>
                                </div>
                                <!--end::Status-->

                                <!--begin::Program-->
                                <div class="d-flex flex-stack mb-5">
                                    <span class="text-gray-700 fw-bold fs-6">{{ __('workshops.management.program') }}</span>
                                    <span class="text-gray-800 fw-bolder fs-6">{{ $program->{app()->getLocale() == 'ar' ? 'title_ar' : 'title_en'} }}</span>
                                </div>
                                <!--end::Program-->

                                <!--begin::Workshop Facilitator-->
                                <div class="d-flex flex-stack mb-5">
                                    <span class="text-gray-700 fw-bold fs-6">{{ __('workshops.management.facilitator') }}</span>
                                    <span class="text-gray-800 fw-bolder fs-6">{{ $event->company_name }}</span>
                                </div>
                                <!--end::Workshop Facilitator-->

                                <!--begin::Location-->
                                <div class="d-flex flex-stack mb-5">
                                    <span class="text-gray-700 fw-bold fs-6">{{ __('workshops.management.location') }}</span>
                                    <span class="text-gray-800 fw-bolder fs-6">{{ $event->location }}</span>
                                </div>
                                <!--end::Location-->

                                @if($attendance)
                                    <!--begin::Attendance Status-->
                                    <div class="separator separator-dashed my-5"></div>
                                    <div class="d-flex flex-stack mb-5">
                                        <span class="text-gray-700 fw-bold fs-6">{{ __('workshops.management.attendance') }}</span>
                                        <span class="badge badge-light-{{ $attendance->status == 'attended' ? 'success' : 'danger' }} fs-7 fw-bold">
                                            <i class="fa-solid fa-{{ $attendance->status == 'attended' ? 'check' : 'times' }} me-1"></i>
                                            {{ __($attendance->status == 'attended' ? 'workshops.management.attended' : 'workshops.management.absent') }}
                                        </span>
                                    </div>
                                    <!--end::Attendance Status-->
                                @endif
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Workshop Status Card-->
                    </div>
                    <!--end::Col-->

                    <!--begin::Col-->
                    <div class="col-xl-8">
                        <!--begin::Workshop Details Card-->
                        <div class="card card-flush h-md-100">
                            <!--begin::Card header-->
                            <div class="card-header">
                                <!--begin::Card title-->
                                <div class="card-title">
                                    <h3 class="fw-bold text-dark">
                                        <i class="fa-solid fa-chalkboard-teacher text-primary me-2"></i>{{ __('workshops.management.workshop_details') }}
                                    </h3>
                                </div>
                                <!--end::Card title-->
                            </div>
                            <!--end::Card header-->

                            <!--begin::Card body-->
                            <div class="card-body pt-0">
                                @if($progress->status == 1)
                                    <!--begin::Locked state-->
                                    <div class="d-flex flex-column flex-center">
                                        <div class="symbol symbol-100px mb-5">
                                            <div class="symbol-label bg-light-secondary">
                                                <i class="fa-solid fa-lock text-secondary fs-1"></i>
                                            </div>
                                        </div>
                                        <div class="fs-1 fw-bolder text-gray-400 mb-5">{{ __('workshops.management.workshop_locked') }}</div>
                                        <div class="fs-6 text-gray-600 text-center mb-8">
                                            {{ __('workshops.management.workshop_locked_message') }}
                                        </div>
                                    </div>
                                    <!--end::Locked state-->
                                @else
                                    <!--begin::Basic Information-->
                                    <div class="mb-10">
                                        <div class="d-flex align-items-center mb-5">
                                            <i class="fa-solid fa-info-circle text-primary fs-2 me-3"></i>
                                            <h4 class="text-gray-800 fw-bold mb-0">{{ __('workshops.management.basic_information') }}</h4>
                                        </div>

                                        <div class="row g-5">
                                            <div class="col-md-6">
                                                <div class="d-flex flex-column">
                                                    <span class="text-gray-700 fw-bold fs-7">{{ __('workshops.management.workshop_name') }}</span>
                                                    <span class="text-gray-800 fw-bolder fs-6">{{ $event->event_name }}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex flex-column">
                                                    <span class="text-gray-700 fw-bold fs-7">{{ __('workshops.management.facilitator') }}</span>
                                                    <span class="text-gray-800 fw-bolder fs-6">{{ $event->company_name }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Basic Information-->

                                    <!--begin::Schedule-->
                                    <div class="mb-10">
                                        <div class="d-flex align-items-center mb-5">
                                            <i class="fa-solid fa-calendar-alt text-warning fs-2 me-3"></i>
                                            <h4 class="text-gray-800 fw-bold mb-0">{{ __('workshops.management.workshop_schedule') }}</h4>
                                        </div>

                                        <div class="row g-5">
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center mb-3">
                                                    <i class="fa-solid fa-clock text-success fs-5 me-2"></i>
                                                    <div>
                                                        <span class="text-gray-700 fw-bold fs-7 d-block">{{ __('workshops.management.start_time') }}</span>
                                                        <span class="text-gray-800 fw-bolder fs-6">{{ \Carbon\Carbon::parse($event->start_date)->format('M d, Y - h:i A') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center mb-3">
                                                    <i class="fa-solid fa-clock text-danger fs-5 me-2"></i>
                                                    <div>
                                                        <span class="text-gray-700 fw-bold fs-7 d-block">{{ __('workshops.management.end_time') }}</span>
                                                        <span class="text-gray-800 fw-bolder fs-6">{{ \Carbon\Carbon::parse($event->end_date)->format('M d, Y - h:i A') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="alert alert-light-info d-flex align-items-center p-5 mt-5">
                                            <i class="fa-solid fa-user-graduate text-info fs-3 me-3"></i>
                                            <div>
                                                <h5 class="text-info mb-1">{{ __('workshops.management.workshop_format') }}</h5>
                                                <span class="text-gray-700">{{ __('workshops.management.interactive_session') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Schedule-->

                                    <!--begin::Objectives-->
                                    <div class="mb-10">
                                        <div class="d-flex align-items-center mb-5">
                                            <i class="fa-solid fa-bullseye text-success fs-2 me-3"></i>
                                            <h4 class="text-gray-800 fw-bold mb-0">{{ __('workshops.management.workshop_objectives') }}</h4>
                                        </div>

                                        <div class="row g-3">
                                            <div class="col-12">
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="fa-solid fa-check-circle text-success fs-6 me-2"></i>
                                                    <span class="text-gray-700">{{ __('workshops.management.develop_practical_skills') }}</span>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="fa-solid fa-check-circle text-success fs-6 me-2"></i>
                                                    <span class="text-gray-700">{{ __('workshops.management.gain_hands_on_experience') }}</span>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="fa-solid fa-check-circle text-success fs-6 me-2"></i>
                                                    <span class="text-gray-700">{{ __('workshops.management.enhance_teamwork_skills') }}</span>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="fa-solid fa-check-circle text-success fs-6 me-2"></i>
                                                    <span class="text-gray-700">{{ __('workshops.management.build_confidence') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Objectives-->

                                    <!--begin::What to Bring-->
                                    <div class="mb-10">
                                        <div class="d-flex align-items-center mb-5">
                                            <i class="fa-solid fa-suitcase text-info fs-2 me-3"></i>
                                            <h4 class="text-gray-800 fw-bold mb-0">{{ __('workshops.management.what_to_bring') }}</h4>
                                        </div>

                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="fa-solid fa-id-card text-primary fs-6 me-2"></i>
                                                    <span class="text-gray-700">{{ __('workshops.management.id_card_school_card') }}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="fa-solid fa-laptop text-primary fs-6 me-2"></i>
                                                    <span class="text-gray-700">{{ __('workshops.management.laptop_if_required') }}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="fa-solid fa-notebook text-primary fs-6 me-2"></i>
                                                    <span class="text-gray-700">{{ __('workshops.management.notebook_and_pen') }}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="fa-solid fa-bottle-water text-primary fs-6 me-2"></i>
                                                    <span class="text-gray-700">{{ __('workshops.management.water_bottle') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::What to Bring-->

                                    <!--begin::Guidelines-->
                                    <div class="mb-10">
                                        <div class="d-flex align-items-center mb-5">
                                            <i class="fa-solid fa-exclamation-triangle text-warning fs-2 me-3"></i>
                                            <h4 class="text-gray-800 fw-bold mb-0">{{ __('workshops.management.workshop_guidelines') }}</h4>
                                        </div>

                                        <div class="alert alert-light-warning d-flex align-items-start p-5">
                                            <i class="fa-solid fa-info-circle text-warning fs-3 me-3 mt-1"></i>
                                            <div>
                                                <ul class="mb-0 ps-3">
                                                    <li class="text-gray-700 mb-2">{{ __('workshops.management.arrive_on_time') }}</li>
                                                    <li class="text-gray-700 mb-2">{{ __('workshops.management.minimize_phone_use') }}</li>
                                                    <li class="text-gray-700 mb-2">{{ __('workshops.management.participate_actively') }}</li>
                                                    <li class="text-gray-700 mb-2">{{ __('workshops.management.respect_others_opinions') }}</li>
                                                    <li class="text-gray-700 mb-2">{{ __('workshops.management.ask_questions') }}</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Guidelines-->

                                    @if($event->media_path)
                                        <!--begin::Media-->
                                        <div class="mb-10">
                                            <div class="d-flex align-items-center mb-5">
                                                <i class="fa-solid fa-play-circle text-primary fs-2 me-3"></i>
                                                <h4 class="text-gray-800 fw-bold mb-0">{{ __('workshops.management.introductory_materials') }}</h4>
                                            </div>

                                            <div class="card card-flush">
                                                <div class="card-body text-center">
                                                    @if(str_contains($event->media_path, '.mp4'))
                                                        <video controls class="w-100" style="max-height: 400px;">
                                                            <source src="{{ asset($event->media_path) }}" type="video/mp4">
                                                            {{ __('workshops.management.browser_not_support_video') }}
                                                        </video>
                                                    @else
                                                        <img src="{{ asset($event->media_path) }}" class="img-fluid rounded" alt="{{ $event->event_name }}">
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Media-->
                                    @endif

                                    @if($event->description)
                                        <!--begin::Description-->
                                        <div class="mb-10">
                                            <div class="d-flex align-items-center mb-5">
                                                <i class="fa-solid fa-align-left text-info fs-2 me-3"></i>
                                                <h4 class="text-gray-800 fw-bold mb-0">{{ __('workshops.management.about_the_workshop') }}</h4>
                                            </div>

                                            <div class="text-gray-700 fs-6 lh-lg">
                                                {{ $event->description }}
                                            </div>
                                        </div>
                                        <!--end::Description-->
                                    @endif

                                    @if($progress->status == 3)
                                        <!--begin::After Workshop Actions-->
                                        <div class="separator separator-dashed my-10"></div>
                                        <div class="mb-10">
                                            <div class="d-flex align-items-center mb-5">
                                                <i class="fa-solid fa-tasks text-success fs-2 me-3"></i>
                                                <h4 class="text-gray-800 fw-bold mb-0">{{ __('workshops.management.after_the_workshop') }}</h4>
                                            </div>

                                            <div class="row g-5">
                                                <div class="col-md-6">
                                                    @if (!$attendance)
                                                        {{-- Case: No attendance record --}}
                                                        <div class="card card-flush border-secondary">
                                                            <div class="card-body text-center">
                                                                <i class="fa-solid fa-clock text-muted fs-2x mb-3"></i>
                                                                <h5 class="text-muted mb-3">{{ __('workshops.management.pending_attendance') }}</h5>
                                                                <p class="text-gray-600 mb-4">
                                                                    {{ __('workshops.management.attendance_not_recorded') }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    @elseif ($attendance->status === 'absent')
                                                        {{-- Case: Absent --}}
                                                        <div class="card card-flush border-danger">
                                                            <div class="card-body text-center">
                                                                <i class="fa-solid fa-times-circle text-danger fs-2x mb-3"></i>
                                                                <h5 class="text-danger mb-3">{{ __('workshops.management.you_were_marked_absent') }}</h5>
                                                                <p class="text-gray-600 mb-4">{{ __('workshops.management.unfortunately_absent') }}</p>
                                                            </div>
                                                        </div>
                                                    @elseif (!$hasEvaluated && $attendance->status === 'attended')
                                                        {{-- Case: Attended but not evaluated --}}
                                                        <div class="card card-flush border-warning">
                                                            <div class="card-body text-center">
                                                                <i class="fa-solid fa-star text-warning fs-2x mb-3"></i>
                                                                <h5 class="text-warning mb-3">{{ __('workshops.management.workshop_evaluation') }}</h5>
                                                                <p class="text-gray-600 mb-4">{{ __('workshops.management.please_evaluate') }}</p>
                                                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#evaluationModal">
                                                                    <i class="fa-solid fa-edit me-2"></i>{{ __('workshops.management.evaluate_workshop') }}
                                                                </button>
                                                            </div>
                                                        </div>
                                                    @else
                                                        {{-- Case: Attended and evaluated --}}
                                                        <div class="card card-flush border-success">
                                                            <div class="card-body text-center">
                                                                <i class="fa-solid fa-check-circle text-success fs-2x mb-3"></i>
                                                                <h5 class="text-success mb-3">{{ __('workshops.management.evaluation_completed') }}</h5>
                                                                <p class="text-gray-600 mb-4">{{ __('workshops.management.thank_you_evaluation') }}</p>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="col-md-6">
                                                    @if($hasEvaluated && $attendance && $attendance->status == 'attended')
                                                        <div class="card card-flush border-primary">
                                                            <div class="card-body text-center">
                                                                <i class="fa-solid fa-certificate text-primary fs-2x mb-3"></i>
                                                                <h5 class="text-primary mb-3">{{ __('workshops.management.participation_certificate') }}</h5>
                                                                <p class="text-gray-600 mb-4">{{ __('workshops.management.download_certificate') }}</p>
                                                                <a target="_blank" href="{{ route('admin.student.trip.certificate', ['program' => $program->id, 'pathPoint' => $pathPoint->id]) }}" class="btn btn-primary">
                                                                    <i class="fa-solid fa-download me-2"></i>{{ __('workshops.management.download_certificate_button') }}
                                                                </a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="card card-flush border-secondary">
                                                            <div class="card-body text-center">
                                                                <i class="fa-solid fa-certificate text-secondary fs-2x mb-3"></i>
                                                                <h5 class="text-secondary mb-3">{{ __('workshops.management.certificate_available') }}</h5>
                                                                <p class="text-gray-600 mb-4">{{ __('workshops.management.complete_evaluation') }}</p>
                                                                <button class="btn btn-secondary" disabled>
                                                                    <i class="fa-solid fa-lock me-2"></i>{{ __('workshops.management.certificate_locked') }}
                                                                </button>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                        <!--end::After Workshop Actions-->
                                    @endif
                                @endif
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Workshop Details Card-->
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

    @if(!$hasEvaluated && $progress->status == 3)
        <!--begin::Evaluation Modal-->
        <div class="modal fade" id="evaluationModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form method="POST" action="{{ route('admin.student.workshop.evaluate', ['program' => $program->id, 'pathPoint' => $pathPoint->id]) }}">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">{{ __('workshops.management.workshop_evaluation') }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!--begin::Rating-->
                            <div class="mb-8">
                                <label class="required form-label">{{ __('workshops.management.overall_rating') }}</label>
                                <div class="rating-stars">
                                    @for($i = 1; $i <= 5; $i++)
                                        <input type="radio" name="rating" value="{{ $i }}" id="star{{ $i }}" required>
                                        <label for="star{{ $i }}" class="star-label">
                                            <i class="fa-solid fa-star text-warning fs-1"></i>
                                        </label>
                                    @endfor
                                </div>
                            </div>
                            <!--end::Rating-->

                            <!--begin::Feedback-->
                            <div class="mb-8">
                                <label class="required form-label">{{ __('workshops.management.workshop_feedback') }}</label>
                                <textarea name="feedback" class="form-control" rows="4" placeholder="{{ __('workshops.management.share_experience') }}" required></textarea>
                            </div>
                            <!--end::Feedback-->

                            <!--begin::Learning Outcomes-->
                            <div class="mb-8">
                                <label class="required form-label">{{ __('workshops.management.learning_outcomes') }}</label>
                                <textarea name="learning_outcomes" class="form-control" rows="4" placeholder="{{ __('workshops.management.what_skills_gained') }}" required></textarea>
                            </div>
                            <!--end::Learning Outcomes-->

                            <!--begin::Suggestions-->
                            <div class="mb-8">
                                <label class="form-label">{{ __('workshops.management.suggestions_improvement') }}</label>
                                <textarea name="suggestions" class="form-control" rows="3" placeholder="{{ __('workshops.management.improve_future_workshops') }}"></textarea>
                            </div>
                            <!--end::Suggestions-->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                            <button type="submit" class="btn btn-primary">{{ __('workshops.management.submit_evaluation') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--end::Evaluation Modal-->
    @endif
@endsection
