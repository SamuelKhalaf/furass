@extends('admin.layouts.master')

@section('content')
    <!--begin::Content wrapper-->
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                        {{ __('admin.profile.title') }}
                    </h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">
                                {{ __('admin.dashboard.title') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">{{ __('admin.profile.title') }}</li>
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
                <!--begin::Actions-->
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <a href="{{ route('admin.profile.edit') }}" class="btn btn-sm fw-bold btn-primary">
                        <i class="fa-solid fa-pen-to-square"></i>
                        {{ __('admin.profile.edit') }}
                    </a>
                    <a href="{{ route('admin.profile.password.edit') }}" class="btn btn-sm fw-bold btn-secondary">
                        <i class="fa-solid fa-key"></i>
                        {{ __('admin.profile.change_password') }}
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
            <div id="kt_app_content_container" class="app-container container-xxl">
                @if(session('success'))
                    <div class="alert alert-success d-flex align-items-center p-5 mb-10">
                        <i class="fa-solid fa-check fs-2hx text-success me-4"></i>
                        <div class="d-flex flex-column">
                            <span>{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                <!--begin::Layout-->
                <div class="d-flex flex-column flex-xl-row">
                    <!--begin::Sidebar-->
                    <div class="flex-column flex-lg-row-auto w-100 w-xl-350px mb-10">
                        <!--begin::Card-->
                        <div class="card mb-5 mb-xl-8">
                            <!--begin::Card body-->
                            <div class="card-body pt-15">
                                <!--begin::Summary-->
                                <div class="d-flex flex-center flex-column mb-5">
                                    <!--begin::Avatar-->
                                    <div class="symbol symbol-100px symbol-circle mb-7">
                                        @if($profileData['has_avatar'] && $profileData['avatar_path'])
                                            <img src="{{ asset('storage/' . $profileData['avatar_path']) }}" alt="image" />
                                        @else
                                            <div class="symbol-label fs-3 bg-light-primary text-primary">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>
                                    <!--end::Avatar-->
                                    <!--begin::Name-->
                                    <a href="#" class="fs-3 text-gray-800 text-hover-primary fw-bold mb-1">
                                        {{ $user->name }}
                                    </a>
                                    <!--end::Name-->
                                    <!--begin::Position-->
                                    <div class="fs-5 fw-semibold text-muted mb-6">
                                        {{ __('admin.profile.roles.' . $profileData['type']) }}
                                    </div>
                                    <!--end::Position-->
                                </div>
                                <!--end::Summary-->
                                <!--begin::Details toggle-->
                                <div class="d-flex flex-stack fs-4 py-3">
                                    <div class="fw-bold rotate collapsible" data-bs-toggle="collapse" href="#kt_customer_view_details" role="button" aria-expanded="false" aria-controls="kt_customer_view_details">
                                        {{ __('admin.profile.details') }}
                                        <span class="ms-2 rotate-180">
                                            <i class="fa-solid fa-chevron-down fs-8"></i>
                                        </span>
                                    </div>
                                </div>
                                <!--end::Details toggle-->
                                <div class="separator separator-dashed my-3"></div>
                                <!--begin::Details content-->
                                <div id="kt_customer_view_details" class="collapse show">
                                    <div class="py-5 fs-6">
                                        <!--begin::Details item-->
                                        <div class="fw-bold mt-5">{{ __('admin.profile.email') }}</div>
                                        <div class="text-gray-600">{{ $user->email }}</div>
                                        <!--begin::Details item-->
                                        <!--begin::Details item-->
                                        <div class="fw-bold mt-5">{{ __('admin.profile.phone') }}</div>
                                        <div class="text-gray-600">{{ $user->phone_number }}</div>
                                        <!--begin::Details item-->
                                        <!--begin::Details item-->
                                        <div class="fw-bold mt-5">{{ __('admin.profile.created_at') }}</div>
                                        <div class="text-gray-600">{{ $user->created_at->format('d/m/Y H:i') }}</div>
                                        <!--begin::Details item-->
                                    </div>
                                </div>
                                <!--end::Details content-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Card-->
                    </div>
                    <!--end::Sidebar-->

                    <!--begin::Content-->
                    <div class="flex-lg-row-fluid ms-lg-15">
                        <!--begin::Card-->
                        <div class="card card-flush pt-3 mb-5 mb-xl-10">
                            <!--begin::Card header-->
                            <div class="card-header">
                                <!--begin::Card title-->
                                <div class="card-title">
                                    <h2 class="fw-bold">{{ __('admin.profile.information') }}</h2>
                                </div>
                                <!--end::Card title-->
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body pt-3">
                                <!--begin::Section-->
                                <div class="mb-10">
                                    <!--begin::Title-->
                                    <h5 class="mb-4">{{ __('admin.profile.basic_info') }}</h5>
                                    <!--end::Title-->
                                    <!--begin::Details-->
                                    <div class="row mb-7">
                                        <label class="col-lg-4 fw-semibold text-muted">{{ __('admin.profile.name') }}</label>
                                        <div class="col-lg-8">
                                            <span class="fw-bold fs-6 text-gray-800">{{ $user->name }}</span>
                                        </div>
                                    </div>
                                    <div class="row mb-7">
                                        <label class="col-lg-4 fw-semibold text-muted">{{ __('admin.profile.email') }}</label>
                                        <div class="col-lg-8 fv-row">
                                            <span class="fw-bold fs-6 text-gray-800">{{ $user->email }}</span>
                                        </div>
                                    </div>
                                    <div class="row mb-7">
                                        <label class="col-lg-4 fw-semibold text-muted">{{ __('admin.profile.phone') }}</label>
                                        <div class="col-lg-8 d-flex align-items-center">
                                            <span class="fw-bold fs-6 text-gray-800 me-2">{{ $user->phone_number }}</span>
                                        </div>
                                    </div>
                                    <div class="row mb-7">
                                        <label class="col-lg-4 fw-semibold text-muted">{{ __('admin.profile.role') }}</label>
                                        <div class="col-lg-8 d-flex align-items-center">
                                            <span class="badge badge-light-primary">{{ __('admin.profile.roles.' . $profileData['type']) }}</span>
                                        </div>
                                    </div>
                                    <!--end::Details-->
                                </div>
                                <!--end::Section-->

                                @if($profileData['additional_data'])
                                    <!--begin::Section-->
                                    <div class="mb-10">
                                        <!--begin::Title-->
                                        <h5 class="mb-4">{{ __('admin.profile.additional_info') }}</h5>
                                        <!--end::Title-->
                                        <!--begin::Details-->
                                        @if($profileData['type'] === 'consultant')
                                            <div class="row mb-7">
                                                <label class="col-lg-4 fw-semibold text-muted">{{ __('admin.profile.bio') }}</label>
                                                <div class="col-lg-8">
                                                    <span class="fw-semibold fs-6 text-gray-800">
                                                        {{ $profileData['additional_data']->bio ?? __('admin.profile.not_provided') }}
                                                    </span>
                                                </div>
                                            </div>
                                        @elseif($profileData['type'] === 'school')
                                            <div class="row mb-7">
                                                <label class="col-lg-4 fw-semibold text-muted">{{ __('admin.profile.school_name') }}</label>
                                                <div class="col-lg-8">
                                                    <span class="fw-semibold fs-6 text-gray-800">{{ $profileData['additional_data']->user->name }}</span>
                                                </div>
                                            </div>
                                            <div class="row mb-7">
                                                <label class="col-lg-4 fw-semibold text-muted">{{ __('admin.profile.address') }}</label>
                                                <div class="col-lg-8">
                                                    <span class="fw-semibold fs-6 text-gray-800">
                                                        {{ $profileData['additional_data']->address ?? __('admin.profile.not_provided') }}
                                                    </span>
                                                </div>
                                            </div>
                                        @elseif($profileData['type'] === 'student')
                                            <div class="row mb-7">
                                                <label class="col-lg-4 fw-semibold text-muted">{{ __('admin.profile.grade') }}</label>
                                                <div class="col-lg-8">
                                                    <span class="badge badge-light-info">{{ $profileData['additional_data']->grade }}</span>
                                                </div>
                                            </div>
                                            @if($profileData['additional_data']->birth_date)
                                                <div class="row mb-7">
                                                    <label class="col-lg-4 fw-semibold text-muted">{{ __('admin.profile.birth_date') }}</label>
                                                    <div class="col-lg-8">
                                                        <span class="fw-semibold fs-6 text-gray-800">
                                                            {{ \Carbon\Carbon::parse($profileData['additional_data']->birth_date)->format('d/m/Y') }}
                                                        </span>
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="row mb-7">
                                                <label class="col-lg-4 fw-semibold text-muted">{{ __('admin.profile.gender') }}</label>
                                                <div class="col-lg-8">
                                                    <span class="badge badge-light-{{ $profileData['additional_data']->gender === 'male' ? 'primary' : 'danger' }}">
                                                        {{ __('admin.profile.gender_' . $profileData['additional_data']->gender) }}
                                                    </span>
                                                </div>
                                            </div>
                                        @endif
                                        <!--end::Details-->
                                    </div>
                                    <!--end::Section-->
                                @endif
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Card-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Layout-->
            </div>
            <!--end::Content container-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Content wrapper-->
@endsection
