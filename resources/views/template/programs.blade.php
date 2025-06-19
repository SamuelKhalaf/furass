@extends('template/layout/master')
@section('body')
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
    {{--footer--}}
   {{-- <div class="text-center mt-auto">
        <h1 style="background-color: white" class="p-3">How Furass can Help You</h1>
    </div>--}}
@endsection
