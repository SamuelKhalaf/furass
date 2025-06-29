@php use App\Enums\RoleEnum; @endphp
@extends('admin.layouts.master')
@section('title', __('dashboard.title'))
@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-4 py-lg-6">
            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex text-dark fw-bold fs-2x flex-column justify-content-center my-0">
                        {{ __('dashboard.multipurpose') }}
                    </h1>
                    <!--end::Title-->
                </div>
                <!--end::Page title-->
                <!--begin::Actions-->
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <div class="d-flex align-items-center">
                        <span class="text-muted fs-7 fw-semibold d-none d-md-inline">{{ now()->format('l, F j, Y') }}</span>
                    </div>
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
                <div class="row g-5 g-xl-8 mb-5 mb-xl-10">
                    <!--begin::Col-->
                    <div class="col-xl-3">
                        <!--begin::Card widget 3-->
                        <div class="card card-flush h-xl-100 bg-danger bg-opacity-10 card-hover border-danger border-opacity-25 border border-dashed">
                            <!--begin::Body-->
                            <div class="card-body d-flex flex-column justify-content-between">
                                <!--begin::Icon-->
                                <div class="d-flex flex-center rounded-circle h-70px w-70px mb-5 bg-danger bg-opacity-10">
                                    <i class="fa fa-user-tie text-danger fs-2x lh-0"></i>
                                </div>
                                <!--end::Icon-->
                                <!--begin::Section-->
                                <div>
                                    <span class="fs-6 fw-semibold text-gray-600 d-block">Total Moderators</span>
                                    <span class="fs-3x fw-bold text-gray-800">{{\App\Models\User::whereIn('role', [RoleEnum::ADMIN, RoleEnum::SUB_ADMIN])->count()}}</span>
                                </div>
                                <!--end::Section-->
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Card widget 3-->
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-xl-3">
                        <!--begin::Card widget 3-->
                        <div class="card card-flush h-xl-100 bg-primary bg-opacity-10 card-hover border-primary border-opacity-25 border border-dashed">
                            <!--begin::Body-->
                            <div class="card-body d-flex flex-column justify-content-between">
                                <!--begin::Icon-->
                                <div class="d-flex flex-center rounded-circle h-70px w-70px mb-5 bg-primary bg-opacity-10">
                                    <i class="fa fa-headset text-primary fs-2x lh-0"></i>
                                </div>
                                <!--end::Icon-->
                                <!--begin::Section-->
                                <div>
                                    <span class="fs-6 fw-semibold text-gray-600 d-block">Active Consultants</span>
                                    <span class="fs-3x fw-bold text-gray-800">{{\App\Models\Consultant::count()}}</span>
                                </div>
                                <!--end::Section-->
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Card widget 3-->
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-xl-3">
                        <!--begin::Card widget 3-->
                        <div class="card card-flush h-xl-100 bg-success bg-opacity-10 card-hover border-success border-opacity-25 border border-dashed">
                            <!--begin::Body-->
                            <div class="card-body d-flex flex-column justify-content-between">
                                <!--begin::Icon-->
                                <div class="d-flex flex-center rounded-circle h-70px w-70px mb-5 bg-success bg-opacity-10">
                                    <i class="fa fa-school text-success fs-2x lh-0"></i>
                                </div>
                                <!--end::Icon-->
                                <!--begin::Section-->
                                <div>
                                    <span class="fs-6 fw-semibold text-gray-600 d-block">Registered Schools</span>
                                    <span class="fs-3x fw-bold text-gray-800">{{\App\Models\School::count()}}</span>
                                </div>
                                <!--end::Section-->
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Card widget 3-->
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-xl-3">
                        <!--begin::Card widget 3-->
                        <div class="card card-flush h-xl-100 bg-warning bg-opacity-10 card-hover border-warning border-opacity-25 border border-dashed">
                            <!--begin::Body-->
                            <div class="card-body d-flex flex-column justify-content-between">
                                <!--begin::Icon-->
                                <div class="d-flex flex-center rounded-circle h-70px w-70px mb-5 bg-warning bg-opacity-10">
                                    <i class="fa fa-users text-warning fs-2x lh-0"></i>
                                </div>
                                <!--end::Icon-->
                                <!--begin::Section-->
                                <div>
                                    <span class="fs-6 fw-semibold text-gray-600 d-block">Total Students</span>
                                    <span class="fs-3x fw-bold text-gray-800">{{\App\Models\Student::count()}}</span>
                                </div>
                                <!--end::Section-->
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Card widget 3-->
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Row-->
                <!--begin::Row-->
                <div class="row g-5 g-xl-8">
                    <!--begin::Col-->
                    <div class="col-xl-8">
                        <!--begin::Chart widget-->
                        <div class="card card-flush h-md-100 shadow-sm">
                            <!--begin::Header-->
                            <div class="card-header pt-7">
                                <!--begin::Title-->
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold text-gray-800">Activity Overview</span>
                                    <span class="text-gray-500 mt-1 fw-semibold fs-6">Weekly performance metrics</span>
                                </h3>
                                <!--end::Title-->
                                <!--begin::Toolbar-->
                                <div class="card-toolbar">
                                    <button class="btn btn-sm btn-light">View Report</button>
                                </div>
                                <!--end::Toolbar-->
                            </div>
                            <!--end::Header-->
                            <!--begin::Body-->
                            <div class="card-body pt-6">
                                <!--begin::Chart-->
                                <div id="kt_charts_activity_overview" class="min-h-auto" style="height: 300px"></div>
                                <!--end::Chart-->
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Chart widget-->
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-xl-4">
                        <!--begin::List widget-->
                        <div class="card card-flush h-md-100 shadow-sm">
                            <!--begin::Header-->
                            <div class="card-header pt-7">
                                <!--begin::Title-->
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold text-gray-800">Recent Activity</span>
                                    <span class="text-gray-500 mt-1 fw-semibold fs-6">Latest system events</span>
                                </h3>
                                <!--end::Title-->
                            </div>
                            <!--end::Header-->
                            <!--begin::Body-->
                            <div class="card-body pt-5">
                                <!--begin::Timeline-->
                                <div class="timeline-label">
                                    <!--begin::Item-->
                                    <div class="timeline-item">
                                        <!--begin::Label-->
                                        <div class="timeline-label fw-bold text-gray-800 fs-6">08:42</div>
                                        <!--end::Label-->
                                        <!--begin::Badge-->
                                        <div class="timeline-badge">
                                            <i class="fa fa-genderless text-success fs-1"></i>
                                        </div>
                                        <!--end::Badge-->
                                        <!--begin::Text-->
                                        <div class="fw-semibold timeline-content ps-3">
                                            <span class="text-gray-600">New consultant registration</span>
                                        </div>
                                        <!--end::Text-->
                                    </div>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <div class="timeline-item">
                                        <!--begin::Label-->
                                        <div class="timeline-label fw-bold text-gray-800 fs-6">10:00</div>
                                        <!--end::Label-->
                                        <!--begin::Badge-->
                                        <div class="timeline-badge">
                                            <i class="fa fa-genderless text-danger fs-1"></i>
                                        </div>
                                        <!--end::Badge-->
                                        <!--begin::Text-->
                                        <div class="fw-semibold timeline-content ps-3">
                                            <span class="text-gray-600">System maintenance scheduled</span>
                                        </div>
                                        <!--end::Text-->
                                    </div>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <div class="timeline-item">
                                        <!--begin::Label-->
                                        <div class="timeline-label fw-bold text-gray-800 fs-6">14:37</div>
                                        <!--end::Label-->
                                        <!--begin::Badge-->
                                        <div class="timeline-badge">
                                            <i class="fa fa-genderless text-primary fs-1"></i>
                                        </div>
                                        <!--end::Badge-->
                                        <!--begin::Text-->
                                        <div class="fw-semibold timeline-content ps-3">
                                            <span class="text-gray-600">New student enrollment</span>
                                        </div>
                                        <!--end::Text-->
                                    </div>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <div class="timeline-item">
                                        <!--begin::Label-->
                                        <div class="timeline-label fw-bold text-gray-800 fs-6">16:50</div>
                                        <!--end::Label-->
                                        <!--begin::Badge-->
                                        <div class="timeline-badge">
                                            <i class="fa fa-genderless text-warning fs-1"></i>
                                        </div>
                                        <!--end::Badge-->
                                        <!--begin::Text-->
                                        <div class="fw-semibold timeline-content ps-3">
                                            <span class="text-gray-600">New school registration</span>
                                        </div>
                                        <!--end::Text-->
                                    </div>
                                    <!--end::Item-->
                                </div>
                                <!--end::Timeline-->
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::List widget-->
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Row-->
            </div>
            <!--end::Content container-->
        </div>
        <!--end::Content-->
    </div>
@endsection
