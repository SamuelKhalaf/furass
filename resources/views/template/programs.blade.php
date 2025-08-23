@extends('template/layout/master')
@section('body')

    <div class="program position-relative">
        <div class="img-section position-relative" style="
        background-image: url('{{ asset('assets/imgs/template/DeWatermark.ai_1750680735408.jpeg') }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        height: 100vh;">

            <!-- Black Overlay -->
            <div class="overlay position-absolute top-0 start-0 w-100 h-100" style="background-color: rgba(0, 0, 0, 0.7); z-index: 1;"></div>

            <!-- Centered Text -->
            <div class="position-absolute top-50 start-50 translate-middle text-center text-white z-2 px-3">
                <h1 class="title position-relative display-4 display-md-3 display-lg-1">
                    {{ __('template.programs_section.title') }}
                </h1>
            </div>
        </div>

        <div class="box position-absolute">
            <div class="container">
                @php
                    $bg = ['#1bbeb9', '#f94d85', '#ffbf29'];
                @endphp
                <div class="row justify-content-center g-4" >
                    @foreach(__('template.programs_section.programs') as $index => $program)
                        <div class="col-lg-4 col-md-6 text-light" >
                            <div class="element text-center" style="background-color: {{ $bg[$index] }}">
                                <img src="{{ asset('assets/imgs/' . ['program1.jpg', 'program2.jpg', 'program3.jpg'][$index]) }}" alt="Icon"
                                     class="img-fluid mb-3" style="width: 180px;">
                                <h4>{{ $program['title'] }}</h4>
                                <p>{{ $program['desc'] }}</p>
                                <a href="{{ route('template.programs') }}#{{ ['self-compass', 'explore-career', 'ready-future'][$index] }}"
                                   class="btn fw-bold px-4 py-2"
                                   style="background:#543786; color:#fff; border-radius:24px; border: none;">
                                    {{ $program['btn'] }}
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="program-space" style="height: 300px"></div>

    <div class="prog-details mb-5">
        <div class="container">

            @php
                $programs = ['self_compass', 'explore_career', 'ready_future'];
                $images = ['program1.jpg', 'program2.jpg', 'program3.jpg'];
                $anchors = ['self-compass', 'explore-career', 'ready-future'];
                $bg = ['#1bbeb9', '#f94d85', '#ffbf29'];
            @endphp

            @foreach ($programs as $index => $key)
                <div class="row text-light mt-3 p-4 rounded-5" id="{{ $anchors[$index] }}" style="background-color: {{ $bg[$index] }}">
                    <div class="col-lg-4 col-md-12" style="padding-top: 100px">
                        <img src="{{ asset('assets/imgs/' . $images[$index]) }}" alt="Icon"
                             class="img-fluid mb-3"
                             style="width: 100%; border-top-left-radius: 100px;">
                    </div>
                    <div class="col-lg-8 col-md-12">
                        <div class="element" >
                            <h1 class="feature position-relative mb-3">
                                {{ __('template.programs_section.' . $key . '.title') }}
                                <hr style="height: 3px;border: none; background-color: #FFFFFF !important;opacity: 0.8 !important;">
                            </h1>
                            <p class="mb-5 fs-5">
                                {{ __('template.programs_section.' . $key . '.desc') }}
                            </p>

                            <h5 class="fw-bold mb-3">
                                {{ __('template.programs_section.' . $key . '.features_title') }}
                            </h5>

                            @foreach (__('template.programs_section.' . $key . '.features') as $feature)
                                <p class="fw-bold">✅ {{ $feature }}</p>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection
