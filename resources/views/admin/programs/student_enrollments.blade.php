@extends('admin.layouts.master')
@section('title', __('My Enrolled Programs'))
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
                    {{ __('My Enrolled Programs') }}
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
                    <li class="breadcrumb-item text-muted">{{ __('My Enrolled Programs') }}</li>
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
            @if($enrollments->count())
                <!--begin::Row-->
                <div class="row g-6 g-xl-9">
                    @foreach($enrollments as $enrollment)
                        @php
                            $program = $enrollment->program;
                            $colorMap = [
                                'Self Campus' => ['bg' => 'success', 'light' => 'light-success'],
                                'Explore Your Career' => ['bg' => 'warning', 'light' => 'light-warning'],
                                'Ready for The Future' => ['bg' => 'primary', 'light' => 'light-primary'],
                                'بوصله الذات' => ['bg' => 'success', 'light' => 'light-success'],
                                'استكشف مهنتك' => ['bg' => 'warning', 'light' => 'light-warning'],
                                'مستعدون للمستقبل' => ['bg' => 'primary', 'light' => 'light-primary'],
                            ];
                            $programTitle = app()->getLocale() == 'ar' ? $program->title_ar : $program->title_en;
                            $programDesc = app()->getLocale() == 'ar' ? $program->description_ar : $program->description_en;
                            $colors = $colorMap[$programTitle] ?? ['bg' => 'secondary', 'light' => 'light-secondary'];
                        @endphp
                        <!--begin::Col-->
                        <div class="col-md-6 col-xl-4">
                            <!--begin::Card-->
                            <div class="card card-flush h-md-100">
                                <!--begin::Card header-->
                                <div class="card-header">
                                    <!--begin::Card title-->
                                    <div class="card-title">
                                        <h3 class="fw-bold text-dark">{{ Str::limit($programTitle, 16) }}</h3>
                                    </div>
                                    <!--end::Card title-->
                                    <!--begin::Card toolbar-->
                                    <div class="card-toolbar">
                                        <span class="badge badge-{{ $colors['light'] }} fs-7 fw-bold">{{ __(ucfirst($enrollment->status)) }}</span>
                                    </div>
                                    <!--end::Card toolbar-->
                                </div>
                                <!--end::Card header-->

                                <!--begin::Card body-->
                                <div class="card-body pt-0">
                                    <!--begin::Description-->
                                    <div class="text-gray-600 fw-semibold fs-6 mb-5">
                                        {{ Str::limit($programDesc, 100) }}
                                    </div>
                                    <!--end::Description-->

                                    @if(isset($enrollment->progress))
                                        <!--begin::Progress-->
                                        <div class="mb-5">
                                            <div class="d-flex align-items-center mb-2">
                                                <span class="text-dark fw-bold fs-6 me-2">{{ __('Progress') }}</span>
                                                <span class="badge badge-light fs-7">{{ $enrollment->progress }}%</span>
                                            </div>
                                            <div class="progress h-6px">
                                                <div class="progress-bar bg-{{ $colors['bg'] }}" role="progressbar"
                                                     style="width: {{ $enrollment->progress }}%"
                                                     aria-valuenow="{{ $enrollment->progress }}"
                                                     aria-valuemin="0"
                                                     aria-valuemax="100">
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Progress-->
                                    @endif

                                    <!--begin::Stats-->
                                    <div class="d-flex flex-wrap mb-5">
                                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                            <div class="d-flex align-items-center">
                                                <div class="symbol symbol-30px me-3">
                                                    <div class="symbol-label bg-{{ $colors['light'] }}">
                                                        <i class="fa-solid fa-calendar-days text-{{ $colors['bg'] }} fs-4"></i>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <div class="fw-bold fs-6 text-gray-800">{{ __('Enrolled') }}</div>
                                                    <div class="fw-semibold fs-7 text-gray-400">{{ $enrollment->created_at->format('M d, Y') }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Stats-->
                                </div>
                                <!--end::Card body-->

                                <!--begin::Card footer-->
                                <div class="card-footer">
                                    <a href="{{ route('admin.student.enrollments.show', $program->id) }}"
                                       class="btn btn-{{ $colors['bg'] }} btn-sm">
                                        <i class="fa-solid fa-arrow-right me-1"></i>{{ __('View Program') }}
                                    </a>
                                </div>
                                <!--end::Card footer-->
                            </div>
                            <!--end::Card-->
                        </div>
                        <!--end::Col-->
                    @endforeach
                </div>
                <!--end::Row-->
            @else
                <!--begin::Empty state-->
                <div class="card">
                    <div class="card-body d-flex flex-column justify-content-center text-center p-15">
                        <!--begin::Illustration-->
                        <div class="text-center px-4">
                            <img class="mw-100 mh-300px" alt="" src="{{ asset('assets/media/illustrations/sketchy-1/4.png') }}">
                        </div>
                        <!--end::Illustration-->

                        <!--begin::Heading-->
                        <h1 class="fw-bolder fs-2qx text-gray-800 mb-4">{{ __('No Programs Found') }}</h1>
                        <!--end::Heading-->

                        <!--begin::Description-->
                        <div class="fw-semibold fs-6 text-gray-500 mb-7">
                            {{ __('You are not enrolled in any programs yet.') }}
                            <br>{{ __('Contact your administrator to get enrolled in available programs.') }}
                        </div>
                        <!--end::Description-->

                        <!--begin::Action-->
                        <div class="text-center">
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
                                <i class="fa-solid fa-arrow-left me-2"></i>{{ __('Back to Dashboard') }}
                            </a>
                        </div>
                        <!--end::Action-->
                    </div>
                </div>
                <!--end::Empty state-->
            @endif
        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->
</div>
<!--end::Content wrapper-->
@endsection

@push('styles')
    <style>
        .card {
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .progress {
            background-color: #f1f3f6;
        }

        .badge {
            font-size: 0.75rem;
        }

        .symbol-label {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .border-dashed {
            border-style: dashed !important;
        }

        .min-w-125px {
            min-width: 125px;
        }

        .card-flush .card-header {
            border-bottom: 1px solid #eff2f5;
        }

        .card-flush .card-footer {
            border-top: 1px solid #eff2f5;
            background-color: #f9f9f9;
        }

        @media (max-width: 768px) {
            .d-flex.flex-wrap > div {
                margin-right: 0 !important;
                margin-bottom: 15px;
            }
        }
    </style>
@endpush
