@extends('template/layout/master')
@section('body')
    <!-- Hero Section -->
    <div class="hero-section position-relative" style="
    background-image: url('{{ asset('assets/imgs/template/home.jpeg') }}');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    height: 100vh;">

        <!-- Overlay -->
        <div class="overlay position-absolute top-0 start-0 w-100 h-100" style="
        background: linear-gradient(180deg, rgba(111, 66, 193, 0.5) 0%, rgba(111, 66, 193, 0) 100%);
        z-index: 1;">
        </div>

        <div class="container ssmall-section">
            <div class="row align-items-center">
                <!-- Left: Text -->
                <div class="col-lg-6 mb-4 mb-lg-0 mt-5">
                    <h1 class="display-5 fw-bold mb-3" style="font-size: 43px; color: white">Equip students for college<br>and career success based<br>on their unique aptitudes</h1>
                    <p class="lead-section mb-3" style="font-size: 150% ; color: white">Furass is the only career readiness (CCR) platform specifically built to ensure compliance and deliver measurable impact for students</p>
                    <div class="abilities">
                        <div class="element m-4">
                            <p class="pt-3" style="font-size: 18px">Want to discover your abilities?</p>
                            <div class="program d-flex gap-5 position-relative pb-2 pt-0">
                                <p style="font-size: 12px;top: -8px;" class="position-absolute">Choose a Program</p>
                                <div class="pro-title">
                                    <p style="font-size: 13px" class="m-3">Self Compass Plus Program</p>
                                </div>
                                <button class="position-absolute">Next</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Right: Image and Details -->
                <div class="col-lg-6 d-flex justify-content-center align-items-center position-relative">
                    <div class="position-relative" style="display:inline-block;">
                        <!-- Main Image in rounded rectangle -->
                       {{-- <div class="  position-relative" style="overflow:hidden; width:460px; max-width:100%;">
                            <img src="{{asset('assets/imgs/hero.png')}}" alt="Student with headphones" class="img-fluid w-75" style="margin-left: 15%">
                            <!-- Floating Card -->
                        </div>--}}
                    </div>
                </div>
            </div>
            <!-- Centered Text at Bottom -->
        </div>

    </div>
    <!-- program Section -->
    <div class="container mb-5 mt-2 program" >
        <h1 class="h-section mb-5 mt-5 text-center">Choose Your Program</h1>
        <div class="row">
            <div class="col-lg-4  col-sm-1">
                <div class="card">
                    <h4>Self Compass Plus program</h4>
                    <p>Take test & Know your potential</p>
                    <img src="{{asset('assets/imgs/template/program1.jpg')}}" class="centered-image  mb-5" alt="Furass Logo">
                    <button class="btn">Learn more</button>
                </div>
            </div>
            <div class="col-lg-4  col-sm-1 ">
                <div class="card">
                    <h4>Explore Your Career Destination program</h4>
                    <p>Go on trips & Discover the practical life on field</p>
                    <img src="{{asset('assets/imgs/template/program2.jpg')}}" class="centered-image  mb-5" alt="Furass Logo">
                    <button class="btn">Learn more</button>
                </div>
            </div>
            <div class="col-lg-4  col-sm-1 ">
                <div class="card">
                    <h4>Ready For The Future program</h4>
                    <p>Workshop to learn more about Different careers</p>
                    <img src="{{asset('assets/imgs/template/program3.jpg')}}" class="centered-image mb-5" alt="Furass Logo">
                    <button class="btn">Learn more</button>
                </div>
            </div>

        </div>
    </div>
@endsection
