@extends('admin.layouts.master')

@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                        {{ __('admin.profile.change_password') }}
                    </h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">
                                {{ __('admin.dashboard.title') }}
                            </a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.profile.show') }}" class="text-muted text-hover-primary">
                                {{ __('admin.profile.title') }}
                            </a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            {{ __('admin.profile.change_password') }}
                        </li>
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
            <div id="kt_app_content_container" class="app-container container-xxl">
                <!--begin::Row-->
                <div class="row g-5 g-xl-10">
                    <!--begin::Col-->
                    <div class="col-xl-6">
                        <!--begin::Card-->
                        <div class="card card-flush h-xl-100">
                            <!--begin::Card header-->
                            <div class="card-header border-0 pt-6">
                                <!--begin::Card title-->
                                <div class="card-title">
                                    <!--begin::Search-->
                                    <div class="d-flex align-items-center position-relative my-1">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                        <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                            <i class="fa-solid fa-lock fs-2"></i>
                                        </span>
                                        <!--end::Svg Icon-->
                                        <h3 class="fw-bold m-0 ms-12">{{ __('admin.profile.change_password') }}</h3>
                                    </div>
                                    <!--end::Search-->
                                </div>
                                <!--begin::Card title-->
                            </div>
                            <!--end::Card header-->

                            <!--begin::Card body-->
                            <div class="card-body pt-0">
                                <!--begin::Form-->
                                <form method="POST" action="{{ route('admin.profile.password.update') }}" id="kt_change_password_form">
                                    @csrf
                                    @method('PUT')

                                    <!--begin::Alert-->
                                    @if(session('success'))
                                        <div class="alert alert-success d-flex align-items-center p-5 mb-10">
                                            <!--begin::Svg Icon | path: icons/duotune/general/gen048.svg-->
                                            <span class="svg-icon svg-icon-2hx svg-icon-success me-4">
                                                <i class="fa-solid fa-check-circle"></i>
                                            </span>
                                            <!--end::Svg Icon-->
                                            <div class="d-flex flex-column">
                                                <span>{{ session('success') }}</span>
                                            </div>
                                        </div>
                                    @endif

                                    @if(session('error'))
                                        <div class="alert alert-danger d-flex align-items-center p-5 mb-10">
                                            <!--begin::Svg Icon | path: icons/duotune/general/gen044.svg-->
                                            <span class="svg-icon svg-icon-2hx svg-icon-danger me-4">
                                                <i class="fa-solid fa-exclamation-triangle"></i>
                                            </span>
                                            <!--end::Svg Icon-->
                                            <div class="d-flex flex-column">
                                                <span>{{ session('error') }}</span>
                                            </div>
                                        </div>
                                    @endif
                                    <!--end::Alert-->

                                    <!--begin::Input group-->
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="required fw-semibold fs-6 mb-2">
                                            {{ __('admin.profile.current_password') }}
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <div class="position-relative mb-3">
                                            <input type="password"
                                                   class="form-control form-control-solid mb-3 mb-lg-0"
                                                   name="current_password"
                                                   id="current_password"
                                                   placeholder="{{ __('admin.profile.current_password_placeholder') }}"
                                                   autocomplete="current-password" />
                                            <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2"
                                                  data-kt-password-meter-control="visibility">
                                                <i class="bi bi-eye-slash fs-2"></i>
                                                <i class="bi bi-eye fs-2 d-none"></i>
                                            </span>
                                        </div>
                                        <!--end::Input-->
                                        @error('current_password')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!--end::Input group-->

                                    <!--begin::Input group-->
                                    <div class="mb-10" data-kt-password-meter="true">
                                        <!--begin::Wrapper-->
                                        <div class="mb-1">
                                            <!--begin::Label-->
                                            <label class="form-label fw-semibold fs-6 mb-2 required">
                                                {{ __('admin.profile.new_password') }}
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Input wrapper-->
                                            <div class="position-relative mb-3">
                                                <input class="form-control form-control-solid"
                                                       type="password"
                                                       name="password"
                                                       id="password"
                                                       placeholder="{{ __('admin.profile.new_password_placeholder') }}"
                                                       autocomplete="new-password" />
                                                <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2"
                                                      data-kt-password-meter-control="visibility">
                                                    <i class="bi bi-eye-slash fs-2"></i>
                                                    <i class="bi bi-eye fs-2 d-none"></i>
                                                </span>
                                            </div>
                                            <!--end::Input wrapper-->
                                            <!--begin::Meter-->
                                            <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                                            </div>
                                            <!--end::Meter-->
                                            @error('password')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <!--end::Wrapper-->
                                        <!--begin::Hint-->
                                        <div class="text-muted">
                                            {{ __('admin.profile.password_requirements') }}
                                        </div>
                                        <!--end::Hint-->
                                    </div>
                                    <!--end::Input group-->

                                    <!--begin::Input group-->
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="required fw-semibold fs-6 mb-2">
                                            {{ __('admin.profile.confirm_password') }}
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <div class="position-relative mb-3">
                                            <input type="password"
                                                   class="form-control form-control-solid mb-3 mb-lg-0"
                                                   name="password_confirmation"
                                                   id="password_confirmation"
                                                   placeholder="{{ __('admin.profile.confirm_password_placeholder') }}"
                                                   autocomplete="new-password" />
                                            <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2"
                                                  data-kt-password-meter-control="visibility">
                                                <i class="bi bi-eye-slash fs-2"></i>
                                                <i class="bi bi-eye fs-2 d-none"></i>
                                            </span>
                                        </div>
                                        <!--end::Input-->
                                        @error('password_confirmation')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!--end::Input group-->

                                    <!--begin::Actions-->
                                    <div class="text-center pt-15">
                                        <a href="{{ route('admin.profile.show') }}" class="btn btn-light me-3">
                                            {{ __('admin.profile.cancel') }}
                                        </a>
                                        <button type="submit" id="kt_change_password_submit" class="btn btn-primary">
                                            <span class="indicator-label">{{ __('admin.profile.update_password') }}</span>
                                            <span class="indicator-progress">
                                                {{ __('admin.profile.please_wait') }}...
                                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                            </span>
                                        </button>
                                    </div>
                                    <!--end::Actions-->
                                </form>
                                <!--end::Form-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Card-->
                    </div>
                    <!--end::Col-->

                    <!--begin::Col-->
                    <div class="col-xl-6">
                        <!--begin::Card-->
                        <div class="card card-flush h-xl-100">
                            <!--begin::Card header-->
                            <div class="card-header border-0 pt-6">
                                <!--begin::Card title-->
                                <div class="card-title">
                                    <!--begin::Search-->
                                    <div class="d-flex align-items-center position-relative my-1">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                        <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                            <i class="fa-solid fa-shield-halved fs-2"></i>
                                        </span>
                                        <!--end::Svg Icon-->
                                        <h3 class="fw-bold m-0 ms-12">{{ __('admin.profile.security_tips') }}</h3>
                                    </div>
                                    <!--end::Search-->
                                </div>
                                <!--begin::Card title-->
                            </div>
                            <!--end::Card header-->

                            <!--begin::Card body-->
                            <div class="card-body pt-0">
                                <!--begin::Notice-->
                                <div class="notice d-flex bg-light-primary rounded border-primary border border-dashed p-6">
                                    <!--begin::Icon-->
                                    <span class="svg-icon svg-icon-2tx svg-icon-primary me-4">
                                        <i class="fa-solid fa-lightbulb"></i>
                                    </span>
                                    <!--end::Icon-->
                                    <!--begin::Wrapper-->
                                    <div class="d-flex flex-stack flex-grow-1">
                                        <!--begin::Content-->
                                        <div class="fw-semibold">
                                            <h4 class="text-gray-900 fw-bold">{{ __('admin.profile.password_security_title') }}</h4>
                                            <div class="fs-6 text-gray-700">
                                                <ul class="list-unstyled">
                                                    <li class="d-flex align-items-center py-2">
                                                        <i class="fa-solid fa-check text-success me-3"></i>
                                                        {{ __('admin.profile.security_tip_1') }}
                                                    </li>
                                                    <li class="d-flex align-items-center py-2">
                                                        <i class="fa-solid fa-check text-success me-3"></i>
                                                        {{ __('admin.profile.security_tip_2') }}
                                                    </li>
                                                    <li class="d-flex align-items-center py-2">
                                                        <i class="fa-solid fa-check text-success me-3"></i>
                                                        {{ __('admin.profile.security_tip_3') }}
                                                    </li>
                                                    <li class="d-flex align-items-center py-2">
                                                        <i class="fa-solid fa-check text-success me-3"></i>
                                                        {{ __('admin.profile.security_tip_4') }}
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <!--end::Content-->
                                    </div>
                                    <!--end::Wrapper-->
                                </div>
                                <!--end::Notice-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Card-->
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

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Password visibility toggle
            const passwordFields = document.querySelectorAll('input[type="password"]');
            const toggleButtons = document.querySelectorAll('[data-kt-password-meter-control="visibility"]');

            toggleButtons.forEach((button, index) => {
                button.addEventListener('click', function() {
                    const passwordField = passwordFields[index];
                    const eyeSlash = button.querySelector('.bi-eye-slash');
                    const eye = button.querySelector('.bi-eye');

                    if (passwordField.type === 'password') {
                        passwordField.type = 'text';
                        eyeSlash.classList.add('d-none');
                        eye.classList.remove('d-none');
                    } else {
                        passwordField.type = 'password';
                        eyeSlash.classList.remove('d-none');
                        eye.classList.add('d-none');
                    }
                });
            });

            // Password strength meter
            const passwordInput = document.getElementById('password');
            const strengthIndicators = document.querySelectorAll('[data-kt-password-meter-control="highlight"] > div');

            if (passwordInput && strengthIndicators.length > 0) {
                passwordInput.addEventListener('input', function() {
                    const password = this.value;
                    const strength = calculatePasswordStrength(password);

                    // Reset all indicators
                    strengthIndicators.forEach(indicator => {
                        indicator.classList.remove('bg-success', 'bg-warning', 'bg-danger');
                        indicator.classList.add('bg-secondary');
                    });

                    // Update indicators based on strength
                    for (let i = 0; i < strength && i < strengthIndicators.length; i++) {
                        strengthIndicators[i].classList.remove('bg-secondary');
                        if (strength <= 1) {
                            strengthIndicators[i].classList.add('bg-danger');
                        } else if (strength <= 3) {
                            strengthIndicators[i].classList.add('bg-warning');
                        } else {
                            strengthIndicators[i].classList.add('bg-success');
                        }
                    }
                });
            }

            // Form submission
            const form = document.getElementById('kt_change_password_form');
            const submitButton = document.getElementById('kt_change_password_submit');

            if (form && submitButton) {
                form.addEventListener('submit', function() {
                    submitButton.setAttribute('data-kt-indicator', 'on');
                    submitButton.disabled = true;
                });
            }
        });

        function calculatePasswordStrength(password) {
            let strength = 0;

            // Length check
            if (password.length >= 8) strength++;

            // Lowercase check
            if (/[a-z]/.test(password)) strength++;

            // Uppercase check
            if (/[A-Z]/.test(password)) strength++;

            // Number check
            if (/\d/.test(password)) strength++;

            // Special character check
            if (/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password)) strength++;

            return Math.min(strength, 4);
        }
    </script>
@endsection
