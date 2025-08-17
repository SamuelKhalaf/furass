@extends('template/layout/master')
@push('css')
    <style>
        /* Video Background Styles */
        .video-background {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            min-width: 100%;
            min-height: 100%;
            width: auto;
            height: auto;
            z-index: -1;
        }

        /* Maintain aspect ratio */
        .video-background video {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            min-width: 100%;
            min-height: 100%;
            width: auto;
            height: auto;
        }

        /* Responsive adjustments */
        @media (max-aspect-ratio: 16/9) {
            .video-background {
                width: auto;
                height: 100%;
            }
        }

        @media (min-aspect-ratio: 16/9) {
            .video-background {
                width: 100%;
                height: auto;
            }
        }
    </style>
@endpush
@section('body')
    <!-- Hero Section -->
    <div class="hero-section position-relative" style="height: 100vh; padding-top: 80px; overflow: hidden;">
        <!-- Background Video Container -->
        <div class="video-background position-absolute w-100 h-100">
            <video autoplay muted loop playsinline class="h-100 w-100" style="object-fit: cover;">
                <source src="{{ asset('assets/videos/hero_section1.mp4') }}" type="video/mp4">
                <!-- Fallback image if video doesn't load -->
                <img src="{{ asset('imgs/template/home.jpeg') }}" alt="Fallback Background" style="object-fit: cover; width: 100%; height: 100%;">
            </video>
        </div>

        <!-- Overlay -->
        <div class="overlay position-absolute top-0 start-0 w-100 h-100" style="
        background: linear-gradient(180deg, rgba(111, 66, 193, 0.5) 0%, rgba(111, 66, 193, 0) 100%);
        z-index: 1;">
        </div>

        <div class="container ssmall-section position-relative" style="z-index: 2; height: 100%;">
            <div class="row align-items-center h-100">
                <!-- Left: Text -->
                <div class="col-lg-6 mb-4 mb-lg-0">
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

            <p class="fw-bold f-p text-center text-md-start">
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
                         class="img-fluid" style="max-height: 400px; object-fit: contain;">
                </div>

                <div class="col-12 mt-4">
                    <div class="d-flex flex-column flex-sm-row justify-content-center justify-content-lg-start gap-3 button">
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
    </div>


@endsection
