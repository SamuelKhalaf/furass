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
                                    <!--begin::Modern Timeline-->
                                    <div class="position-relative">
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
                                                $isLast = $loop->last;
                                            @endphp

                                                <!--begin::Timeline item-->
                                            <div class="position-relative d-flex align-items-start mb-8">
                                                <!--begin::Modern Timeline sidebar-->
                                                <div class="position-relative d-flex flex-column align-items-center me-6" style="width: 60px;">
                                                    <!--begin::Modern icon container-->
                                                    <div class="position-relative">
                                                        <!--begin::Glow effect-->
                                                        @if($config['class'] === 'success')
                                                            <div class="position-absolute top-50 start-50 translate-middle rounded-circle bg-success opacity-25" style="width: 70px; height: 70px; animation: pulse 2s infinite;"></div>
                                                        @elseif($config['class'] === 'warning')
                                                            <div class="position-absolute top-50 start-50 translate-middle rounded-circle bg-warning opacity-20" style="width: 65px; height: 65px; animation: pulse 2s infinite;"></div>
                                                        @endif
                                                        <!--end::Glow effect-->

                                                        <!--begin::Main icon-->
                                                        <div class="d-flex align-items-center justify-content-center rounded-circle shadow-sm position-relative"
                                                             style="width: 50px; height: 50px; background: linear-gradient(135deg, {{ $config['class'] === 'success' ? '#1BC5BD, #0BB7AF' : ($config['class'] === 'warning' ? '#FFA800, #FF8F00' : ($config['class'] === 'danger' ? '#F64E60, #E1306C' : ($config['class'] === 'dark' ? '#3F4254, #181C32' : '#7E8299, #5E6278'))) }});">
                                                            <i class="fa-solid fa-{{ $tableIcon }} text-white fs-5"></i>
                                                        </div>
                                                        <!--end::Main icon-->

                                                        <!--begin::Status indicator-->
                                                        <div class="position-absolute" style="top: -5px; right: -5px;">
                                                            <div class="d-flex align-items-center justify-content-center rounded-circle bg-{{ $config['class'] }} shadow-sm"
                                                                 style="width: 20px; height: 20px;">
                                                                <i class="fa-solid fa-{{ $config['icon'] }} text-white" style="font-size: 10px;"></i>
                                                            </div>
                                                        </div>
                                                        <!--end::Status indicator-->
                                                    </div>
                                                    <!--end::Modern icon container-->

                                                    <!--begin::Connecting line-->
                                                    @if(!$isLast)
                                                        <div class="position-absolute bg-gray-300 rounded-pill"
                                                             style="width: 3px; height: 100px; top: 55px; left: 50%; transform: translateX(-50%); background: linear-gradient(180deg, {{ $config['class'] === 'success' ? '#1BC5BD' : '#E4E6EF' }} 0%, #E4E6EF 100%);">
                                                        </div>
                                                    @endif
                                                    <!--end::Connecting line-->
                                                </div>
                                                <!--end::Modern Timeline sidebar-->

                                                <!--begin::Content-->
                                                <div class="flex-grow-1">
                                                    <!--begin::Timeline item-->
                                                    @if($config['clickable'] && !$point->is_grade_locked)
                                                        <a href="{{ route('admin.student.path-point.show', [$program->id, $point->id]) }}"
                                                           class="d-block p-6 bg-white rounded-lg shadow-sm border border-gray-200 text-hover-primary position-relative overflow-hidden"
                                                           style="transition: all 0.3s ease; transform: translateY(0);"
                                                           onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 25px rgba(0,0,0,0.1)'"
                                                           onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 10px rgba(0,0,0,0.08)'">
                                                            @else
                                                                <div class="d-block p-6 {{ $point->is_grade_locked ? 'bg-light-warning' : 'bg-light' }} rounded-lg border border-gray-200 opacity-75 position-relative overflow-hidden">
                                                                    @endif
                                                                    <!--begin::Accent bar-->
                                                                    <div class="position-absolute top-0 start-0 h-100 bg-{{ $config['class'] }}" style="width: 4px;"></div>
                                                                    <!--end::Accent bar-->

                                                                    <!--begin::Content-->
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="flex-grow-1">
                                                                            <!--begin::Title-->
                                                                            <h5 class="text-dark fw-bold mb-2 fs-5">
                                                                                {{ $point->{app()->getLocale() == 'ar' ? 'title_ar' : 'title_en'} }}
                                                                            </h5>
                                                                            <!--end::Title-->

                                                                            <!--begin::Type & Status-->
                                                                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                                                    <span class="badge fs-8 px-3 py-2"
                                                                          style="background: linear-gradient(135deg, #f8f9fa, #e9ecef); color: #495057; border: 1px solid #dee2e6;">
                                                                        <i class="fa-solid fa-{{ $tableIcon }} me-1"></i>
                                                                        {{ __(ucfirst(str_replace('_', ' ', $point->table_name))) }}
                                                                    </span>
                                                                                <span class="badge fs-8 px-3 py-2 bg-{{ $config['class'] }} text-white">
                                                                        <i class="fa-solid fa-{{ $config['icon'] }} me-1"></i>
                                                                        {{ __($config['text']) }}
                                                                    </span>
                                                                                @if($point->is_grade_locked)
                                                                                    <span class="badge badge-warning fs-8 px-3 py-2">
                                                                            <i class="fa-solid fa-graduation-cap me-1"></i>
                                                                            {{ __('Grade') }} {{ $point->available_in_grade }}
                                                                        </span>
                                                                                @endif
                                                                            </div>
                                                                            <!--end::Type & Status-->
                                                                        </div>
                                                                        <!--end::Content-->

                                                                        <!--begin::Action-->
                                                                        @if($config['clickable'] && !$point->is_grade_locked)
                                                                            <div class="ms-3">
                                                                                <div class="d-flex align-items-center justify-content-center rounded-circle bg-light-primary"
                                                                                     style="width: 40px; height: 40px; transition: all 0.3s ease;">
                                                                                    <i class="fa-solid fa-chevron-right text-primary fs-6"></i>
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                        <!--end::Action-->
                                                                    </div>
                                                                @if($config['clickable'] && !$point->is_grade_locked)
                                                        </a>
                                                    @else
                                                </div>
                                                @endif
                                                <!--end::Timeline item-->
                                            </div>
                                            <!--end::Content-->
                                    </div>
                                    <!--end::Timeline item-->
                                    @endforeach
                            </div>
                            <!--end::Modern Timeline-->
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
        <!--end::Content container-->
    </div>
    <!--end::Content-->
    </div>
    <!--end::Content wrapper-->
@endsection
