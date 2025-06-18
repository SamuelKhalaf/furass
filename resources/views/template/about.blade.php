@extends('template/layout/master')
@section('body')
<div class="section-img">
    <img src="{{ asset('assets/imgs/template/about.png') }}" alt="About Image">
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

<div class="iframe mt-5 mb-5">
    <div class="container" style="text-align: -webkit-center">
        <div class="element">
            <iframe class="w-100" height="500" src="https://www.youtube.com/embed/W-0re-BGhH4?si=hzWq2UKW9RD8aChY" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
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
<div class="services mt-5">
    <div class="container">
        <h1>We specialize in :</h1>
    </div>
</div>

@endsection
