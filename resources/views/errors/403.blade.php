@extends('layouts.errors')

@section('title','Unauthorized')

@section('content')
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <!--begin::Page bg image-->
        <style>body { background-image: url('{{asset('assets/media/auth/bg8.jpg')}}'); }
            [data-bs-theme="dark"] body { background-image: url('{{asset('assets/media/auth/bg8-dark.jpg')}}'); }
        </style>
        <!--end::Page bg image-->
        <!--begin::Authentication - Unauthorized Message -->
        <div class="d-flex flex-column flex-center flex-column-fluid">
            <!--begin::Content-->
            <div class="d-flex flex-column flex-center text-center p-10">
                <!--begin::Wrapper-->
                <div class="card card-flush w-lg-650px py-5">
                    <div class="card-body py-15 py-lg-20">
                        <!--begin::Title-->
                        <h1 class="fw-bolder fs-2hx text-gray-900 mb-4">Access Denied</h1>
                        <!--end::Title-->
                        <!--begin::Text-->
                        <div class="fw-semibold fs-6 text-danger mb-7">
                            {{ $exception->getMessage() ?? 'You don’t have permission to access this page.' }}
                        </div>
                        <!--end::Text-->
                        <!--begin::Illustration-->
                        <div class="mb-3">
                            <img src="{{asset('assets/media/auth/403-error.svg')}}" class="mw-100 mh-300px theme-light-show" alt="" />
                            <img src="{{asset('assets/media/auth/403-error.svg')}}" class="mw-100 mh-300px theme-dark-show" alt="" />
                        </div>
                        <!--end::Illustration-->
                        <!--begin::Link-->
                        <div class="mb-0">
                            <a href="{{ url()->previous() }}" class="btn btn-sm btn-primary">Go Back</a>
                        </div>
                        <!--end::Link-->
                    </div>
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Authentication - Unauthorized Message-->
    </div>
@endsection
