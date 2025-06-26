@extends('template/layout/master')
@section('body')
    <!-- Hero Section -->
    <div class="hero-section position-relative" style="height: 100vh; padding-top: 80px;">
        <div class="hero-bg-image"></div>
        <!-- Overlay -->
        <div class="overlay position-absolute top-0 start-0 w-100 h-100" style="
            background: linear-gradient(180deg, rgba(111, 66, 193, 0.5) 0%, rgba(111, 66, 193, 0) 100%);
            z-index: 1;">
        </div>
        <div class="container ssmall-section">
            <div class="row align-items-center">
                <!-- Left: Text -->
                <div class="col-lg-6 mb-4 mb-lg-0 mt-5">
                    <h1 class="display-5 fw-bold mb-3" style="font-size: 43px; color: white">
                        {{ __('template.home.img_sec.title') }}
                    </h1>
                    <p class="lead-section mb-3" style="font-size: 150%; color: white">
                        {{ __('template.home.img_sec.desc') }}
                    </p>
                    <div class="position-relative z-2">
                        <div class="d-flex flex-column flex-sm-row gap-3">
                            <a href="{{ route('template.programs') }}" class="btn fw-bold px-4 py-2"
                               style="background:#543786; color:#fff; border-radius:24px; border: none;">
                                {{ __('template.home.img_sec.explore_programs') }}
                            </a>
                            <a href="{{ route('template.school') }}" class="btn fw-bold px-4 py-2"
                               style="background:#543786; color:#fff; border-radius:24px; border: none;">
                                {{ __('template.home.img_sec.request_school') }}
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- program Section -->
    <div class="prog-home mt-5 mb-5">
        <div class="container">
            <h1 class="text-center mb-4" style="color: #6f42c1">
                {{ __('template.home.prog_section.title') }}
            </h1>
            <p class="fw-bold f-p">
                {{ __('template.home.prog_section.desc') }}
            </p>

            <div class="disc-prog row align-items-center">
                <div class="col-12 col-lg-6">
                    <p class="fw-bold">{{ __('template.home.prog_section.para1') }}</p>
                    <p class="fw-bold">{{ __('template.home.prog_section.para2') }}</p>
                    <p class="fw-bold">{{ __('template.home.prog_section.point1') }}</p>
                    <p class="fw-bold">{{ __('template.home.prog_section.point2') }}</p>
                    <p class="fw-bold">{{ __('template.home.prog_section.point3') }}</p>
                </div>

                <div class="col-12 col-lg-6 text-center mt-4 mt-lg-0">
                    <img src="{{ asset('assets/imgs/template/home-program.png') }}" alt="Furass Logo"
                         style="max-width: 100%; height: auto; max-height: 400px; object-fit: contain;">
                </div>

                <div class="d-flex flex-column flex-sm-row gap-3 button">
                    <a href="{{ route('template.programs') }}" class="btn fw-bold px-4 py-2"
                       style="background:#543786; color:#fff; border-radius:24px; border: none;">
                        {{ __('template.home.prog_section.explore_btn') }}
                    </a>
                    <a href="{{ route('template.about') }}" class="btn fw-bold px-4 py-2"
                       style="background:#543786; color:#fff; border-radius:24px; border: none;">
                        {{ __('template.home.prog_section.about_btn') }}
                    </a>
                </div>
            </div>
        </div>
    </div>


@endsection
