@extends('template/layout/master')
@section('body')

<div class="program position-relative">
    <div class="img-section position-relative" style="
    background-image: url('{{ asset('assets/imgs/template/DeWatermark.ai_1750680735408.jpeg') }}');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    height: 100vh;
    ">
        <!-- Black Overlay -->
        <div class="overlay position-absolute top-0 start-0 w-100 h-100" style="
        background-color: rgba(0, 0, 0, 0.7);
        z-index: 1;">
        </div>

        <!-- Centered Text -->
        <div class="position-absolute top-50 start-50 translate-middle text-center text-white z-2 px-3">
{{--            <p class="mb-3 fs-5">Our Programs</p>--}}
            <h1 class="title position-relative  display-4 display-md-3 display-lg-1">
                Our Programs
            </h1>
        </div>
    </div>

    <div class="box position-absolute">
        <div class="container">
            <div class="row justify-content-center g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="element text-center">
                        <img src="{{ asset('assets/imgs/template/self_compass.png') }}" alt="Icon" class="img-fluid mb-3" style="max-width: 100px; height: 100px">
                        <h4>Self Compass Plus program</h4>
                        <p>Take test & Know your potential</p>
                        <a href="{{ route('template.programs') }}#self-compass" class="btn fw-bold px-4 py-2" style="background:#543786; color:#fff; border-radius:24px; border: none;">
                            Learn more
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="element text-center">
                        <img src="{{ asset('assets/imgs/template/ready_for_the_future.png') }}" alt="Icon" class="img-fluid mb-3" style="max-width: 100px; height: 100px">
                        <h4>Explore Your Career Destination program</h4>
                        <p>Go on trips & Discover the practical life on field</p>
                        <a href="{{ route('template.programs') }}#explore-career" class="btn fw-bold px-4 py-2" style="background:#543786; color:#fff; border-radius:24px; border: none;">
                            Learn more
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="element text-center">
                        <img src="{{ asset('assets/imgs/template/explore_your_career.png') }}" alt="Icon" class="img-fluid mb-3" style="max-width: 100px; height: 100px">
                        <h4>Ready For The Future program</h4>
                        <p>Workshop to learn more about Different careers</p>
                        <a href="{{ route('template.programs') }}#ready-future" class="btn fw-bold px-4 py-2" style="background:#543786; color:#fff; border-radius:24px; border: none;">
                            Learn more
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="program-space" style="height: 300px"></div>

<div class="prog-details mb-5">
    <div class="container">

        <div class="row mt-5" id="self-compass">
            <div class="col-lg-4 col-md-12" >
                <img src="{{ asset('assets/imgs/template/program1.jpg') }}" alt="Icon" class="img-fluid mb-3" style="width: 100%; height: 100%; border-top-left-radius: 100px; ">
            </div>
            <div class="col-lg-8 col-md-12">
                <div class="element">
                    <h1 class="feature position-relative mb-5">Self Compass Program</h1>
                    <p class="mb-5">Every student has an inner compass—and we help them read it with confidence.
                        This program accompanies students throughout their high school years,
                        tracking their development and aligning it with their evolving goals and interests.
                        With expert consultations delivered via our platform and structured assessments, students
                        receive continuous support to make informed academic and career choices. Parents are actively
                        involved during key decision-making moments, ensuring a holistic and high-quality experience.</p>

                    <h5 class="fw-bold mb-3">💡 Key Features:</h5>
                    <p class="fw-bold">✅ Long-term program from Grades 10 to 12</p>
                    <p class="fw-bold">✅ Career consultations through the platform</p>
                    <p class="fw-bold">✅ Personalized reports using validated tools</p>
                    <p class="fw-bold">✅ Tracking student progress in line with goals</p>
                    <p class="fw-bold">✅ Parental involvement in decision milestones</p>
                </div>
            </div>
        </div>

        <div class="row mt-5" id="explore-career">
            <div class="col-lg-4 col-md-12" >
                <img src="{{ asset('assets/imgs/template/program2.jpg') }}" alt="Icon" class="img-fluid mb-3" style="width: 100%; height: 100%; border-top-left-radius: 100px; ">
            </div>
            <div class="col-lg-8 col-md-12">
                <div class="element">
                    <h1 class="feature position-relative mb-5">Explore Your Career Program</h1>
                    <p class="mb-5">We believe real-world exposure changes everything.
                        Throughout high school, students engage in structured visits to various industries, followed by personalized guidance and reflection. Each experience is linked to the student’s future goals, with advisors helping them process what they’ve seen. Parents are engaged along the way, offering support as their children explore and refine their direction.</p>

                    <h5 class="fw-bold mb-3">💡 Key Features:</h5>
                    <p class="fw-bold">✅ Industry field trips across three academic years</p>
                    <p class="fw-bold">✅ Guided consultations tied to each experience</p>
                    <p class="fw-bold">✅ Real-world connection to academic paths</p>
                    <p class="fw-bold">✅ Family involvement in reflecting and redirecting</p>
                </div>
            </div>
        </div>

        <div class="row mt-5" id="ready-future">
            <div class="col-lg-4 col-md-12" >
                <img src="{{ asset('assets/imgs/template/program3.jpg') }}" alt="Icon" class="img-fluid mb-3" style="width: 100%; height: 100%; border-top-left-radius: 100px; ">
            </div>
            <div class="col-lg-8 col-md-12">
                <div class="element">
                    <h1 class="feature position-relative mb-5">Ready for the Future Program</h1>
                    <p class="mb-5">We don’t just build knowledge—we build readiness.
                        Spanning the student’s entire high school journey, this program focuses on developing the personal and professional skills that grow with them. Through hands-on workshops and guided activities, we track their evolving strengths and help them align with their future goals. Parents remain active partners throughout, sharing in the student’s growth and helping shape their direction.</p>

                    <h5 class="fw-bold mb-3">💡 Key Features:</h5>
                    <p class="fw-bold">✅ Structured workshops from Grades 10 to 12</p>
                    <p class="fw-bold">✅ Growth in behavior, mindset, and workplace values</p>
                    <p class="fw-bold">✅ Support for personal and career decision-making</p>
                    <p class="fw-bold">✅ Ongoing development aligned with student maturity</p>
                    <p class="fw-bold">✅ Family engagement in feedback and direction</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
