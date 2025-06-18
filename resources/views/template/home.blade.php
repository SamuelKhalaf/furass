@extends('template/layout/master')
@section('body')
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container ssmall-section">
            <div class="row align-items-center">
                <!-- Left: Text -->
                <div class="col-lg-6 mb-4 mb-lg-0 mt-5">
                    <h1 class="display-5 fw-bold mb-3" style="font-size: 43px">Equip students for college<br>and career success based<br>on their unique aptitudes</h1>
                    <p class="lead-section mb-3" style="font-size: 150%">Furass is the only career readiness (CCR) platform specifically built to ensure compliance and deliver measurable impact for students</p>


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
                        <div class="  position-relative" style="overflow:hidden; width:460px; max-width:100%;">
                            <img src="{{asset('assets/imgs/hero.png')}}" alt="Student with headphones" class="img-fluid w-75" style="margin-left: 15%">
                            <!-- Floating Card -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- Centered Text at Bottom -->

        </div>

    </section>
    <!-- program Section -->
    <div class="container mb-5 mt-5 program" >
        <h1 class="h-section mb-5 mt-5">Choose Your Program</h1>
        <div class="row">
            <div class="col-lg-4  col-sm-1">
                <div class="card">
                    <h4>Self Compass Plus program</h4>
                    <p>Take test & Know your potential</p>
                    <img src="{{asset('assets/imgs/section_1.jpg')}}" class="centered-image  mt-4 mb-5" alt="Furass Logo">
                    <button class="btn">Learn more</button>
                </div>
            </div>
            <div class="col-lg-4  col-sm-1 ">
                <div class="card">
                    <h4>Explore Your Career Destination program</h4>
                    <p>Go on trips & Discover the practical life on field</p>
                    <img src="{{asset('assets/imgs/section_2.webp')}}" class="centered-image  mt-4 mb-5" alt="Furass Logo">
                    <button class="btn">Learn more</button>
                </div>
            </div>
            <div class="col-lg-4  col-sm-1 ">
                <div class="card">
                    <h4>Ready For The Future program</h4>
                    <p>Workshop to learn more about Different careers</p>
                    <img src="{{asset('assets/imgs/section_3.webp')}}" class="centered-image mt-4 mb-5" alt="Furass Logo">
                    <button class="btn">Learn more</button>
                </div>
            </div>

        </div>
    </div>
    {{--footer--}}
    <div class="col-12 text-center mb-5">
        <p class="fw-semibold mb-0">Trusted by schools and districts to connect education to careers</p>
    </div>
@endsection
