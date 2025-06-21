@extends('template/layout/master')
@section('body')
<div class="section-img">
    <img src="{{ asset('assets/imgs/template/about.jpg') }}" alt="About Image">
    <div class="container">
        <div class="overlay-text text-white">
            <h1 class="h3 fw-bold text-left">
                We bridge <br>
                education and <br>
                careers to guide <br>
                students toward <br>
                success in both <br>
                school and life
            </h1>
        </div>
    </div>
</div>

<div class="iframe mt-5 mb-5">
    <div class="container" >
        <div class="element">
            <iframe class="w-100 mb-5" height="500" src="https://www.youtube.com/{{--embed/--}}i0bbgA1bjnM?si=1wHtE2Un8oo38Tby" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            <p class="text-left">Education leaders nationwide use Furass® to help students uncover their natural aptitudes and connect their learning to
                future career and education goals.</p>

            <p class="text-left">
                Our award-winning solutions are trusted by over 7,000 schools across all KSA. We've empowered millions of students to
                discover clear, purpose-driven pathways—and we're committed to ensuring every student has access to these
                transformative tools.
            </p>
        </div>
    </div>
</div>

<div class="services mt-2 mb-5">
    <div class="container">
        <h1>We specialize in :</h1>
        <div class="row mt-5">
            <div class="col-lg-6 col-sm-1 mb-3">
                <div class="element d-flex">
                    <img src="{{ asset('assets/imgs/template/brain.png') }}" alt="About Image">
                    <p>
                    <span>
                        <b>Furass Aptitude and Career Discovery</b><br>
                        Enables students to uncover their natural aptitudes and align them with highly personalized, meaningful career and education pathways.
                    </span>
                    </p>
                </div>
            </div>
            <div class="col-lg-6 col-sm-1 mb-3">
                <div class="element d-flex">
                    <img src="{{ asset('assets/imgs/template/certificate.png') }}" alt="About Image">
                    <p>
                    <span>
                        <b>Furass Industry Certifications</b><br>
                        Verifies the effectiveness of Career
                        and Technical Education (CTE)
                        programs with industry-recognized
                        certifications that validate student
                        outcomes.
                    </span>
                    </p>
                </div>
            </div>
            <div class="col-lg-6 col-sm-1 mb-3">
                <div class="element d-flex">
                    <img src="{{ asset('assets/imgs/template/stats.png') }}" alt="About Image">
                    <p>
                    <span>
                        <b>Furass Insights and Analytics</b><br>
                        Leverages real-time data and analytics
                        to track student success, providing
                        actionable insights for classroom,
                        school, and district-level reporting to
                        support data-driven decisions.
                    </span>
                    </p>
                </div>
            </div>
            <div class="col-lg-6 col-sm-1 mb-3">
                <div class="element d-flex">
                    <img src="{{ asset('assets/imgs/template/check_box.png') }}" alt="About Image">
                    <p>
                    <span>
                        <b>Furass Education and Career Plan</b><br>
                       Empowers high school counselors and
                        students to collaboratively choose the
                        right courses for graduation and career
                        growth through a comprehensive, end-
                        to-end planning platform.
                    </span>
                    </p>
                </div>
            </div>
            <div class="col-lg-6 col-sm-1 mb-3">
                <div class="element d-flex">
                    <img src="{{ asset('assets/imgs/template/ask.png') }}" alt="About Image">
                    <p>
                    <span>
                        <b>Furass Work-Based Experiences</b><br>
                        Bridges real-world employers and
                        education to create impactful
                        experiences that give students direct
                        exposure to the workplace
                    </span>
                    </p>
                </div>
            </div>
            <div class="col-lg-6 col-sm-1 mb-3">
                <div class="element d-flex">
                    <img src="{{ asset('assets/imgs/template/certified_mark.png') }}" alt="About Image">
                    <p>
                    <span>
                        <b>Furass Education and Career Plan</b><br>
                        Provides students with opportunities
                        to engage with local or regional
                        employers aligned with their unique
                        talents and skills.
                    </span>
                    </p>
                </div>
            </div>
            <div class="col-lg-6 col-sm-1 mb-3">
                <div class="element d-flex">
                    <img src="{{ asset('assets/imgs/template/grad_cap.png') }}" alt="About Image">
                    <p>
                    <span>
                        <b>Furass Education Connections</b><br>
                        Matches students with educational
                        institutions that closely align with their
                        individual aptitudes and interests
                    </span>
                    </p>
                </div>
            </div>
            <div class="col-lg-6 col-sm-1 mb-3">
                <div class="element d-flex">
                    <img src="{{ asset('assets/imgs/template/file.png') }}" alt="About Image">
                    <p>
                    <span>
                        <b>Furass Professional Development</b><br>
                            Offers professional development and
                            consulting services to assess, design,
                            and implement career-connected
                            learning and CTE programs effectively
                    </span>
                    </p>
                </div>
            </div>

        </div>
    </div>
</div>
{{--
<section class="why-furass-section py-5">
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="section-title">Why Schools Partner with Furass</h2>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-10">
                <ul class="list-group list-group-flush fs-5">
                    <li class="list-group-item d-flex align-items-start">
                        <i class="bi bi-check-circle-fill text-success me-3 fs-4"></i>
                        Helps schools meet accreditation standards
                    </li>
                    <li class="list-group-item d-flex align-items-start">
                        <i class="bi bi-check-circle-fill text-success me-3 fs-4"></i>
                        Adds measurable career guidance services
                    </li>
                    <li class="list-group-item d-flex align-items-start">
                        <i class="bi bi-check-circle-fill text-success me-3 fs-4"></i>
                        Enhances student satisfaction and parent confidence
                    </li>
                    <li class="list-group-item d-flex align-items-start">
                        <i class="bi bi-check-circle-fill text-success me-3 fs-4"></i>
                        Provides ready-made programs with no extra admin burden
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>--}}

@endsection
