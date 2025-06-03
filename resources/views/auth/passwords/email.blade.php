@extends('layouts.app')

@section('bg_image')
    <style>body { background-image: url('{{asset('assets/media/auth/bg4.jpg')}}'); } [data-bs-theme="dark"] body { background-image: url('{{asset('assets/media/auth/bg4-dark.jpg')}}'); }</style>
@endsection

@section('content')
    <!--begin::Authentication - Password reset -->
    <div class="d-flex flex-column flex-column-fluid flex-lg-row">
        <!--begin::Aside-->
        <div class="d-flex flex-center w-lg-50 pt-15 pt-lg-0 px-10">
            <!--begin::Aside-->
            <div class="d-flex flex-center flex-lg-start flex-column">
                <!--begin::Logo-->
                <a class="mb-7">
                    <img alt="Logo" src="{{asset('assets/media/logos/custom-3.svg')}}" />
                </a>
                <!--end::Logo-->
                <!--begin::Title-->
                <h2 class="text-white fw-normal m-0">Branding tools designed for your business</h2>
                <!--end::Title-->
            </div>
            <!--begin::Aside-->
        </div>
        <!--begin::Aside-->
        <!--begin::Body-->
        <div class="d-flex flex-center w-lg-50 p-10">
            <!--begin::Card-->
            <div class="card rounded-3 w-md-550px">
                <!--begin::Card body-->
                <div class="card-body d-flex flex-column p-10 p-lg-20 pb-lg-10">
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-center flex-column-fluid pb-15 pb-lg-20">
                        <!--begin::Form-->
                        <form class="form w-100" novalidate="novalidate" id="kt_password_reset_form" data-kt-redirect-url="{{route('login')}}" action="{{route('password.email')}}" method="POST">
                            <!--begin::Heading-->
                            <div class="text-center mb-10">
                                <!--begin::Title-->
                                <h1 class="text-dark fw-bolder mb-3">Forgot Password ?</h1>
                                <!--end::Title-->
                                <!--begin::Link-->
                                @if (session('status'))
                                    <div class="alert alert-success text-center">
                                        {{ session('status') }}
                                    </div>
                                @else
                                    <div class="text-gray-500 fw-semibold fs-6">Enter your email to reset your password.</div>
                                @endif
                                <!--end::Link-->
                            </div>
                            <!--begin::Heading-->
                            @csrf
                            <!--begin::Input group=-->
                            <div class="fv-row mb-8">
                                <!--begin::Email-->
                                <input type="text" placeholder="Email" name="email" autocomplete="off" class="form-control bg-transparent" />
                                <!--end::Email-->
                            </div>
                            <!--begin::Actions-->
                            <div class="d-flex flex-wrap justify-content-center pb-lg-0">
                                <button type="button" id="kt_password_reset_submit" class="btn btn-primary me-4">
                                    <!--begin::Indicator label-->
                                    <span class="indicator-label">Submit</span>
                                    <!--end::Indicator label-->
                                    <!--begin::Indicator progress-->
                                    <span class="indicator-progress">Please wait...
											<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    <!--end::Indicator progress-->
                                </button>
                            </div>
                            <!--end::Actions-->
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Wrapper-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Body-->
    </div>
    <!--end::Authentication - Password reset-->
@endsection
@section('scripts')
    <script src="{{asset('assets/js/custom/authentication/reset-password/reset-password.js')}}"></script>
@endsection
