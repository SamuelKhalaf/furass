@extends('template/layout/master')
@section('body')
    <!-- program Section -->
    <div class="container mb-5 mt-2 program" >
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
    </div>



@endsection
