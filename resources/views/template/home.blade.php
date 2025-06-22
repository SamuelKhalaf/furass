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
                    <div class="abilities">
                        <div class="element m-4">
                            <p class="pt-3" style="font-size: 18px ; color: black">Want to discover your abilities?</p>
                            <div class="program d-flex gap-5 position-relative pb-2 pt-0">
                                <p style="font-size: 12px;top: -8px; color: black" class="position-absolute">Choose a Program</p>
                                <div class="pro-title">
                                    <p style="font-size: 13px ; color: black" class="m-3">Self Compass Plus Program</p>
                                </div>
                                <button class="position-absolute">Next</button>
                            </div>
                        </div>
                    </div>
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
            <!-- Centered Text at Bottom -->
        </div>

    </div>
    <!-- program Section -->
    <div class="disc-program">
        <div class="container-fluid main-container">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-10">
                    <div class="content-wrapper px-3">
                        <h1 class="main-title">Welcome to Our Career Development Hub</h1>

                        <p class="description">
                            We offer comprehensive career development programs designed to help you discover your potential,
                            explore different career paths, and develop the skills needed for future success. Our programs
                            provide personalized guidance, hands-on experiences, and practical tools to support your
                            professional journey.
                        </p>

                        <a href="{{route('template.programs')}}" class="programs-button" onclick="goToPrograms()">View Our Programs</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
{{--    <div class="container mb-5 mt-2 program" >
        <h1 class="h-section mb-5 mt-5 text-center">Choose Your Program</h1>
        <div class="row">
            <div class="col-lg-4  col-sm-1">
                <div class="card">
                    <h4>Self Compass Plus</h4>
                    <p>Assessments & guidance</p>
                    <img src="{{asset('assets/imgs/template/program1.jpg')}}" class="centered-image  mb-5" alt="Furass Logo">
                    <a href="{{ route('template.details-programs') }}#self-compass" class="btn ">Learn more</a>
                </div>
            </div>
            <div class="col-lg-4  col-sm-1 ">
                <div class="card">
                    <h4> Explore Your Career Destinations </h4>
                    <p>Trips & exposure</p>
                    <img src="{{asset('assets/imgs/template/program2.jpg')}}" class="centered-image  mb-5" alt="Furass Logo">
                    <a href="{{ route('template.details-programs') }}#explore-career" class="btn ">Learn more</a>
                </div>
            </div>
            <div class="col-lg-4  col-sm-1 ">
                <div class="card">
                    <h4> Ready for the Future</h4>
                    <p>Life & career skills</p>
                    <img src="{{asset('assets/imgs/template/program3.jpg')}}" class="centered-image mb-5" alt="Furass Logo">
                    <a href="{{ route('template.details-programs') }}#ready-future" class="btn ">Learn more</a>
                </div>
            </div>

        </div>
    </div>--}}
@endsection
