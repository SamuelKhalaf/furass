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
                <!--begin::Actions-->
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <!--begin::Secondary button-->
                    <a href="#" class="btn btn-sm fw-bold bg-body btn-color-gray-700 btn-active-color-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_create_app">{{ __('dashboard.rollover') }}</a>
                    <!--end::Secondary button-->
                    <!--begin::Primary button-->
                    <a href="#" class="btn btn-sm fw-bold btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_new_target">{{ __('dashboard.add_target') }}</a>
                    <!--end::Primary button-->
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
                <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
                    <!--begin::Col-->
                    <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">
                        <!--begin::Card widget 20-->
                        <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-50 mb-5 mb-xl-10" style="background-color: #F1416C;background-image:url('{{asset('assets/media/patterns/vector-1.png')}}')">
                            <!--begin::Header-->
                            <div class="card-header pt-5">
                                <!--begin::Title-->
                                <div class="card-title d-flex flex-column">
                                    <!--begin::Amount-->
                                    <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">69</span>
                                    <!--end::Amount-->
                                    <!--begin::Subtitle-->
                                    <span class="text-white opacity-75 pt-1 fw-semibold fs-6">{{ __('dashboard.active_projects') }}</span>
                                    <!--end::Subtitle-->
                                </div>
                                <!--end::Title-->
                            </div>
                            <!--end::Header-->
                            <!--begin::Card body-->
                            <div class="card-body d-flex align-items-end pt-0">
                                <!--begin::Progress-->
                                <div class="d-flex align-items-center flex-column mt-3 w-100">
                                    <div class="d-flex justify-content-between fw-bold fs-6 text-white opacity-75 w-100 mt-auto mb-2">
                                        <span>{{ __('dashboard.pending') }} 43</span>
                                        <span>72%</span>
                                    </div>
                                    <div class="h-8px mx-3 w-100 bg-white bg-opacity-50 rounded">
                                        <div class="bg-white rounded h-8px" role="progressbar" style="width: 72%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <!--end::Progress-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Card widget 20-->
                        <!--begin::Card widget 7-->
                        <div class="card card-flush h-md-50 mb-5 mb-xl-10">
                            <!--begin::Header-->
                            <div class="card-header pt-5">
                                <!--begin::Title-->
                                <div class="card-title d-flex flex-column">
                                    <!--begin::Amount-->
                                    <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2">357</span>
                                    <!--end::Amount-->
                                    <!--begin::Subtitle-->
                                    <span class="text-gray-400 pt-1 fw-semibold fs-6">{{ __('dashboard.professionals') }}</span>
                                    <!--end::Subtitle-->
                                </div>
                                <!--end::Title-->
                            </div>
                            <!--end::Header-->
                            <!--begin::Card body-->
                            <div class="card-body d-flex flex-column justify-content-end pe-0">
                                <!--begin::Title-->
                                <span class="fs-6 fw-bolder text-gray-800 d-block mb-2">{{ __('dashboard.todays_heroes') }}</span>
                                <!--end::Title-->
                                <!--begin::Users group-->
                                <div class="symbol-group symbol-hover flex-nowrap">
                                    <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Alan Warden">
                                        <span class="symbol-label bg-warning text-inverse-warning fw-bold">A</span>
                                    </div>
                                    <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Michael Eberon">
                                        <img alt="Pic" src="assets/media/avatars/300-11.jpg" />
                                    </div>
                                    <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Susan Redwood">
                                        <span class="symbol-label bg-primary text-inverse-primary fw-bold">S</span>
                                    </div>
                                    <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Melody Macy">
                                        <img alt="Pic" src="assets/media/avatars/300-2.jpg" />
                                    </div>
                                    <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Perry Matthew">
                                        <span class="symbol-label bg-danger text-inverse-danger fw-bold">P</span>
                                    </div>
                                    <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Barry Walter">
                                        <img alt="Pic" src="assets/media/avatars/300-12.jpg" />
                                    </div>
                                    <a href="#" class="symbol symbol-35px symbol-circle" data-bs-toggle="modal" data-bs-target="#kt_modal_view_users">
                                        <span class="symbol-label bg-dark text-gray-300 fs-8 fw-bold">+42</span>
                                    </a>
                                </div>
                                <!--end::Users group-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Card widget 7-->
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">
                        <!--begin::Card widget 17-->
                        <div class="card card-flush h-md-50 mb-5 mb-xl-10">
                            <!--begin::Header-->
                            <div class="card-header pt-5">
                                <!--begin::Title-->
                                <div class="card-title d-flex flex-column">
                                    <!--begin::Info-->
                                    <div class="d-flex align-items-center">
                                        <!--begin::Currency-->
                                        <span class="fs-4 fw-semibold text-gray-400 me-1 align-self-start">$</span>
                                        <!--end::Currency-->
                                        <!--begin::Amount-->
                                        <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2">69,700</span>
                                        <!--end::Amount-->
                                        <!--begin::Badge-->
                                        <span class="badge badge-light-success fs-base">
                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
                                            <span class="svg-icon svg-icon-5 svg-icon-success ms-n1">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="currentColor" />
                                                    <path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="currentColor" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->2.2%</span>
                                        <!--end::Badge-->
                                    </div>
                                    <!--end::Info-->
                                    <!--begin::Subtitle-->
                                    <span class="text-gray-400 pt-1 fw-semibold fs-6">{{ __('dashboard.projects_earnings') }}</span>
                                    <!--end::Subtitle-->
                                </div>
                                <!--end::Title-->
                            </div>
                            <!--end::Header-->
                            <!--begin::Card body-->
                            <div class="card-body pt-2 pb-4 d-flex flex-wrap align-items-center">
                                <!--begin::Chart-->
                                <div class="d-flex flex-center me-5 pt-2">
                                    <div id="kt_card_widget_17_chart" style="min-width: 70px; min-height: 70px" data-kt-size="70" data-kt-line="11"></div>
                                </div>
                                <!--end::Chart-->
                                <!--begin::Labels-->
                                <div class="d-flex flex-column content-justify-center flex-row-fluid">
                                    <!--begin::Label-->
                                    <div class="d-flex fw-semibold align-items-center">
                                        <!--begin::Bullet-->
                                        <div class="bullet w-8px h-3px rounded-2 bg-success me-3"></div>
                                        <!--end::Bullet-->
                                        <!--begin::Label-->
                                        <div class="text-gray-500 flex-grow-1 me-4">{{ __('dashboard.leaf_crm') }}</div>
                                        <!--end::Label-->
                                        <!--begin::Stats-->
                                        <div class="fw-bolder text-gray-700 text-xxl-end">$7,660</div>
                                        <!--end::Stats-->
                                    </div>
                                    <!--end::Label-->
                                    <!--begin::Label-->
                                    <div class="d-flex fw-semibold align-items-center my-3">
                                        <!--begin::Bullet-->
                                        <div class="bullet w-8px h-3px rounded-2 bg-primary me-3"></div>
                                        <!--end::Bullet-->
                                        <!--begin::Label-->
                                        <div class="text-gray-500 flex-grow-1 me-4">{{ __('dashboard.mivy_app') }}</div>
                                        <!--end::Label-->
                                        <!--begin::Stats-->
                                        <div class="fw-bolder text-gray-700 text-xxl-end">$2,820</div>
                                        <!--end::Stats-->
                                    </div>
                                    <!--end::Label-->
                                </div>
                                <!--end::Labels-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Card widget 17-->
                        <!--begin::List widget 26-->
                        <div class="card card-flush h-lg-50">
                            <!--begin::Header-->
                            <div class="card-header pt-5">
                                <!--begin::Title-->
                                <h3 class="card-title text-gray-800 fw-bold">External Links</h3>
                                <!--end::Title-->
                                <!--begin::Toolbar-->
                                <div class="card-toolbar">
                                    <!--begin::Menu-->
                                    <button class="btn btn-icon btn-color-gray-400 btn-active-color-primary justify-content-end" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-overflow="true">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen023.svg-->
                                        <span class="svg-icon svg-icon-1 svg-icon-gray-300 me-n1">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="4" fill="currentColor" />
                                                <rect x="11" y="11" width="2.6" height="2.6" rx="1.3" fill="currentColor" />
                                                <rect x="15" y="11" width="2.6" height="2.6" rx="1.3" fill="currentColor" />
                                                <rect x="7" y="11" width="2.6" height="2.6" rx="1.3" fill="currentColor" />
                                            </svg>
																<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																	<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="4" fill="currentColor" />
																	<rect x="11" y="11" width="2.6" height="2.6" rx="1.3" fill="currentColor" />
																	<rect x="15" y="11" width="2.6" height="2.6" rx="1.3" fill="currentColor" />
																	<rect x="7" y="11" width="2.6" height="2.6" rx="1.3" fill="currentColor" />
																</svg>
															</span>
                                        <!--end::Svg Icon-->
                                    </button>
                                    <!--begin::Menu 2-->
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px" data-kt-menu="true">
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <div class="menu-content fs-6 text-dark fw-bold px-3 py-4">Quick Actions</div>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu separator-->
                                        <div class="separator mb-3 opacity-75"></div>
                                        <!--end::Menu separator-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">New Ticket</a>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">New Customer</a>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3" data-kt-menu-trigger="hover" data-kt-menu-placement="right-start">
                                            <!--begin::Menu item-->
                                            <a href="#" class="menu-link px-3">
                                                <span class="menu-title">New Group</span>
                                                <span class="menu-arrow"></span>
                                            </a>
                                            <!--end::Menu item-->
                                            <!--begin::Menu sub-->
                                            <div class="menu-sub menu-sub-dropdown w-175px py-4">
                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                    <a href="#" class="menu-link px-3">Admin Group</a>
                                                </div>
                                                <!--end::Menu item-->
                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                    <a href="#" class="menu-link px-3">Staff Group</a>
                                                </div>
                                                <!--end::Menu item-->
                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                    <a href="#" class="menu-link px-3">Member Group</a>
                                                </div>
                                                <!--end::Menu item-->
                                            </div>
                                            <!--end::Menu sub-->
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">New Contact</a>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu separator-->
                                        <div class="separator mt-3 opacity-75"></div>
                                        <!--end::Menu separator-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <div class="menu-content px-3 py-3">
                                                <a class="btn btn-primary btn-sm px-4" href="#">Generate Reports</a>
                                            </div>
                                        </div>
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::Menu 2-->
                                    <!--end::Menu-->
                                </div>
                                <!--end::Toolbar-->
                            </div>
                            <!--end::Header-->
                            <!--begin::Body-->
                            <div class="card-body pt-5">
                                <!--begin::Item-->
                                <div class="d-flex flex-stack">
                                    <!--begin::Section-->
                                    <a href="#" class="text-primary fw-semibold fs-6 me-2">Avg. Client Rating</a>
                                    <!--end::Section-->
                                    <!--begin::Action-->
                                    <button type="button" class="btn btn-icon btn-sm h-auto btn-color-gray-400 btn-active-color-primary justify-content-end">
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr095.svg-->
                                        <span class="svg-icon svg-icon-2">
																<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																	<path opacity="0.3" d="M4.7 17.3V7.7C4.7 6.59543 5.59543 5.7 6.7 5.7H9.8C10.2694 5.7 10.65 5.31944 10.65 4.85C10.65 4.38056 10.2694 4 9.8 4H5C3.89543 4 3 4.89543 3 6V19C3 20.1046 3.89543 21 5 21H18C19.1046 21 20 20.1046 20 19V14.2C20 13.7306 19.6194 13.35 19.15 13.35C18.6806 13.35 18.3 13.7306 18.3 14.2V17.3C18.3 18.4046 17.4046 19.3 16.3 19.3H6.7C5.59543 19.3 4.7 18.4046 4.7 17.3Z" fill="currentColor" />
																	<rect x="21.9497" y="3.46448" width="13" height="2" rx="1" transform="rotate(135 21.9497 3.46448)" fill="currentColor" />
																	<path d="M19.8284 4.97161L19.8284 9.93937C19.8284 10.5252 20.3033 11 20.8891 11C21.4749 11 21.9497 10.5252 21.9497 9.93937L21.9497 3.05029C21.9497 2.498 21.502 2.05028 20.9497 2.05028L14.0607 2.05027C13.4749 2.05027 13 2.52514 13 3.11094C13 3.69673 13.4749 4.17161 14.0607 4.17161L19.0284 4.17161C19.4702 4.17161 19.8284 4.52978 19.8284 4.97161Z" fill="currentColor" />
																</svg>
															</span>
                                        <!--end::Svg Icon-->
                                    </button>
                                    <!--end::Action-->
                                </div>
                                <!--end::Item-->
                                <!--begin::Separator-->
                                <div class="separator separator-dashed my-3"></div>
                                <!--end::Separator-->
                                <!--begin::Item-->
                                <div class="d-flex flex-stack">
                                    <!--begin::Section-->
                                    <a href="#" class="text-primary fw-semibold fs-6 me-2">Instagram Followers</a>
                                    <!--end::Section-->
                                    <!--begin::Action-->
                                    <button type="button" class="btn btn-icon btn-sm h-auto btn-color-gray-400 btn-active-color-primary justify-content-end">
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr095.svg-->
                                        <span class="svg-icon svg-icon-2">
																<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																	<path opacity="0.3" d="M4.7 17.3V7.7C4.7 6.59543 5.59543 5.7 6.7 5.7H9.8C10.2694 5.7 10.65 5.31944 10.65 4.85C10.65 4.38056 10.2694 4 9.8 4H5C3.89543 4 3 4.89543 3 6V19C3 20.1046 3.89543 21 5 21H18C19.1046 21 20 20.1046 20 19V14.2C20 13.7306 19.6194 13.35 19.15 13.35C18.6806 13.35 18.3 13.7306 18.3 14.2V17.3C18.3 18.4046 17.4046 19.3 16.3 19.3H6.7C5.59543 19.3 4.7 18.4046 4.7 17.3Z" fill="currentColor" />
																	<rect x="21.9497" y="3.46448" width="13" height="2" rx="1" transform="rotate(135 21.9497 3.46448)" fill="currentColor" />
																	<path d="M19.8284 4.97161L19.8284 9.93937C19.8284 10.5252 20.3033 11 20.8891 11C21.4749 11 21.9497 10.5252 21.9497 9.93937L21.9497 3.05029C21.9497 2.498 21.502 2.05028 20.9497 2.05028L14.0607 2.05027C13.4749 2.05027 13 2.52514 13 3.11094C13 3.69673 13.4749 4.17161 14.0607 4.17161L19.0284 4.17161C19.4702 4.17161 19.8284 4.52978 19.8284 4.97161Z" fill="currentColor" />
																</svg>
															</span>
                                        <!--end::Svg Icon-->
                                    </button>
                                    <!--end::Action-->
                                </div>
                                <!--end::Item-->
                                <!--begin::Separator-->
                                <div class="separator separator-dashed my-3"></div>
                                <!--end::Separator-->
                                <!--begin::Item-->
                                <div class="d-flex flex-stack">
                                    <!--begin::Section-->
                                    <a href="#" class="text-primary fw-semibold fs-6 me-2">Google Ads CPC</a>
                                    <!--end::Section-->
                                    <!--begin::Action-->
                                    <button type="button" class="btn btn-icon btn-sm h-auto btn-color-gray-400 btn-active-color-primary justify-content-end">
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr095.svg-->
                                        <span class="svg-icon svg-icon-2">
																<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																	<path opacity="0.3" d="M4.7 17.3V7.7C4.7 6.59543 5.59543 5.7 6.7 5.7H9.8C10.2694 5.7 10.65 5.31944 10.65 4.85C10.65 4.38056 10.2694 4 9.8 4H5C3.89543 4 3 4.89543 3 6V19C3 20.1046 3.89543 21 5 21H18C19.1046 21 20 20.1046 20 19V14.2C20 13.7306 19.6194 13.35 19.15 13.35C18.6806 13.35 18.3 13.7306 18.3 14.2V17.3C18.3 18.4046 17.4046 19.3 16.3 19.3H6.7C5.59543 19.3 4.7 18.4046 4.7 17.3Z" fill="currentColor" />
																	<rect x="21.9497" y="3.46448" width="13" height="2" rx="1" transform="rotate(135 21.9497 3.46448)" fill="currentColor" />
																	<path d="M19.8284 4.97161L19.8284 9.93937C19.8284 10.5252 20.3033 11 20.8891 11C21.4749 11 21.9497 10.5252 21.9497 9.93937L21.9497 3.05029C21.9497 2.498 21.502 2.05028 20.9497 2.05028L14.0607 2.05027C13.4749 2.05027 13 2.52514 13 3.11094C13 3.69673 13.4749 4.17161 14.0607 4.17161L19.0284 4.17161C19.4702 4.17161 19.8284 4.52978 19.8284 4.97161Z" fill="currentColor" />
																</svg>
															</span>
                                        <!--end::Svg Icon-->
                                    </button>
                                    <!--end::Action-->
                                </div>
                                <!--end::Item-->
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::LIst widget 26-->
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-xxl-6">
                        <!--begin::Engage widget 10-->
                        <div class="card card-flush h-md-100">
                            <!--begin::Body-->
                            <div class="card-body d-flex flex-column justify-content-between mt-9 bgi-no-repeat bgi-size-cover bgi-position-x-center pb-0" style="background-position: 100% 50%; background-image:url('assets/media/stock/900x600/42.png')">
                                <!--begin::Wrapper-->
                                <div class="mb-10">
                                    <!--begin::Title-->
                                    <div class="fs-2hx fw-bold text-gray-800 text-center mb-13">
                                        <span class="me-2">Try our all new Enviroment with
                                        <br />
                                        <span class="position-relative d-inline-block text-danger">
                                            <a href="../../demo1/dist/pages/user-profile/overview.html" class="text-danger opacity-75-hover">Pro Plan</a>
                                            <!--begin::Separator-->
                                            <span class="position-absolute opacity-15 bottom-0 start-0 border-4 border-danger border-bottom w-100"></span>
                                            <!--end::Separator-->
                                        </span></span>for Free</div>
                                    <!--end::Title-->
                                    <!--begin::Action-->
                                    <div class="text-center">
                                        <a href='#' class="btn btn-sm btn-dark fw-bold" data-bs-toggle="modal" data-bs-target="#kt_modal_upgrade_plan">Upgrade Now</a>
                                    </div>
                                    <!--begin::Action-->
                                </div>
                                <!--begin::Wrapper-->
                                <!--begin::Illustration-->
                                <img class="mx-auto h-150px h-lg-200px theme-light-show" src="assets/media/illustrations/misc/upgrade.svg" alt="" />
                                <img class="mx-auto h-150px h-lg-200px theme-dark-show" src="assets/media/illustrations/misc/upgrade-dark.svg" alt="" />
                                <!--end::Illustration-->
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Engage widget 10-->
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Row-->
                <!--begin::Row-->
                <div class="row gx-5 gx-xl-10">
                    <!--begin::Col-->
                    <div class="col-xxl-6 mb-5 mb-xl-10">
                        <!--begin::Chart widget 8-->
                        <div class="card card-flush h-xl-100">
                            <!--begin::Header-->
                            <div class="card-header pt-5">
                                <!--begin::Title-->
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold text-dark">Performance Overview</span>
                                    <span class="text-gray-400 mt-1 fw-semibold fs-6">Users from all channels</span>
                                </h3>
                                <!--end::Title-->
                                <!--begin::Toolbar-->
                                <div class="card-toolbar">
                                    <ul class="nav" id="kt_chart_widget_8_tabs">
                                        <li class="nav-item">
                                            <a class="nav-link btn btn-sm btn-color-muted btn-active btn-active-light fw-bold px-4 me-1" data-bs-toggle="tab" id="kt_chart_widget_8_week_toggle" href="#kt_chart_widget_8_week_tab">Month</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link btn btn-sm btn-color-muted btn-active btn-active-light fw-bold px-4 me-1 active" data-bs-toggle="tab" id="kt_chart_widget_8_month_toggle" href="#kt_chart_widget_8_month_tab">Week</a>
                                        </li>
                                    </ul>
                                </div>
                                <!--end::Toolbar-->
                            </div>
                            <!--end::Header-->
                            <!--begin::Body-->
                            <div class="card-body pt-6">
                                <!--begin::Tab content-->
                                <div class="tab-content">
                                    <!--begin::Tab pane-->
                                    <div class="tab-pane fade" id="kt_chart_widget_8_week_tab" role="tabpanel">
                                        <!--begin::Statistics-->
                                        <div class="mb-5">
                                            <!--begin::Statistics-->
                                            <div class="d-flex align-items-center mb-2">
                                                <span class="fs-1 fw-semibold text-gray-400 me-1 mt-n1">$</span>
                                                <span class="fs-3x fw-bold text-gray-800 me-2 lh-1 ls-n2">18,89</span>
                                                <span class="badge badge-light-success fs-base">
																	<!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
																	<span class="svg-icon svg-icon-5 svg-icon-success ms-n1">
																		<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																			<rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="currentColor" />
																			<path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="currentColor" />
																		</svg>
																	</span>
                                                    <!--end::Svg Icon-->4,8%</span>
                                            </div>
                                            <!--end::Statistics-->
                                            <!--begin::Description-->
                                            <span class="fs-6 fw-semibold text-gray-400">Avarage cost per interaction</span>
                                            <!--end::Description-->
                                        </div>
                                        <!--end::Statistics-->
                                        <!--begin::Chart-->
                                        <div id="kt_chart_widget_8_week_chart" class="ms-n5 min-h-auto" style="height: 275px"></div>
                                        <!--end::Chart-->
                                        <!--begin::Items-->
                                        <div class="d-flex flex-wrap pt-5">
                                            <!--begin::Item-->
                                            <div class="d-flex flex-column me-7 me-lg-16 pt-sm-3 pt-6">
                                                <!--begin::Item-->
                                                <div class="d-flex align-items-center mb-3 mb-sm-6">
                                                    <!--begin::Bullet-->
                                                    <span class="bullet bullet-dot bg-primary me-2 h-10px w-10px"></span>
                                                    <!--end::Bullet-->
                                                    <!--begin::Label-->
                                                    <span class="fw-bold text-gray-600 fs-6">Social Campaigns</span>
                                                    <!--end::Label-->
                                                </div>
                                                <!--ed::Item-->
                                                <!--begin::Item-->
                                                <div class="d-flex align-items-center">
                                                    <!--begin::Bullet-->
                                                    <span class="bullet bullet-dot bg-danger me-2 h-10px w-10px"></span>
                                                    <!--end::Bullet-->
                                                    <!--begin::Label-->
                                                    <span class="fw-bold text-&lt;gray-600 fs-6">Google Ads</span>
                                                    <!--end::Label-->
                                                </div>
                                                <!--ed::Item-->
                                            </div>
                                            <!--ed::Item-->
                                            <!--begin::Item-->
                                            <div class="d-flex flex-column me-7 me-lg-16 pt-sm-3 pt-6">
                                                <!--begin::Item-->
                                                <div class="d-flex align-items-center mb-3 mb-sm-6">
                                                    <!--begin::Bullet-->
                                                    <span class="bullet bullet-dot bg-success me-2 h-10px w-10px"></span>
                                                    <!--end::Bullet-->
                                                    <!--begin::Label-->
                                                    <span class="fw-bold text-gray-600 fs-6">Email Newsletter</span>
                                                    <!--end::Label-->
                                                </div>
                                                <!--ed::Item-->
                                                <!--begin::Item-->
                                                <div class="d-flex align-items-center">
                                                    <!--begin::Bullet-->
                                                    <span class="bullet bullet-dot bg-warning me-2 h-10px w-10px"></span>
                                                    <!--end::Bullet-->
                                                    <!--begin::Label-->
                                                    <span class="fw-bold text-gray-600 fs-6">Courses</span>
                                                    <!--end::Label-->
                                                </div>
                                                <!--ed::Item-->
                                            </div>
                                            <!--ed::Item-->
                                            <!--begin::Item-->
                                            <div class="d-flex flex-column pt-sm-3 pt-6">
                                                <!--begin::Item-->
                                                <div class="d-flex align-items-center mb-3 mb-sm-6">
                                                    <!--begin::Bullet-->
                                                    <span class="bullet bullet-dot bg-info me-2 h-10px w-10px"></span>
                                                    <!--end::Bullet-->
                                                    <!--begin::Label-->
                                                    <span class="fw-bold text-gray-600 fs-6">TV Campaign</span>
                                                    <!--end::Label-->
                                                </div>
                                                <!--ed::Item-->
                                                <!--begin::Item-->
                                                <div class="d-flex align-items-center">
                                                    <!--begin::Bullet-->
                                                    <span class="bullet bullet-dot bg-success me-2 h-10px w-10px"></span>
                                                    <!--end::Bullet-->
                                                    <!--begin::Label-->
                                                    <span class="fw-bold text-gray-600 fs-6">Radio</span>
                                                    <!--end::Label-->
                                                </div>
                                                <!--ed::Item-->
                                            </div>
                                            <!--ed::Item-->
                                        </div>
                                        <!--ed::Items-->
                                    </div>
                                    <!--end::Tab pane-->
                                    <!--begin::Tab pane-->
                                    <div class="tab-pane fade active show" id="kt_chart_widget_8_month_tab" role="tabpanel">
                                        <!--begin::Statistics-->
                                        <div class="mb-5">
                                            <!--begin::Statistics-->
                                            <div class="d-flex align-items-center mb-2">
                                                <span class="fs-1 fw-semibold text-gray-400 me-1 mt-n1">$</span>
                                                <span class="fs-3x fw-bold text-gray-800 me-2 lh-1 ls-n2">8,55</span>
                                                <span class="badge badge-light-success fs-base">
																	<!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
																	<span class="svg-icon svg-icon-5 svg-icon-success ms-n1">
																		<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																			<rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="currentColor" />
																			<path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="currentColor" />
																		</svg>
																	</span>
                                                    <!--end::Svg Icon-->2.2%</span>
                                            </div>
                                            <!--end::Statistics-->
                                            <!--begin::Description-->
                                            <span class="fs-6 fw-semibold text-gray-400">Avarage cost per interaction</span>
                                            <!--end::Description-->
                                        </div>
                                        <!--end::Statistics-->
                                        <!--begin::Chart-->
                                        <div id="kt_chart_widget_8_month_chart" class="ms-n5 min-h-auto" style="height: 275px"></div>
                                        <!--end::Chart-->
                                        <!--begin::Items-->
                                        <div class="d-flex flex-wrap pt-5">
                                            <!--begin::Item-->
                                            <div class="d-flex flex-column me-7 me-lg-16 pt-sm-3 pt-6">
                                                <!--begin::Item-->
                                                <div class="d-flex align-items-center mb-3 mb-sm-6">
                                                    <!--begin::Bullet-->
                                                    <span class="bullet bullet-dot bg-primary me-2 h-10px w-10px"></span>
                                                    <!--end::Bullet-->
                                                    <!--begin::Label-->
                                                    <span class="fw-bold text-gray-600 fs-6">Social Campaigns</span>
                                                    <!--end::Label-->
                                                </div>
                                                <!--ed::Item-->
                                                <!--begin::Item-->
                                                <div class="d-flex align-items-center">
                                                    <!--begin::Bullet-->
                                                    <span class="bullet bullet-dot bg-danger me-2 h-10px w-10px"></span>
                                                    <!--end::Bullet-->
                                                    <!--begin::Label-->
                                                    <span class="fw-bold text-gray-600 fs-6">Google Ads</span>
                                                    <!--end::Label-->
                                                </div>
                                                <!--ed::Item-->
                                            </div>
                                            <!--ed::Item-->
                                            <!--begin::Item-->
                                            <div class="d-flex flex-column me-7 me-lg-16 pt-sm-3 pt-6">
                                                <!--begin::Item-->
                                                <div class="d-flex align-items-center mb-3 mb-sm-6">
                                                    <!--begin::Bullet-->
                                                    <span class="bullet bullet-dot bg-success me-2 h-10px w-10px"></span>
                                                    <!--end::Bullet-->
                                                    <!--begin::Label-->
                                                    <span class="fw-bold text-gray-600 fs-6">Email Newsletter</span>
                                                    <!--end::Label-->
                                                </div>
                                                <!--ed::Item-->
                                                <!--begin::Item-->
                                                <div class="d-flex align-items-center">
                                                    <!--begin::Bullet-->
                                                    <span class="bullet bullet-dot bg-warning me-2 h-10px w-10px"></span>
                                                    <!--end::Bullet-->
                                                    <!--begin::Label-->
                                                    <span class="fw-bold text-gray-600 fs-6">Courses</span>
                                                    <!--end::Label-->
                                                </div>
                                                <!--ed::Item-->
                                            </div>
                                            <!--ed::Item-->
                                            <!--begin::Item-->
                                            <div class="d-flex flex-column pt-sm-3 pt-6">
                                                <!--begin::Item-->
                                                <div class="d-flex align-items-center mb-3 mb-sm-6">
                                                    <!--begin::Bullet-->
                                                    <span class="bullet bullet-dot bg-info me-2 h-10px w-10px"></span>
                                                    <!--end::Bullet-->
                                                    <!--begin::Label-->
                                                    <span class="fw-bold text-gray-600 fs-6">TV Campaign</span>
                                                    <!--end::Label-->
                                                </div>
                                                <!--ed::Item-->
                                                <!--begin::Item-->
                                                <div class="d-flex align-items-center">
                                                    <!--begin::Bullet-->
                                                    <span class="bullet bullet-dot bg-success me-2 h-10px w-10px"></span>
                                                    <!--end::Bullet-->
                                                    <!--begin::Label-->
                                                    <span class="fw-bold text-gray-600 fs-6">Radio</span>
                                                    <!--end::Label-->
                                                </div>
                                                <!--ed::Item-->
                                            </div>
                                            <!--ed::Item-->
                                        </div>
                                        <!--ed::Items-->
                                    </div>
                                    <!--end::Tab pane-->
                                </div>
                                <!--end::Tab content-->
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Chart widget 8-->
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
