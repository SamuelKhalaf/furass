@extends('admin.layouts.master')
@section('title', __('Consultation Notes'))

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
                        {{ __('Consultation Notes') }}
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
                        <li class="breadcrumb-item text-muted">{{ __('Consultation Notes') }}</li>
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
                <!--begin::Actions-->
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <a href="javascript:history.back()" class="btn btn-sm btn-secondary">
                        <i class="fa-solid fa-arrow-left me-1"></i>{{ __('Back') }}
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
                    <div class="col-xl-12">
                        <!--begin::Consultation Notes Card-->
                        <div class="card card-flush h-md-100">
                            <!--begin::Card header-->
                            <div class="card-header">
                                <!--begin::Card title-->
                                <div class="card-title">
                                    <h3 class="fw-bold text-dark">
                                        <i class="fa-solid fa-file-text text-primary me-2"></i>{{ __('Consultation Notes') }}
                                    </h3>
                                </div>
                                <!--end::Card title-->
                            </div>
                            <!--end::Card header-->

                            <!--begin::Card body-->
                            <div class="card-body pt-0">
                                <!--begin::Consultation Info-->
                                <div class="d-flex flex-wrap align-items-center mb-8">
                                    <div class="d-flex align-items-center me-5 mb-2">
                                        <div class="symbol symbol-40px me-4">
                                            <div class="symbol-label bg-light-success">
                                                <i class="fa-solid fa-user-md text-success fs-6"></i>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <span class="text-gray-700 fw-semibold fs-7">{{ __('Consultant') }}</span>
                                            <span class="text-gray-800 fw-bold fs-6">{{ $consultation->consultant->user->name }}</span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center me-5 mb-2">
                                        <div class="symbol symbol-40px me-4">
                                            <div class="symbol-label bg-light-primary">
                                                <i class="fa-solid fa-calendar text-primary fs-6"></i>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <span class="text-gray-700 fw-semibold fs-7">{{ __('Session Date') }}</span>
                                            <span class="text-gray-800 fw-bold fs-6">{{ \Carbon\Carbon::parse($consultation->scheduled_at)->format('M d, Y h:i A') }}</span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="symbol symbol-40px me-4">
                                            <div class="symbol-label bg-light-info">
                                                <i class="fa-solid fa-check-circle text-info fs-6"></i>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <span class="text-gray-700 fw-semibold fs-7">{{ __('Status') }}</span>
                                            <span class="badge badge-light-success fs-7 fw-bold">
                                                <i class="fa-solid fa-check me-1"></i>{{ __('Completed') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Consultation Info-->

                                <!--begin::Separator-->
                                <div class="separator separator-dashed mb-8"></div>
                                <!--end::Separator-->

                                <!--begin::Notes Content-->
                                <div class="mb-8">
                                    <h4 class="text-gray-800 fw-bold mb-4">{{ __('Consultation Notes') }}</h4>
                                    <div class="card bg-light-info p-5">
                                        <div class="text-gray-700 fw-semibold fs-6 lh-lg">
                                            {!! nl2br(e($notes->notes)) !!}
                                        </div>
                                    </div>
                                </div>
                                <!--end::Notes Content-->
                                @if($notes->report_pdf)
                                    <div class="mb-8">
                                        <h4 class="text-gray-800 fw-bold mb-4">{{ __('Consultation Report') }}</h4>
                                        <div class="card bg-light-primary p-5">
                                            <div class="d-flex align-items-center">
                                                <i class="fa-solid fa-file-pdf text-danger fs-1 me-4"></i>
                                                <div>
                                                    <h5 class="text-gray-800 mb-1">{{ __('Download Consultation Report') }}</h5>
                                                    <a href="{{ asset('storage/'.$notes->report_pdf) }}"
                                                       class="btn btn-sm btn-primary" download>
                                                        <i class="fa-solid fa-download me-2"></i>
                                                        {{ __('Download PDF Report') }}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <!--begin::Next Steps-->
                                <div class="alert alert-primary d-flex align-items-center p-5">
                                    <div class="d-flex flex-column">
                                        <h5 class="mb-1 text-dark">{{ __('Next Steps') }}</h5>
                                        <span>{{ __('Your consultation is now complete. You can continue with your program path points.') }}</span>
                                    </div>
                                </div>
                                <!--end::Next Steps-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Consultation Notes Card-->
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
