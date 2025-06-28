@php use App\Enums\RoleEnum; @endphp
@extends('admin.layouts.master')
@section('title', __('dashboard.title'))
@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">{{ __('dashboard.multipurpose') }}</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">{{ __('dashboard.home') }}</li>
                        <!--end::Item-->
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
                <!--begin::Row-->
                <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
                    <!--begin::Col-->
                    <div class="col-xl-3">
                        <!--begin::Card widget 3-->
                        <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-xl-100"
                             style="background-color: #F1416C;
                             background-image:url({{asset('assets/media/svg/shapes/wave-bg-red.svg')}})">
                            <!--begin::Header-->
                            <div class="card-header pt-5 mb-3">
                                <!--begin::Icon-->
                                <div class="d-flex flex-center rounded-circle h-80px w-80px"
                                     style="border: 1px dashed rgba(255, 255, 255, 0.4);background-color: #F1416C">
                                    <i class="fa fa-user-tie text-white fs-2qx lh-0"></i>
                                </div>
                                <!--end::Icon-->
                            </div>
                            <!--end::Header-->
                            <!--begin::Card body-->
                            <div class="card-body d-flex justify-content-start align-items-end mb-3">
                                <!--begin::Info-->
                                <div class="d-flex align-items-center">
                                    <span
                                        class="fs-3hx text-white fw-bold me-4">{{\App\Models\User::whereIn('role', [RoleEnum::ADMIN, RoleEnum::SUB_ADMIN])->count()}}</span>
                                    <div class="fw-bold fs-6 text-white">
                                        <span>Moderators</span>
                                    </div>
                                </div>
                                <!--end::Info-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Card widget 3-->
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-xl-3">
                        <!--begin::Card widget 3-->
                        <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-xl-100"
                             style="background-color: #7239EA;
                             background-image:url({{asset('assets/media/svg/shapes/wave-bg-purple.svg')}})">
                            <!--begin::Header-->
                            <div class="card-header pt-5 mb-3">
                                <!--begin::Icon-->
                                <div class="d-flex flex-center rounded-circle h-80px w-80px"
                                     style="border: 1px dashed rgba(255, 255, 255, 0.4);background-color: #7239EA">
                                    <i class="fa fa-headset text-white fs-2qx lh-0"></i>
                                </div>
                                <!--end::Icon-->
                            </div>
                            <!--end::Header-->
                            <!--begin::Card body-->
                            <div class="card-body justify-content-start d-flex align-items-end mb-3">
                                <!--begin::Info-->
                                <div class="d-flex align-items-center">
                                    <span
                                        class="fs-3hx text-white fw-bold me-3">{{\App\Models\Consultant::count()}}</span>
                                    <div class="fw-bold fs-6 text-white">
                                        <span class="">Consultants</span>
                                    </div>
                                </div>
                                <!--end::Info-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Card widget 3-->
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-xl-3">
                        <!--begin::Card widget 3-->
                        <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-xl-100"
                             style="background-color: #F1416C;
                             background-image:url({{asset('assets/media/svg/shapes/wave-bg-red.svg')}})">
                            <!--begin::Header-->
                            <div class="card-header pt-5 mb-3">
                                <!--begin::Icon-->
                                <div class="d-flex flex-center rounded-circle h-80px w-80px"
                                     style="border: 1px dashed rgba(255, 255, 255, 0.4);background-color: #F1416C">
                                    <i class="fa fa-school text-white fs-2qx lh-0"></i>
                                </div>
                                <!--end::Icon-->
                            </div>
                            <!--end::Header-->
                            <!--begin::Card body-->
                            <div class="card-body justify-content-start d-flex align-items-end mb-3">
                                <!--begin::Info-->
                                <div class="d-flex align-items-center">
                                    <span class="fs-3hx text-white fw-bold me-3">{{\App\Models\School::count()}}</span>
                                    <div class="fw-bold fs-6 text-white">
                                        <span class="">Schools</span>
                                    </div>
                                </div>
                                <!--end::Info-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Card widget 3-->
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-xl-3">
                        <!--begin::Card widget 3-->
                        <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-xl-100"
                             style="background-color: #7239EA;
                             background-image:url({{asset('assets/media/svg/shapes/wave-bg-purple.svg')}})">
                            <!--begin::Header-->
                            <div class="card-header pt-5 mb-3">
                                <!--begin::Icon-->
                                <div class="d-flex flex-center rounded-circle h-80px w-80px"
                                     style="border: 1px dashed rgba(255, 255, 255, 0.4);background-color: #7239EA">
                                    <i class="fa fa-users text-white fs-2qx lh-0"></i>
                                </div>
                                <!--end::Icon-->
                            </div>
                            <!--end::Header-->
                            <!--begin::Card body-->
                            <div class="card-body justify-content-start d-flex align-items-end mb-3">
                                <!--begin::Info-->
                                <div class="d-flex align-items-center">
                                    <div
                                        class="d-block fs-3hx text-white fw-bold me-3">{{\App\Models\Student::count()}}</div>
                                    <div class="fw-bold fs-5 text-white">
                                        <span class="">Students</span>
                                    </div>
                                </div>
                                <!--end::Info-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Card widget 3-->
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
