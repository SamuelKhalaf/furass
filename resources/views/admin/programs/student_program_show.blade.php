@extends('admin.layouts.master')
@section('title', $program->{app()->getLocale() == 'ar' ? 'title_ar' : 'title_en'})
@section('content')
    @include('admin.layouts.includes.session_messages')
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
                        {{ $program->{app()->getLocale() == 'ar' ? 'title_ar' : 'title_en'} }}
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
                        <li class="breadcrumb-item text-muted">{{ $program->{app()->getLocale() == 'ar' ? 'title_ar' : 'title_en'} }}</li>
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
                <!--begin::Actions-->
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <a href="{{ route('admin.student.enrollments.index') }}" class="btn btn-sm btn-secondary">
                        <i class="fa-solid fa-arrow-left me-1"></i>{{ __('Back to Programs') }}
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
                        <!--begin::Program Overview Card-->
                        <div class="card card-flush h-md-100">
                            <!--begin::Card header-->
                            <div class="card-header">
                                <!--begin::Card title-->
                                <div class="card-title">
                                    <h3 class="fw-bold text-dark">{{ __('Program Overview') }}</h3>
                                </div>
                                <!--end::Card title-->
                            </div>
                            <!--end::Card header-->

                            <!--begin::Card body-->
                            <div class="card-body pt-0">
                                <!--begin::Description-->
                                <div class="text-gray-800 fw-semibold fs-6 mb-8">
                                    {{ $program->{app()->getLocale() == 'ar' ? 'description_ar' : 'description_en'} }}
                                </div>
                                <!--end::Description-->

                                <!--begin::Student Grade Info-->
                                <div class="d-flex flex-stack mb-5">
                                    <span class="text-gray-700 fw-bold fs-6">{{ __('Your Grade') }}</span>
                                    <span class="badge badge-light-info fs-7 fw-bold">{{ __('Grade') }} {{ $student->grade }}</span>
                                </div>
                                <!--end::Student Grade Info-->

                                <!--begin::Status-->
                                <div class="d-flex flex-stack mb-5">
                                    <span class="text-gray-700 fw-bold fs-6">{{ __('Status') }}</span>
                                    <span class="badge badge-light-primary fs-7 fw-bold">{{ __(ucfirst($enrollment->status ?? 'pending')) }}</span>
                                </div>
                                <!--end::Status-->

                                <!--begin::Progress-->
                                <div class="mb-8">
                                    <div class="d-flex align-items-center mb-2">
                                        <span class="text-gray-700 fw-bold fs-6 me-2">{{ __('Overall Progress') }}</span>
                                        <span class="badge badge-light fs-7">{{ $overallProgress }}%</span>
                                    </div>
                                    <div class="progress h-8px">
                                        <div class="progress-bar bg-primary" role="progressbar"
                                             style="width: {{ $overallProgress }}%"
                                             aria-valuenow="{{ $overallProgress }}"
                                             aria-valuemin="0"
                                             aria-valuemax="100">
                                        </div>
                                    </div>
                                </div>
                                <!--end::Progress-->

                                <!--begin::Certificate Section (Only show if program is completed)-->
                                @if($enrollment->status === 'attended' && $overallProgress >= 100)
                                    <div class="mb-8">
                                        <!--begin::Certificate Card-->
                                        <div class="card bg-light-success border-success border-dashed">
                                            <div class="card-body p-6">
                                                <!--begin::Header-->
                                                <h4 class="text-success fw-bold mb-1">{{ __('Congratulations!') }}</h4>
                                                <div class="d-flex align-items-center mb-4">
                                                    <div class="symbol symbol-40px me-4">
                                                        <div class="symbol-label bg-success">
                                                            <i class="fa-solid fa-trophy text-white fs-4"></i>
                                                        </div>
                                                    </div>
                                                    <div >
                                                        <p class="text-gray-700 fs-6 mb-0">{{ __('You have successfully completed this program') }}</p>
                                                    </div>
                                                </div>
                                                <!--end::Header-->

                                                <!--begin::Completion Info-->
{{--                                                <div class="d-flex flex-stack mb-4">--}}
{{--                                                    <span class="text-gray-700 fw-semibold fs-6">{{ __('Completed On') }}</span>--}}
{{--                                                    <span class="badge badge-success fs-7 fw-bold">{{ $enrollment->updated_at->format('M d, Y') }}</span>--}}
{{--                                                </div>--}}
                                                <!--end::Completion Info-->

                                                <!--begin::Certificate Download-->
                                                <div class="separator separator-dashed my-4"></div>
                                                <div class="d-flex flex-column">
                                                    <div class="d-flex align-items-center mb-3">
                                                        <div class="symbol symbol-30px me-3">
                                                            <div class="symbol-label bg-light-primary">
                                                                <i class="fa-solid fa-certificate text-primary fs-5"></i>
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <div class="fw-bold text-gray-800 fs-6">{{ __('Program Certificate') }}</div>
                                                            <div class="text-gray-500 fs-7">{{ __('Download your completion certificate') }}</div>
                                                        </div>
                                                    </div>
                                                    <a href="{{ route('admin.student.certificate.download', $program->id) }}"
                                                       class="btn btn-success btn-sm">
                                                        <i class="fa-solid fa-download me-2"></i>{{ __('Download Certificate') }}
                                                    </a>
                                                </div>
                                                <!--end::Certificate Download-->
                                            </div>
                                        </div>
                                        <!--end::Certificate Card-->
                                    </div>
                                @endif
                                <!--end::Certificate Section-->

                                <!--begin::Stats-->
                                <div class="d-flex flex-column">
                                    <div class="d-flex flex-stack mb-4">
                                        <div class="d-flex align-items-center me-2">
                                            <div class="symbol symbol-30px me-3">
                                                <div class="symbol-label bg-light-success">
                                                    <i class="fa-solid fa-list-check text-success fs-5"></i>
                                                </div>
                                            </div>
                                            <span class="text-gray-700 fw-bold fs-6">{{ __('Total Path Points') }}</span>
                                        </div>
                                        <span class="text-gray-800 fw-bolder fs-6">{{ $pathPoints->count() }}</span>
                                    </div>

                                    <div class="d-flex flex-stack mb-4">
                                        <div class="d-flex align-items-center me-2">
                                            <div class="symbol symbol-30px me-3">
                                                <div class="symbol-label bg-light-primary">
                                                    <i class="fa-solid fa-check-circle text-primary fs-5"></i>
                                                </div>
                                            </div>
                                            <span class="text-gray-700 fw-bold fs-6">{{ __('Completed') }}</span>
                                        </div>
                                        <span class="text-gray-800 fw-bolder fs-6">{{ $pathPoints->where('status', 3)->count() }}</span>
                                    </div>

                                    <div class="d-flex flex-stack mb-4">
                                        <div class="d-flex align-items-center me-2">
                                            <div class="symbol symbol-30px me-3">
                                                <div class="symbol-label bg-light-warning">
                                                    <i class="fa-solid fa-play-circle text-warning fs-5"></i>
                                                </div>
                                            </div>
                                            <span class="text-gray-700 fw-bold fs-6">{{ __('Active') }}</span>
                                        </div>
                                        <span class="text-gray-800 fw-bolder fs-6">{{ $pathPoints->where('status', 2)->count() }}</span>
                                    </div>

                                    <div class="d-flex flex-stack mb-4">
                                        <div class="d-flex align-items-center me-2">
                                            <div class="symbol symbol-30px me-3">
                                                <div class="symbol-label bg-light-secondary">
                                                    <i class="fa-solid fa-lock text-secondary fs-5"></i>
                                                </div>
                                            </div>
                                            <span class="text-gray-700 fw-bold fs-6">{{ __('Grade Locked') }}</span>
                                        </div>
                                        <span class="text-gray-800 fw-bolder fs-6">{{ $pathPoints->where('is_grade_locked', true)->count() }}</span>
                                    </div>

                                    <div class="d-flex flex-stack mb-4">
                                        <div class="d-flex align-items-center me-2">
                                            <div class="symbol symbol-30px me-3">
                                                <div class="symbol-label bg-light-info">
                                                    <i class="fa-solid fa-calendar-days text-info fs-5"></i>
                                                </div>
                                            </div>
                                            <span class="text-gray-700 fw-bold fs-6">{{ __('Enrolled On') }}</span>
                                        </div>
                                        <span class="text-gray-800 fw-bolder fs-6">{{ $enrollment->created_at->format('M d, Y') }}</span>
                                    </div>
                                </div>
                                <!--end::Stats-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Program Overview Card-->
                    </div>
                    <!--end::Col-->

                    <!--begin::Col-->
                    <div class="col-xl-8">
                        <!--begin::Program Path Card-->
                        <div class="card card-flush h-md-100">
                            <!--begin::Card header-->
                            <div class="card-header">
                                <!--begin::Card title-->
                                <div class="card-title">
                                    <h3 class="fw-bold text-dark">
                                        <i class="fa-solid fa-route text-primary me-2"></i>{{ __('Program Path') }}
                                    </h3>
                                </div>
                                <!--end::Card title-->
                            </div>
                            <!--end::Card header-->

                            <!--begin::Card body-->
                            <div class="card-body pt-0">
                                @if($pathPoints->count())
                                    <!--begin::Timeline-->
                                    <div class="timeline-label">
                                        @foreach($pathPoints as $index => $point)
                                            @php
                                                // Define status-based styling with grade lock consideration
                                                $statusConfig = [
                                                    1 => ['class' => 'secondary', 'icon' => 'lock', 'text' => 'Locked', 'clickable' => false],
                                                    2 => ['class' => 'warning', 'icon' => 'play', 'text' => 'Active', 'clickable' => true],
                                                    3 => ['class' => 'success', 'icon' => 'check', 'text' => 'Completed', 'clickable' => true],
                                                    4 => ['class' => 'danger', 'icon' => 'times', 'text' => 'Skipped', 'clickable' => false],
                                                ];

                                                // Override for grade-locked items
                                                if ($point->is_grade_locked) {
                                                    $config = [
                                                        'class' => 'dark',
                                                        'icon' => 'graduation-cap',
                                                        'text' => 'Grade Locked',
                                                        'clickable' => false
                                                    ];
                                                } else {
                                                    $config = $statusConfig[$point->status] ?? $statusConfig[1];
                                                }

                                                // Table name to icon mapping
                                                $tableIcons = [
                                                    'assessments' => 'clipboard-check',
                                                    'evaluation_tests' => 'tasks',
                                                    'events' => 'calendar-alt',
                                                    'consultations' => 'user-md',
                                                    'default' => 'book'
                                                ];

                                                $tableIcon = $tableIcons[$point->table_name] ?? $tableIcons['default'];
                                            @endphp

                                                <!--begin::Timeline item-->
                                            <div class="timeline-item">
                                                <!--begin::Timeline line-->
                                                <div class="timeline-line w-40px"></div>
                                                <!--end::Timeline line-->

                                                <!--begin::Timeline icon-->
                                                <div class="timeline-icon symbol symbol-circle symbol-40px">
                                                    <div class="symbol-label bg-{{ $config['class'] }}">
                                                        <i class="fa-solid fa-{{ $config['icon'] }} text-white fs-6"></i>
                                                    </div>
                                                </div>
                                                <!--end::Timeline icon-->

                                                <!--begin::Timeline content-->
                                                <div class="timeline-content mb-10 mt-n1">
                                                    <!--begin::Timeline heading-->
                                                    <div class="pe-3 mb-5">
                                                        <!--begin::Title-->
                                                        <div class="d-flex align-items-center">
                                                            <div class="fs-5 fw-bold text-gray-800 me-3">
                                                                {{ $point->{app()->getLocale() == 'ar' ? 'title_ar' : 'title_en'} }}
                                                            </div>
                                                            <span class="badge badge-light-{{ $config['class'] }} fs-8">{{ __($config['text']) }}</span>
                                                            @if($point->is_grade_locked)
                                                                <span class="badge badge-light-info fs-8 ms-2">{{ __('Grade') }} {{ $point->available_in_grade }}</span>
                                                            @endif
                                                        </div>
                                                        <!--end::Title-->

                                                        <!--begin::Description-->
                                                        <div class="d-flex align-items-center mt-2 fs-6">
                                                            <div class="text-muted me-2 fs-7">{{ __('Type') }}:</div>
                                                            <span class="badge badge-light-info fs-7">{{ __(ucfirst(str_replace('_', ' ', $point->table_name))) }}</span>
                                                            <div class="text-muted me-2 ms-4 fs-7">{{ __('Order') }}:</div>
                                                            <span class="badge badge-light fs-7">#{{ $point->order }}</span>
                                                        </div>
                                                        <!--end::Description-->

                                                        <!--begin::Grade Lock Message-->
                                                        @if($point->is_grade_locked && $point->grade_lock_message)
                                                            <div class="mt-2">
                                                                <div class="alert alert-dismissible bg-light-warning border border-warning border-dashed d-flex flex-column flex-sm-row p-5 mb-3">
                                                                    <div class="d-flex flex-column pe-0 pe-sm-10">
                                                                        <span class="fs-7 text-warning">{{ $point->grade_lock_message }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                        <!--end::Grade Lock Message-->
                                                    </div>
                                                    <!--end::Timeline heading-->

                                                    <!--begin::Timeline details-->
                                                    <div class="overflow-auto pb-5">
                                                        @if($config['clickable'] && !$point->is_grade_locked)
                                                            <a href="{{ route('admin.student.path-point.show', [$program->id, $point->id]) }}"
                                                               class="d-flex align-items-center border border-dashed border-gray-300 rounded px-7 py-3 mb-5 text-hover-primary activity-link">
                                                                @else
                                                                    <div class="d-flex align-items-center border border-dashed border-gray-300 rounded px-7 py-3 mb-5 {{ $point->is_grade_locked ? 'opacity-75 bg-light-warning' : 'opacity-50' }}">
                                                                        @endif
                                                                        <div class="symbol symbol-35px me-5">
                                                                            <div class="symbol-label bg-light-{{ $config['class'] }}">
                                                                                <i class="fa-solid fa-{{ $tableIcon }} text-{{ $config['class'] }} fs-5"></i>
                                                                            </div>
                                                                        </div>
                                                                        <div class="flex-grow-1">
                                                                            <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                                                                                <div class="d-flex flex-column">
                                                                                    <div class="d-flex align-items-center mb-1">
                                                                                        <span class="text-gray-800 fw-bold fs-6 me-2">{{ $point->{app()->getLocale() == 'ar' ? 'title_ar' : 'title_en'} }}</span>
                                                                                        @if($config['clickable'] && !$point->is_grade_locked)
                                                                                            <i class="fa-solid fa-external-link-alt text-primary fs-8 ms-2"></i>
                                                                                        @elseif($point->is_grade_locked)
                                                                                            <i class="fa-solid fa-graduation-cap text-warning fs-8 ms-2"></i>
                                                                                        @endif
                                                                                    </div>
                                                                                    <span class="text-gray-400 fw-semibold fs-7">{{ __('Path Point') }} #{{ $point->order }}</span>
                                                                                    @if($point->is_grade_locked)
                                                                                        <span class="text-warning fw-semibold fs-8 mt-1">{{ __('Available in Grade') }} {{ $point->available_in_grade }}</span>
                                                                                    @endif
                                                                                </div>
                                                                                <div class="d-flex flex-column align-items-end">
                                                                                    <span class="badge badge-light-{{ $config['class'] }} fs-8 mb-1">{{ __($config['text']) }}</span>
                                                                                    @if($point->status == 3 && $point->completion_date)
                                                                                        <span class="text-gray-400 fs-8">{{ \Carbon\Carbon::parse($point->completion_date)->format('M d, Y') }}</span>
                                                                                    @endif
                                                                                </div>
                                                                            </div>

                                                                            @if(($point->status == 3 || $point->status == 2) && !$point->is_grade_locked)
                                                                                <!--begin::Progress Info-->
                                                                                <div class="d-flex align-items-center mt-3">
                                                                                    @if($point->score)
                                                                                        <div class="d-flex align-items-center me-4">
                                                                                            <i class="fa-solid fa-star text-warning fs-8 me-1"></i>
                                                                                            <span class="text-gray-600 fs-8">{{ __('Score') }}: {{ $point->score }}</span>
                                                                                        </div>
                                                                                    @endif
                                                                                    @if($point->attempt_count > 0)
                                                                                        <div class="d-flex align-items-center me-4">
                                                                                            <i class="fa-solid fa-redo text-info fs-8 me-1"></i>
                                                                                            <span class="text-gray-600 fs-8">{{ __('Attempts') }}: {{ $point->attempt_count }}</span>
                                                                                        </div>
                                                                                    @endif
                                                                                    @if($point->time_spent > 0)
                                                                                        <div class="d-flex align-items-center">
                                                                                            <i class="fa-solid fa-clock text-secondary fs-8 me-1"></i>
                                                                                            <span class="text-gray-600 fs-8">{{ __('Time') }}: {{ gmdate('H:i:s', $point->time_spent * 60) }}</span>
                                                                                        </div>
                                                                                    @endif
                                                                                </div>
                                                                                <!--end::Progress Info-->
                                                                            @endif
                                                                        </div>
                                                                    @if($config['clickable'] && !$point->is_grade_locked)
                                                            </a>
                                                        @else
                                                    </div>
                                                    @endif
                                                </div>
                                                <!--end::Timeline details-->
                                            </div>
                                            <!--end::Timeline content-->
                                    </div>
                                    <!--end::Timeline item-->
                                    @endforeach
                            </div>
                            <!--end::Timeline-->
                            @else
                                <!--begin::Empty state-->
                                <div class="d-flex flex-column flex-center">
                                    <img src="{{ asset('assets/media/illustrations/sketchy-1/5.png') }}" class="mw-400px" alt="image">
                                    <div class="fs-1 fw-bolder text-gray-400 mb-5">{{ __('No Path Points') }}</div>
                                    <div class="fs-6 text-gray-600 text-center mb-8">
                                        {{ __('No path points have been defined for this program yet.') }}
                                        <br>{{ __('Please contact your administrator for more information.') }}
                                    </div>
                                </div>
                                <!--end::Empty state-->
                            @endif
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Program Path Card-->
                </div>
                <!--end::Col-->
            </div>
            <!--end::Row-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Content wrapper-->
@endsection
