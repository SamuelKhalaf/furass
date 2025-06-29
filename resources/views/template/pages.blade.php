@extends('template/layout/master')
@section('body')

     <div class="news mt-3" style=" padding-top: 80px;">
         <div class="container">
            @isset($page)
                <div class="content-page">
                    @if(app()->getLocale() == 'ar' )
                        <div>
                            {!! $page->content_ar !!}
                        </div>
                    @endif

                    @if(app()->getLocale() == 'en' )
                        <div>
                            {!! $page->content_en !!}
                        </div>
                    @endif
                </div>
             @endisset
         </div>
     </div>
@endsection


