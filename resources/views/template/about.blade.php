@extends('template/layout/master')
@section('body')

    @php
    $page = \App\Models\Ckeditor::where('page' , 'about')->first();
    @endphp
    <div style="padding-top: 65px;">
        <div class="section-img">
            @php
                $img = '';
                if (app()->getLocale() == 'ar'){
                    $img = $page->variables_ar['section1_img'];
                }else{
                    $img = $page->variables_en['section1_img'];
                }
            @endphp
            {!! $img !!}
            <div class="overlay-wrapper">
                <div class="container">
                    <div class="overlay-text text-white">
                        <h1 class="h3 fw-bold " style="text-align: justify">
                            @php
                            $title = '';
                            if (app()->getLocale() == 'ar'){
                                $title = $page->variables_ar['section1_title'];
                            }else{
                                $title = $page->variables_en['section1_title'];
                            }
                            @endphp
                            {!! $title !!}
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="iframe mt-5 mb-5" >
        <div class="container" >
            <div class="element">
                <iframe class="w-100 mb-5" height="500" src="https://www.youtube.com{{--/embed/--}}i0bbgA1bjnM?si=1wHtE2Un8oo38Tby" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                {!! __('template.about.description') !!}
            </div>
        </div>
    </div>

    <div class="services mt-2 mb-5">
        <div class="container">
            <h1>{{ __('template.services.title') }}</h1>
            <div class="row mt-5">

                {{-- Service 1 --}}
                <div class="col-12 col-md-6 mb-4">
                    <div class="element d-flex align-items-start gap-3">
                        <img src="{{ asset('assets/imgs/template/brain.png') }}" alt="Aptitude Icon" {{--style="width: 60px;"--}}>
                        <p class="mb-0">
                            <b>{{ __('template.services.aptitude.title') }}</b><br>
                            {{ __('template.services.aptitude.desc') }}
                        </p>
                    </div>
                </div>

                {{-- Service 2 --}}
                <div class="col-12 col-md-6 mb-4">
                    <div class="element d-flex align-items-start gap-3">
                        <img src="{{ asset('assets/imgs/template/certificate.png') }}" alt="Certification Icon" >
                        <p class="mb-0">
                            <b>{{ __('template.services.certification.title') }}</b><br>
                            {{ __('template.services.certification.desc') }}
                        </p>
                    </div>
                </div>

                {{-- Service 3 --}}
                <div class="col-12 col-md-6 mb-4">
                    <div class="element d-flex align-items-start gap-3">
                        <img src="{{ asset('assets/imgs/template/stats.png') }}" alt="Analytics Icon" >
                        <p class="mb-0">
                            <b>{{ __('template.services.analytics.title') }}</b><br>
                            {{ __('template.services.analytics.desc') }}
                        </p>
                    </div>
                </div>

                {{-- Service 4 --}}
                <div class="col-12 col-md-6 mb-4">
                    <div class="element d-flex align-items-start gap-3">
                        <img src="{{ asset('assets/imgs/template/check_box.png') }}" alt="Plan Icon" >
                        <p class="mb-0">
                            <b>{{ __('template.services.plan.title') }}</b><br>
                            {{ __('template.services.plan.desc') }}
                        </p>
                    </div>
                </div>

                {{-- Service 5 --}}
                <div class="col-12 col-md-6 mb-4">
                    <div class="element d-flex align-items-start gap-3">
                        <img src="{{ asset('assets/imgs/template/ask.png') }}" alt="Experience Icon" >
                        <p class="mb-0">
                            <b>{{ __('template.services.experience.title') }}</b><br>
                            {{ __('template.services.experience.desc') }}
                        </p>
                    </div>
                </div>

                {{-- Service 6 --}}
                <div class="col-12 col-md-6 mb-4">
                    <div class="element d-flex align-items-start gap-3">
                        <img src="{{ asset('assets/imgs/template/certified_mark.png') }}" alt="Employers Icon" >
                        <p class="mb-0">
                            <b>{{ __('template.services.employers.title') }}</b><br>
                            {{ __('template.services.employers.desc') }}
                        </p>
                    </div>
                </div>

                {{-- Service 7 --}}
                <div class="col-12 col-md-6 mb-4">
                    <div class="element d-flex align-items-start gap-3">
                        <img src="{{ asset('assets/imgs/template/grad_cap.png') }}" alt="Connections Icon" >
                        <p class="mb-0">
                            <b>{{ __('template.services.connections.title') }}</b><br>
                            {{ __('template.services.connections.desc') }}
                        </p>
                    </div>
                </div>

                {{-- Service 8 --}}
                <div class="col-12 col-md-6 mb-4">
                    <div class="element d-flex align-items-start gap-3">
                        <img src="{{ asset('assets/imgs/template/file.png') }}" alt="Development Icon" >
                        <p class="mb-0">
                            <b>{{ __('template.services.development.title') }}</b><br>
                            {{ __('template.services.development.desc') }}
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>



@endsection
