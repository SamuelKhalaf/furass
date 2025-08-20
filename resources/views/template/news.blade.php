@extends('template/layout/master')
@section('body')

     <div class="news mt-3" style=" padding-top: 80px;">
         <div class="container">
             <div class="row">
                 {{-- Main News --}}
                 <div class="col-12 col-lg-6 mb-4">

                     @if($latestNews)
                         <div class="main-element">

                             <img src="{{ asset($latestNews->media ?? 'assets/imgs/template/news2.webp') }}"
                                  alt="Furass news"
                                  class="img-fluid mb-3 w-100"
                                  onerror="this.onerror=null;this.src='{{ asset('assets/imgs/template/news2.webp') }}';">

                             <h3 class="fw-bold">{{$latestNews->title ?? ""}}</h3>
                             <div class="byline">
                                 By <strong>{{$latestNews->user->name ?? ""}}</strong>
                                 <span class="byline-separator">|</span>
                                 {{ $latestNews->published_at
                                    ? Carbon\Carbon::parse($latestNews->published_at)->format('d M Y h:i A')
                                    : ''}}
                             </div>
                             <p>{{$latestNews->content ?? ""}}</p>
                         </div>
                     @endif
                 </div>

                 {{-- All News --}}
                 <div class="col-12 col-lg-6">
                    @isset($news)
                        @foreach($news as $iem)
                         <div class="all-element d-flex flex-column flex-sm-row mb-3 gap-3 align-items-start">
                             <img
                                 src="{{ asset($iem->media ?? 'assets/imgs/template/news2.webp') }}"
                                 alt="Furass news" class="img-fluid" style="width: 120px; height: auto;"
                                 onerror="this.onerror=null;this.src='{{ asset('assets/imgs/template/news2.webp') }}';">
                             <div class="details">
                                 <a href="{{route('template.news', $iem->id )}}" style="color: inherit; text-decoration: none;">
                                     <h5 class="fw-semibold">{{$iem->title ?? ""}}</h5>
                                 </a>
                                 <div class="byline">
                                     By <strong>{{$iem->user->name ?? ""}}</strong>
                                     <span class="byline-separator">|</span>
                                     {{ $iem->published_at
                                     ? Carbon\Carbon::parse($iem->published_at)->format('d M Y h:i A')
                                     : 'Not published'}}
                                 </div>
                             </div>
                         </div>
                         @endforeach
                     @endisset
                 </div>
             </div>
         </div>

     </div>
@endsection


