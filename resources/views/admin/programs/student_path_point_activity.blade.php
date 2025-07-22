@extends('admin.layouts.master')
@section('title', $pathPoint->{app()->getLocale() == 'ar' ? 'title_ar' : 'title_en'})
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
                        {{ $pathPoint->{app()->getLocale() == 'ar' ? 'title_ar' : 'title_en'} }}
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
                        <li class="breadcrumb-item text-muted">{{ $pathPoint->{app()->getLocale() == 'ar' ? 'title_ar' : 'title_en'} }}</li>
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
                <!--begin::Actions-->
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <a href="{{ route('admin.student.enrollments.show', $program->id) }}" class="btn btn-sm btn-secondary">
                        <i class="fa-solid fa-arrow-left me-1"></i>{{ __('Back to Program') }}
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
                        <!--begin::Path Point Details Card-->
                        <div class="card card-flush h-md-100">
                            <!--begin::Card header-->
                            <div class="card-header">
                                <!--begin::Card title-->
                                <div class="card-title">
                                    <h3 class="fw-bold text-dark">{{ __('Path Point Details') }}</h3>
                                </div>
                                <!--end::Card title-->
                            </div>
                            <!--end::Card header-->

                            <!--begin::Card body-->
                            <div class="card-body pt-0">
                                @php
                                    // Define status-based styling
                                    $statusConfig = [
                                        1 => ['class' => 'secondary', 'icon' => 'lock', 'text' => 'Locked'],
                                        2 => ['class' => 'warning', 'icon' => 'play', 'text' => 'Active'],
                                        3 => ['class' => 'success', 'icon' => 'check', 'text' => 'Completed'],
                                        4 => ['class' => 'danger', 'icon' => 'times', 'text' => 'Skipped'],
                                    ];

                                    $config = $statusConfig[$progress->status] ?? $statusConfig[1];

                                    // Table name to icon mapping
                                    $tableIcons = [
                                        'assessments' => 'clipboard-check',
                                        'evaluation_tests' => 'tasks',
                                        'events' => 'calendar-alt',
                                        'consultations' => 'user-md',
                                        'default' => 'book'
                                    ];

                                    $tableIcon = $tableIcons[$pathPoint->table_name] ?? $tableIcons['default'];
                                @endphp

                                    <!--begin::Status-->
                                <div class="d-flex flex-stack mb-5">
                                    <span class="text-gray-700 fw-bold fs-6">{{ __('Status') }}</span>
                                    <span class="badge badge-light-{{ $config['class'] }} fs-7 fw-bold">
                                        <i class="fa-solid fa-{{ $config['icon'] }} me-1"></i>{{ __($config['text']) }}
                                    </span>
                                </div>
                                <!--end::Status-->

                                <!--begin::Type-->
                                <div class="d-flex flex-stack mb-5">
                                    <span class="text-gray-700 fw-bold fs-6">{{ __('Type') }}</span>
                                    <span class="badge badge-light-info fs-7 fw-bold">
                                        <i class="fa-solid fa-{{ $tableIcon }} me-1"></i>{{ __(ucfirst(str_replace('_', ' ', $pathPoint->table_name))) }}
                                    </span>
                                </div>
                                <!--end::Type-->

                                <!--begin::Program-->
                                <div class="d-flex flex-stack mb-5">
                                    <span class="text-gray-700 fw-bold fs-6">{{ __('Program') }}</span>
                                    <span class="text-gray-800 fw-bolder fs-6">{{ $program->{app()->getLocale() == 'ar' ? 'title_ar' : 'title_en'} }}</span>
                                </div>
                                <!--end::Program-->

                                <!--begin::Description-->
                                @if($pathPoint->{app()->getLocale() == 'ar' ? 'description_ar' : 'description_en'})
                                    <div class="text-gray-800 fw-semibold fs-6 mb-8">
                                        {{ $pathPoint->{app()->getLocale() == 'ar' ? 'description_ar' : 'description_en'} }}
                                    </div>
                                @endif
                                <!--end::Description-->

                                <!--begin::Progress Stats-->
                                <div class="separator separator-dashed my-5"></div>
                                <div class="d-flex flex-column">
                                    @if($progress->score)
                                        <div class="d-flex flex-stack mb-4">
                                            <div class="d-flex align-items-center me-2">
                                                <div class="symbol symbol-30px me-3">
                                                    <div class="symbol-label bg-light-warning">
                                                        <i class="fa-solid fa-star text-warning fs-5"></i>
                                                    </div>
                                                </div>
                                                <span class="text-gray-700 fw-bold fs-6">{{ __('Score') }}</span>
                                            </div>
                                            <span class="text-gray-800 fw-bolder fs-6">{{ $progress->score }}</span>
                                        </div>
                                    @endif
                                    @if($progress->attempt_count > 0)
                                        <div class="d-flex flex-stack mb-4">
                                            <div class="d-flex align-items-center me-2">
                                                <div class="symbol symbol-30px me-3">
                                                    <div class="symbol-label bg-light-info">
                                                        <i class="fa-solid fa-redo text-info fs-5"></i>
                                                    </div>
                                                </div>
                                                <span class="text-gray-700 fw-bold fs-6">{{ __('Attempts') }}</span>
                                            </div>
                                            <span class="text-gray-800 fw-bolder fs-6">{{ $progress->attempt_count  }}</span>
                                        </div>
                                    @endif

                                    @if($progress->time_spent > 0)
                                        <div class="d-flex flex-stack mb-4">
                                            <div class="d-flex align-items-center me-2">
                                                <div class="symbol symbol-30px me-3">
                                                    <div class="symbol-label bg-light-secondary">
                                                        <i class="fa-solid fa-clock text-secondary fs-5"></i>
                                                    </div>
                                                </div>
                                                <span class="text-gray-700 fw-bold fs-6">{{ __('Time Spent') }}</span>
                                            </div>
                                            <span class="text-gray-800 fw-bolder fs-6">{{ gmdate('H:i:s', $progress->time_spent * 60) }}</span>
                                        </div>
                                    @endif

                                    @if($progress->completion_date)
                                        <div class="d-flex flex-stack mb-4">
                                            <div class="d-flex align-items-center me-2">
                                                <div class="symbol symbol-30px me-3">
                                                    <div class="symbol-label bg-light-success">
                                                        <i class="fa-solid fa-calendar-check text-success fs-5"></i>
                                                    </div>
                                                </div>
                                                <span class="text-gray-700 fw-bold fs-6">{{ __('Completed On') }}</span>
                                            </div>
                                            <span class="text-gray-800 fw-bolder fs-6">{{ \Carbon\Carbon::parse($progress->completion_date)->format('M d, Y') }}</span>
                                        </div>
                                    @endif
                                </div>
                                <!--end::Progress Stats-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Path Point Details Card-->
                    </div>
                    <!--end::Col-->

                    <!--begin::Col-->
                    <div class="col-xl-8">
                        <!--begin::Activity Content Card-->
                        <div class="card card-flush h-md-100">
                            <!--begin::Card header-->
                            <div class="card-header">
                                <!--begin::Card title-->
                                <div class="card-title">
                                    <h3 class="fw-bold text-dark">
                                        <i class="fa-solid fa-{{ $tableIcon }} text-primary me-2"></i>{{ __('Activity Content') }}
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
                                        <div class="fs-1 fw-bolder text-gray-400 mb-5">{{ __('Path Point Locked') }}</div>
                                        <div class="fs-6 text-gray-600 text-center mb-8">
                                            {{ __('This path point is currently locked. Complete the previous path points to unlock this activity.') }}
                                        </div>
                                    </div>
                                    <!--end::Locked state-->
                                @else
                                    <!--begin::Activity content based on table type-->
                                    @switch($pathPoint->table_name)
                                        @case('assessments')
                                            <!--begin::Assessment content-->
                                            <div class="d-flex flex-column">
                                                <div class="d-flex align-items-center mb-5">
                                                    <div class="symbol symbol-50px me-3">
                                                        <div class="symbol-label bg-light-primary">
                                                            <i class="fa-solid fa-clipboard-check text-primary fs-2"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h4 class="text-gray-800 fw-bold mb-1">{{ __('Assessment Activity') }}</h4>
                                                        <span class="text-gray-600 fw-semibold">{{ __('Complete the assessment to proceed') }}</span>
                                                    </div>
                                                </div>

                                                @if($progress->status == 2)
                                                    <div class="alert alert-primary d-flex align-items-center p-5 mb-10">
                                                        <div class="d-flex flex-column">
                                                            <h4 class="mb-1 text-dark">{{ __('Ready to Start') }}</h4>
                                                            <span>{{ __('Click the button below to begin your assessment.') }}</span>
                                                        </div>
                                                    </div>
                                                    <a href="#" class="btn btn-primary btn-lg">
                                                        <i class="fa-solid fa-play me-2"></i>{{ __('Start Assessment') }}
                                                    </a>
                                                @else
                                                    <div class="alert alert-success d-flex align-items-center p-5 mb-10">
                                                        <div class="d-flex flex-column">
                                                            <h4 class="mb-1 text-dark">{{ __('Assessment Completed') }}</h4>
                                                            <span>{{ __('You have successfully completed this assessment.') }}</span>
                                                        </div>
                                                    </div>
                                                    <a href="#" class="btn btn-success btn-lg">
                                                        <i class="fa-solid fa-eye me-2"></i>{{ __('View Results') }}
                                                    </a>
                                                @endif
                                            </div>
                                            <!--end::Assessment content-->
                                            @break

                                        @case('evaluation_tests')
                                            <!--begin::Evaluation test content-->
                                            <div class="d-flex flex-column">
                                                <div class="d-flex align-items-center mb-5">
                                                    <div class="symbol symbol-50px me-3">
                                                        <div class="symbol-label bg-light-info">
                                                            <i class="fa-solid fa-tasks text-info fs-2"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h4 class="text-gray-800 fw-bold mb-1">{{ __('Evaluation Test') }}</h4>
                                                        <span class="text-gray-600 fw-semibold">{{ __('Complete the evaluation test to proceed') }}</span>
                                                    </div>
                                                </div>

                                                @if($progress->status == 2)
                                                    <div class="alert alert-primary d-flex align-items-center p-5 mb-10">
                                                        <div class="d-flex flex-column">
                                                            <h4 class="mb-1 text-dark">{{ __('Ready to Start') }}</h4>
                                                            <span>{{ __('Click the button below to begin your evaluation test.') }}</span>
                                                        </div>
                                                    </div>
                                                    <a href="{{ route('admin.display.evaluation.test', [
                                                            'bank_id' => $pathPoint->meta['question_bank_type_id'],
                                                            'program_id' => $program->id,
                                                            'path_point_id' => $pathPoint->id
                                                        ]) }}" class="btn btn-primary btn-lg">
                                                        <i class="fa-solid fa-play me-2"></i>{{ __('Start Test') }}
                                                    </a>
                                                @else
                                                    <div class="alert alert-success d-flex align-items-center p-5 mb-10">
                                                        <div class="d-flex flex-column">
                                                            <h4 class="mb-1 text-dark">{{ __('Test Completed') }}</h4>
                                                            <span>{{ __('You have successfully completed this evaluation test.') }}</span>
                                                        </div>
                                                    </div>
                                                    <a href="{{route('admin.evaluation.result' , $pathPoint->meta['question_bank_type_id'])}}" class="btn btn-success btn-lg">
                                                        <i class="fa-solid fa-eye me-2"></i>{{ __('View Results') }}
                                                    </a>
                                                    <a href="{{ route('admin.display.evaluation.test', [
                                                            'bank_id' => $pathPoint->meta['question_bank_type_id'],
                                                            'program_id' => $program->id,
                                                            'path_point_id' => $pathPoint->id
                                                        ]) }}" class="btn btn-warning btn-lg mt-3">
                                                        <i class="fa-solid fa-rotate-right me-2"></i>{{ __('Retake Test') }}
                                                    </a>
                                                @endif
                                            </div>
                                            <!--end::Evaluation test content-->
                                            @break

                                        @case('events')
                                            @php
                                                $event_id = $pathPoint->meta['event_id'];
                                                $event = \App\Models\Event::where('id' , $event_id)->first();
                                            @endphp
                                            <!--begin::Event content-->
                                            <div class="d-flex flex-column">
                                                <div class="d-flex align-items-center mb-5">
                                                    <div class="symbol symbol-50px me-3">
                                                        <div class="symbol-label bg-light-warning">
                                                            <i class="fa-solid fa-calendar-alt text-warning fs-2"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h4 class="text-gray-800 fw-bold mb-1">{{ __('Event Activity') }}</h4>
                                                        <span class="text-gray-600 fw-semibold">{{ __('Attend the scheduled event') }}</span>
                                                    </div>
                                                </div>

                                                @if($progress->status == 2)
                                                    <div class="alert alert-warning d-flex align-items-center p-5 mb-10">
                                                        <div class="d-flex flex-column">
                                                            <h4 class="mb-1 text-dark">{{ __('Event Scheduled') }}</h4>
                                                            <span>{{ __('Please attend the scheduled event at the specified time.') }}</span>
                                                        </div>
                                                    </div>
                                                    @if($event->event_type == 'trip')
                                                        <a href="{{ route('admin.student.trip.show', ['program' => $program->id, 'pathPoint' => $pathPoint->id]) }}" class="btn btn-warning btn-lg">
                                                            <i class="fa-solid fa-info-circle me-2"></i>{{ __('View Event Details') }}
                                                        </a>
                                                    @else
                                                        <a href="{{ route('admin.student.workshop.show', ['program' => $program->id, 'pathPoint' => $pathPoint->id]) }}" class="btn btn-warning btn-lg">
                                                            <i class="fa-solid fa-info-circle me-2"></i>{{ __('View Event Details') }}
                                                        </a>
                                                    @endif
                                                @else
                                                    <div class="alert alert-success d-flex align-items-center p-5 mb-10">
                                                        <div class="d-flex flex-column">
                                                            <h4 class="mb-1 text-dark">{{ __('Event Completed') }}</h4>
                                                            <span>{{ __('You have successfully attended this event.') }}</span>
                                                        </div>
                                                    </div>
                                                    @if($event->event_type == 'trip')
                                                        <a href="{{ route('admin.student.trip.show', ['program' => $program->id, 'pathPoint' => $pathPoint->id]) }}" class="btn btn-success btn-lg">
                                                            <i class="fa-solid fa-eye me-2"></i>{{ __('View Event Summary') }}
                                                        </a>
                                                    @else
                                                        <a href="{{ route('admin.student.workshop.show', ['program' => $program->id, 'pathPoint' => $pathPoint->id]) }}" class="btn btn-success btn-lg">
                                                            <i class="fa-solid fa-eye me-2"></i>{{ __('View Event Summary') }}
                                                        </a>
                                                    @endif
                                                @endif
                                            </div>
                                            <!--end::Event content-->
                                            @break

                                        @case('consultations')
                                            <!--begin::Consultation content-->
                                            <div class="d-flex flex-column">
                                                <div class="d-flex align-items-center mb-5">
                                                    <div class="symbol symbol-50px me-3">
                                                        <div class="symbol-label bg-light-success">
                                                            <i class="fa-solid fa-user-md text-success fs-2"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h4 class="text-gray-800 fw-bold mb-1">{{ __('Consultation') }}</h4>
                                                        <span class="text-gray-600 fw-semibold">{{ __('Attend your consultation session') }}</span>
                                                    </div>
                                                </div>

                                                @if($progress->status == 2)
                                                    <div class="alert alert-info d-flex align-items-center p-5 mb-10">
                                                        <div class="d-flex flex-column">
                                                            <h4 class="mb-1 text-dark">{{ __('Consultation Scheduled') }}</h4>
                                                            <span>{{ __('Please attend your consultation at the scheduled time.') }}</span>
                                                        </div>
                                                    </div>
                                                    <a href="{{ route('admin.student.consultation.show', ['program' => $program->id, 'pathPoint' => $pathPoint->id]) }}" class="btn btn-info btn-lg">
                                                        <i class="fa-solid fa-calendar me-2"></i>{{ __('View Consultation Details') }}
                                                    </a>
                                                @else
                                                    <div class="alert alert-success d-flex align-items-center p-5 mb-10">
                                                        <div class="d-flex flex-column">
                                                            <h4 class="mb-1 text-dark">{{ __('Consultation Completed') }}</h4>
                                                            <span>{{ __('You have successfully completed your consultation.') }}</span>
                                                        </div>
                                                    </div>
                                                    <a href="{{ route('admin.student.consultation.notes' , ['consultation' => $consultation->id ?? 0]) }}" class="btn btn-success btn-lg">
                                                        <i class="fa-solid fa-eye me-2"></i>{{ __('View Consultation Notes') }}
                                                    </a>
                                                @endif
                                            </div>
                                            <!--end::Consultation content-->
                                            @break

                                        @default
                                            <!--begin::Default content-->
                                            <div class="d-flex flex-column">
                                                <div class="d-flex align-items-center mb-5">
                                                    <div class="symbol symbol-50px me-3">
                                                        <div class="symbol-label bg-light-primary">
                                                            <i class="fa-solid fa-book text-primary fs-2"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h4 class="text-gray-800 fw-bold mb-1">{{ __('Learning Activity') }}</h4>
                                                        <span class="text-gray-600 fw-semibold">{{ __('Complete this learning activity to proceed') }}</span>
                                                    </div>
                                                </div>

                                                @if($progress->status == 2)
                                                    <div class="alert alert-primary d-flex align-items-center p-5 mb-10">
                                                        <div class="d-flex flex-column">
                                                            <h4 class="mb-1 text-dark">{{ __('Ready to Start') }}</h4>
                                                            <span>{{ __('Click the button below to begin this activity.') }}</span>
                                                        </div>
                                                    </div>
                                                    <a href="#" class="btn btn-primary btn-lg">
                                                        <i class="fa-solid fa-play me-2"></i>{{ __('Start Activity') }}
                                                    </a>
                                                @else
                                                    <div class="alert alert-success d-flex align-items-center p-5 mb-10">
                                                        <div class="d-flex flex-column">
                                                            <h4 class="mb-1 text-dark">{{ __('Activity Completed') }}</h4>
                                                            <span>{{ __('You have successfully completed this activity.') }}</span>
                                                        </div>
                                                    </div>
                                                    <a href="#" class="btn btn-success btn-lg">
                                                        <i class="fa-solid fa-eye me-2"></i>{{ __('View Activity') }}
                                                    </a>
                                                @endif
                                            </div>
                                            <!--end::Default content-->
                                    @endswitch
                                    <!--end::Activity content based on table type-->
                                @endif
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Activity Content Card-->
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
