@extends('template/layout/master')
@section('body')
    <!-- Hero Section -->
    <div class="hero-section position-relative" style="
        background-image: url('{{ asset('assets/imgs/template/home.jpeg') }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        height: 100vh;
        padding-top: 80px;">
        <!-- Overlay -->
        <div class="overlay position-absolute top-0 start-0 w-100 h-100" style="
            background: linear-gradient(180deg, rgba(111, 66, 193, 0.5) 0%, rgba(111, 66, 193, 0) 100%);
            z-index: 1;">
        </div>
        <div class="container ssmall-section">
            <div class="row align-items-center">
                <!-- Left: Text -->
                <div class="col-lg-6 mb-4 mb-lg-0 mt-5">
                    <h1 class="display-5 fw-bold mb-3" style="font-size: 43px; color: white">Bridge Education to Real-World Careers</h1>
                    <p class="lead-section mb-3" style="font-size: 150% ; color: white">Furass connects students with industries and universities through immersive experiences, helping them discover their passions and plan for the future with confidence.</p>
                    <div class="position-relative z-2">
                        <div class="d-flex flex-column flex-sm-row gap-3">
                            <a href="{{ route('template.details-programs') }}" class="btn fw-bold px-4 py-2"
                               style="background:#543786; color:#fff; border-radius:24px; border: none;">
                                Explore Our Programs
                            </a>
                            <a href="{{ route('template.school') }}" class="btn fw-bold px-4 py-2"
                               style="background:#543786; color:#fff; border-radius:24px; border: none;">
                                Request a School Partnership
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
                Furass – Guiding Saudi Students Toward a Brighter Future
            </h1>
            <p class="fw-bold f-p" style="">
                Furass is a Saudi initiative designed to empower high school students to make confident, informed decisions about their future.
            </p>

            <div class="disc-prog row align-items-center">
                <div class="col-12 col-lg-6">
                    <p class="fw-bold">Our structured path combines assessment, experience, and growth, using validated tools and real experiences—led by professionals and supported by families and schools.</p>
                    <p class="fw-bold">We offer an integrated journey that helps students:</p>
                    <p class="fw-bold">✅ gain deep self-awareness</p>
                    <p class="fw-bold">✅ explore real-world career environments</p>
                    <p class="fw-bold">✅ build the skills they need for university and life</p>
                </div>

                <div class="col-12 col-lg-6 text-center mt-4 mt-lg-0">
                    <img src="{{ asset('assets/imgs/template/home-program.png') }}" alt="Furass Logo"
                         style="max-width: 100%; height: auto; max-height: 400px; object-fit: contain;">
                </div>

                <div class="d-flex flex-column flex-sm-row gap-3 button" style="">
                    <a href="{{ route('template.programs') }}" class="btn fw-bold px-4 py-2"
                       style="background:#543786; color:#fff; border-radius:24px; border: none;">
                        Explore our programs
                    </a>
                    <a href="{{ route('template.about') }}" class="btn fw-bold px-4 py-2"
                       style="background:#543786; color:#fff; border-radius:24px; border: none;">
                        Learn more about Furass
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection
