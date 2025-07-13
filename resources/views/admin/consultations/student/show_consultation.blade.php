@extends('admin.layouts.master')
@section('title', __('Consultation Details'))

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
                        {{ __('Consultation Details') }}
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
                        <li class="breadcrumb-item text-muted">{{ __('Consultation') }}</li>
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
                                    $statusConfig = [
                                        1 => ['class' => 'secondary', 'icon' => 'lock', 'text' => 'Locked'],
                                        2 => ['class' => 'warning', 'icon' => 'play', 'text' => 'Active'],
                                        3 => ['class' => 'success', 'icon' => 'check', 'text' => 'Completed'],
                                        4 => ['class' => 'danger', 'icon' => 'times', 'text' => 'Skipped'],
                                    ];
                                    $config = $statusConfig[$progress->status] ?? $statusConfig[1];
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
                                        <i class="fa-solid fa-user-md me-1"></i>{{ __('Consultation') }}
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
                        <!--begin::Consultation Content Card-->
                        <div class="card card-flush h-md-100">
                            <!--begin::Card header-->
                            <div class="card-header">
                                <!--begin::Card title-->
                                <div class="card-title">
                                    <h3 class="fw-bold text-dark">
                                        <i class="fa-solid fa-user-md text-primary me-2"></i>{{ __('Consultation') }}
                                    </h3>
                                </div>
                                <!--end::Card title-->
                            </div>
                            <!--end::Card header-->

                            <!--begin::Card body-->
                            <div class="card-body pt-0">
                                @if(!$consultation)
                                    <!--begin::Waiting for schedule-->
                                    <div class="d-flex flex-column flex-center">
                                        <div class="symbol symbol-100px mb-5">
                                            <div class="symbol-label bg-light-warning">
                                                <i class="fa-solid fa-clock text-warning fs-1"></i>
                                            </div>
                                        </div>
                                        <div class="fs-1 fw-bolder text-gray-400 mb-5">{{ __('Waiting for Schedule') }}</div>
                                        <div class="fs-6 text-gray-600 text-center mb-8">
                                            {{ __('Your consultant will schedule a consultation session with you soon. You will be notified once the meeting is scheduled.') }}
                                        </div>
                                        <div class="alert alert-info d-flex align-items-center p-5">
                                            <div class="d-flex flex-column">
                                                <h4 class="mb-1 text-dark">{{ __('What to Expect') }}</h4>
                                                <span>{{ __('During the consultation, your consultant will review your progress and provide guidance based on your evaluation results.') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Waiting for schedule-->
                                @else
                                    @if($consultation->status === 'pending')
                                        <!--begin::Scheduled consultation-->
                                        <div class="d-flex flex-column">
                                            <div class="d-flex align-items-center mb-5">
                                                <div class="symbol symbol-50px me-3">
                                                    <div class="symbol-label bg-light-success">
                                                        <i class="fa-solid fa-calendar-check text-success fs-2"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h4 class="text-gray-800 fw-bold mb-1">{{ __('Consultation Scheduled') }}</h4>
                                                    <span class="text-gray-600 fw-semibold">{{ __('Your consultation session is ready') }}</span>
                                                </div>
                                            </div>

                                            <!--begin::Meeting details-->
                                            <div class="card bg-light-primary p-5 mb-8">
                                                <div class="row g-4">
                                                    <div class="col-md-6">
                                                        <div class="d-flex align-items-center">
                                                            <div class="symbol symbol-40px me-3">
                                                                <div class="symbol-label bg-primary">
                                                                    <i class="fa-solid fa-calendar text-white fs-6"></i>
                                                                </div>
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                <span class="text-gray-600 fw-semibold fs-7">{{ __('Date & Time') }}</span>
                                                                <div class="text-gray-800 fw-bold fs-6">
                                                                    {{ \Carbon\Carbon::parse($consultation->scheduled_at)->format('M d, Y') }}
                                                                </div>
                                                                <div class="text-gray-800 fw-bold fs-6">
                                                                    {{ \Carbon\Carbon::parse($consultation->scheduled_at)->format('h:i A') }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="d-flex align-items-center">
                                                            <div class="symbol symbol-40px me-3">
                                                                <div class="symbol-label bg-success">
                                                                    <i class="fa-solid fa-user-md text-white fs-6"></i>
                                                                </div>
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                <span class="text-gray-600 fw-semibold fs-7">{{ __('Consultant') }}</span>
                                                                <div class="text-gray-800 fw-bold fs-6">
                                                                    {{ $consultation->consultant->user->name }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @if($consultation->zoom_password)
                                                        <div class="col-md-6">
                                                            <div class="d-flex align-items-center">
                                                                <div class="symbol symbol-40px me-3">
                                                                    <div class="symbol-label bg-warning">
                                                                        <i class="fa-solid fa-lock text-white fs-6"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="flex-grow-1">
                                                                    <span class="text-gray-600 fw-semibold fs-7">{{ __('Meeting Password') }}</span>
                                                                    <div class="text-gray-800 fw-bold fs-6">
                                                                        {{ $consultation->zoom_password }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <!--end::Meeting details-->

                                            @php
                                                $scheduledTime = \Carbon\Carbon::parse($consultation->scheduled_at);
                                                $now = \Carbon\Carbon::now();
                                                $minutesUntilMeeting = $now->diffInMinutes($scheduledTime, false);
                                                $canJoin = $minutesUntilMeeting <= 15 && $minutesUntilMeeting >= -60;
                                            @endphp

                                            @if($canJoin)
                                                <div class="alert alert-success d-flex align-items-center p-5 mb-8">
                                                    <div class="d-flex flex-column">
                                                        <h4 class="mb-1 text-dark">{{ __('Meeting is Ready') }}</h4>
                                                        <span>{{ __('You can now join your consultation meeting.') }}</span>
                                                    </div>
                                                </div>
                                                <a href="{{ route('admin.student.consultation.join', ['consultation' => $consultation->id]) }}" class="btn btn-success btn-lg mb-3">
                                                    <i class="fa-solid fa-video me-2"></i>{{ __('Join Meeting') }}
                                                </a>
                                            @else
                                                @if($minutesUntilMeeting > 15)
                                                    <div class="alert alert-warning d-flex align-items-center p-5 mb-8">
                                                        <div class="d-flex flex-column">
                                                            <h4 class="mb-1 text-dark">{{ __('Meeting Not Started Yet') }}</h4>
                                                            <span>{{ __('The meeting will be available 15 minutes before the scheduled time.') }}</span>
                                                            <span class="mt-2">{{ __('Time remaining: ') . $scheduledTime->diffForHumans() }}</span>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="alert alert-danger d-flex align-items-center p-5 mb-8">
                                                        <div class="d-flex flex-column">
                                                            <h4 class="mb-1 text-dark">{{ __('Meeting Time Passed') }}</h4>
                                                            <span>{{ __('The scheduled meeting time has passed. Please contact your consultant to reschedule.') }}</span>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif

                                            <!--begin::Meeting instructions-->
                                            <div class="card bg-light-info p-5">
                                                <h5 class="text-gray-800 fw-bold mb-3">{{ __('Meeting Instructions') }}</h5>
                                                <ul class="text-gray-600 fw-semibold fs-6 mb-0">
                                                    <li class="mb-2">{{ __('Make sure you have a stable internet connection') }}</li>
                                                    <li class="mb-2">{{ __('Test your camera and microphone before joining') }}</li>
                                                    <li class="mb-2">{{ __('Join the meeting 5 minutes before the scheduled time') }}</li>
                                                    <li class="mb-2">{{ __('Have your evaluation results ready for discussion') }}</li>
                                                    <li>{{ __('Prepare any questions you want to ask your consultant') }}</li>
                                                </ul>
                                            </div>
                                            <!--end::Meeting instructions-->
                                        </div>
                                        <!--end::Scheduled consultation-->
                                    @elseif($consultation->status === 'done')
                                        <!--begin::Completed consultation-->
                                        <div class="d-flex flex-column">
                                            <div class="d-flex align-items-center mb-5">
                                                <div class="symbol symbol-50px me-3">
                                                    <div class="symbol-label bg-light-success">
                                                        <i class="fa-solid fa-check-circle text-success fs-2"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h4 class="text-gray-800 fw-bold mb-1">{{ __('Consultation Completed') }}</h4>
                                                    <span class="text-gray-600 fw-semibold">{{ __('Your consultation session is finished') }}</span>
                                                </div>
                                            </div>

                                            <div class="alert alert-success d-flex align-items-center p-5 mb-8">
                                                <div class="d-flex flex-column">
                                                    <h4 class="mb-1 text-dark">{{ __('Session Completed') }}</h4>
                                                    <span>{{ __('Your consultation session has been completed successfully. You can now view the consultation notes.') }}</span>
                                                </div>
                                            </div>

                                            @if($consultationNotes)
                                                <a href="{{ route('admin.student.consultation.notes', $consultation->id) }}" class="btn btn-primary btn-lg">
                                                    <i class="fa-solid fa-file-text me-2"></i>{{ __('View Consultation Notes') }}
                                                </a>
                                            @else
                                                <div class="alert alert-info d-flex align-items-center p-5">
                                                    <div class="d-flex flex-column">
                                                        <h4 class="mb-1 text-dark">{{ __('Notes Being Prepared') }}</h4>
                                                        <span>{{ __('Your consultant is preparing the consultation notes. They will be available shortly.') }}</span>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <!--end::Completed consultation-->
                                    @else
                                        <!--begin::Cancelled consultation-->
                                        <div class="d-flex flex-column">
                                            <div class="d-flex align-items-center mb-5">
                                                <div class="symbol symbol-50px me-3">
                                                    <div class="symbol-label bg-light-danger">
                                                        <i class="fa-solid fa-times-circle text-danger fs-2"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h4 class="text-gray-800 fw-bold mb-1">{{ __('Consultation Cancelled') }}</h4>
                                                    <span class="text-gray-600 fw-semibold">{{ __('This consultation session has been cancelled') }}</span>
                                                </div>
                                            </div>

                                            <div class="alert alert-danger d-flex align-items-center p-5 mb-8">
                                                <div class="d-flex flex-column">
                                                    <h4 class="mb-1 text-dark">{{ __('Session Cancelled') }}</h4>
                                                    <span>{{ __('This consultation session has been cancelled. A new session will be scheduled soon.') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Cancelled consultation-->
                                    @endif
                                @endif
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Consultation Content Card-->
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
