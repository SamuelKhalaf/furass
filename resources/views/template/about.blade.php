@extends('template/layout/master')
@section('body')
    <div style="padding-top: 65px;">
        <div class="section-img" >
            <img src="{{ asset('assets/imgs/template/about.jpg') }}"  alt="About Image">
            <div class="overlay-wrapper">
                <div class="container">
                    <div class="overlay-text text-white">
                        <h1 class="h3 fw-bold " style="text-align: justify">
                            {!! __('template.about.title') !!}
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="iframe mt-5 mb-5" >
    <div class="container" >
        <div class="element">
            <iframe class="w-100 mb-5" height="500" src="https://www.youtube.com/{{--embed/--}}i0bbgA1bjnM?si=1wHtE2Un8oo38Tby" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            {!! __('template.about.description') !!}
        </div>
    </div>
</div>

    <div class="services mt-2 mb-5">
        <div class="container">
            <h1>{{ __('template.services.title') }}</h1>
            <div class="row mt-5">

                {{-- Service 1 --}}
                <div class="col-lg-6 col-sm-1 mb-3">
                    <div class="element d-flex">
                        <img src="{{ asset('assets/imgs/template/brain.png') }}" alt="About Image">
                        <p><span>
                        <b>{{ __('template.services.aptitude.title') }}</b><br>
                        {{ __('template.services.aptitude.desc') }}
                    </span></p>
                    </div>
                </div>

                {{-- Service 2 --}}
                <div class="col-lg-6 col-sm-1 mb-3">
                    <div class="element d-flex">
                        <img src="{{ asset('assets/imgs/template/certificate.png') }}" alt="About Image">
                        <p><span>
                        <b>{{ __('template.services.certification.title') }}</b><br>
                        {{ __('template.services.certification.desc') }}
                    </span></p>
                    </div>
                </div>

                {{-- Service 3 --}}
                <div class="col-lg-6 col-sm-1 mb-3">
                    <div class="element d-flex">
                        <img src="{{ asset('assets/imgs/template/stats.png') }}" alt="About Image">
                        <p><span>
                        <b>{{ __('template.services.analytics.title') }}</b><br>
                        {{ __('template.services.analytics.desc') }}
                    </span></p>
                    </div>
                </div>

                {{-- Service 4 --}}
                <div class="col-lg-6 col-sm-1 mb-3">
                    <div class="element d-flex">
                        <img src="{{ asset('assets/imgs/template/check_box.png') }}" alt="About Image">
                        <p><span>
                        <b>{{ __('template.services.plan.title') }}</b><br>
                        {{ __('template.services.plan.desc') }}
                    </span></p>
                    </div>
                </div>

                {{-- Service 5 --}}
                <div class="col-lg-6 col-sm-1 mb-3">
                    <div class="element d-flex">
                        <img src="{{ asset('assets/imgs/template/ask.png') }}" alt="About Image">
                        <p><span>
                        <b>{{ __('template.services.experience.title') }}</b><br>
                        {{ __('template.services.experience.desc') }}
                    </span></p>
                    </div>
                </div>

                {{-- Service 6 --}}
                <div class="col-lg-6 col-sm-1 mb-3">
                    <div class="element d-flex">
                        <img src="{{ asset('assets/imgs/template/certified_mark.png') }}" alt="About Image">
                        <p><span>
                        <b>{{ __('template.services.employers.title') }}</b><br>
                        {{ __('template.services.employers.desc') }}
                    </span></p>
                    </div>
                </div>

                {{-- Service 7 --}}
                <div class="col-lg-6 col-sm-1 mb-3">
                    <div class="element d-flex">
                        <img src="{{ asset('assets/imgs/template/grad_cap.png') }}" alt="About Image">
                        <p><span>
                        <b>{{ __('template.services.connections.title') }}</b><br>
                        {{ __('template.services.connections.desc') }}
                    </span></p>
                    </div>
                </div>

                {{-- Service 8 --}}
                <div class="col-lg-6 col-sm-1 mb-3">
                    <div class="element d-flex">
                        <img src="{{ asset('assets/imgs/template/file.png') }}" alt="About Image">
                        <p><span>
                        <b>{{ __('template.services.development.title') }}</b><br>
                        {{ __('template.services.development.desc') }}
                    </span></p>
                    </div>
                </div>

            </div>
        </div>
    </div>


@endsection
