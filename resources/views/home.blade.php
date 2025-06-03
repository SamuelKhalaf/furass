@extends('layouts.app')

@section('bg_image')
    <!--begin::Page bg image-->
    <style>body { background-image: url('{{asset('assets/media/auth/bg8.jpg')}}'); } [data-bs-theme="dark"] body { background-image: url('{{asset('assets/media/auth/bg8-dark.jpg')}}'); }</style>
    <!--end::Page bg image-->
@endsection

@section('content')
    <!--begin::Authentication - Signup Welcome Message -->
    <div class="d-flex flex-column flex-center flex-column-fluid">
        <!--begin::Content-->
        <div class="d-flex flex-column flex-center text-center p-10">
            <!--begin::Wrapper-->
            <div class="card card-flush w-md-650px py-5">
                <div class="card-body py-15 py-lg-20">
                    <!--begin::Logo-->
                    <div>
                        <a href="" class="">
                            <img alt="Logo" src="{{asset('assets/media/logos/furass.png')}}" style="width: 270px; height: 190px;" />
                        </a>
                    </div>
                    <!--end::Logo-->
                    <!--begin::Title-->
                    <h1 class="fw-bolder text-gray-900 mb-5" style="position: relative; top: -20px">Welcome to Furass</h1>
                    <!--end::Title-->
                    <!--begin::Text-->
                    <div class="fw-semibold fs-6 text-gray-500 mb-7">This is your opportunity to get creative and make a name
                        <br />that gives readers an idea</div>
                    <!--end::Text-->
                    <!--begin::Illustration-->
                    <div class="mb-0">
                        <img src="{{asset('assets/media/auth/welcome.png')}}" class="mw-100 mh-300px theme-light-show" alt="" />
                        <img src="{{asset('assets/media/auth/welcome-dark.png')}}" class="mw-100 mh-300px theme-dark-show" alt="" />
                    </div>
                    <!--end::Illustration-->
                    <!--begin::Link-->
                    <div class="mb-0">
                        @auth
                            <a href="{{route('admin.dashboard')}}" class="btn btn-sm btn-primary">Go To Dashboard</a>
                            <a href="#" class="btn btn-sm btn-outline-primary"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                            <form id="logout-form" method="POST" action="{{route('logout')}}" style="display: none;">
                                @csrf
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-sm btn-primary">Login</a>
{{--                            <a href="{{ route('register') }}" class="btn btn-sm btn-outline-primary">Register</a>--}}
                        @endauth
                    </div>
                    <!--end::Link-->
                </div>
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Authentication - Signup Welcome Message-->
@endsection
