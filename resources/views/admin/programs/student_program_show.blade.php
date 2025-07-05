@extends('admin.layouts.master')
@section('title', $program->{app()->getLocale() == 'ar' ? 'title_ar' : 'title_en'})
@section('content')
<!--begin::Content wrapper-->
<div class="d-flex flex-column flex-column-fluid">
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <!--begin::Toolbar container-->
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <!--begin::Title-->
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    {{ $program->{app()->getLocale() == 'ar' ? 'title_ar' : 'title_en'} }}
                </h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">{{ __('Dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('admin.programs.index') }}" class="text-muted text-hover-primary">{{ __('My Programs') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">{{ $program->{app()->getLocale() == 'ar' ? 'title_ar' : 'title_en'} }}</li>
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page title-->
            <!--begin::Actions-->
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <a href="{{ route('admin.programs.index') }}" class="btn btn-sm btn-secondary">
                    <i class="fa-solid fa-arrow-left me-1"></i>{{ __('Back to Programs') }}
                </a>
            </div>
            <!--end::Actions-->
        </div>
        <!--end::Toolbar container-->
    </div>
    <!--end::Toolbar-->
    
    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-fluid">
            <!--begin::Row-->
            <div class="row g-5 g-xl-8">
                <!--begin::Col-->
                <div class="col-xl-4">
                    <!--begin::Program Overview Card-->
                    <div class="card card-flush h-md-100">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <h3 class="fw-bold text-dark">{{ __('Program Overview') }}</h3>
                            </div>
                            <!--end::Card title-->
                        </div>
                        <!--end::Card header-->
                        
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <!--begin::Description-->
                            <div class="text-gray-800 fw-semibold fs-6 mb-8">
                                {{ $program->{app()->getLocale() == 'ar' ? 'description_ar' : 'description_en'} }}
                            </div>
                            <!--end::Description-->
                            
                            <!--begin::Status-->
                            <div class="d-flex flex-stack mb-5">
                                <span class="text-gray-700 fw-bold fs-6">{{ __('Status') }}</span>
                                <span class="badge badge-light-primary fs-7 fw-bold">{{ __(ucfirst($enrollment->status ?? '')) }}</span>
                            </div>
                            <!--end::Status-->
                            
                            @if(isset($enrollment->progress))
                                <!--begin::Progress-->
                                <div class="mb-8">
                                    <div class="d-flex align-items-center mb-2">
                                        <span class="text-gray-700 fw-bold fs-6 me-2">{{ __('Overall Progress') }}</span>
                                        <span class="badge badge-light fs-7">{{ $enrollment->progress }}%</span>
                                    </div>
                                    <div class="progress h-8px">
                                        <div class="progress-bar bg-primary" role="progressbar" 
                                             style="width: {{ $enrollment->progress }}%" 
                                             aria-valuenow="{{ $enrollment->progress }}" 
                                             aria-valuemin="0" 
                                             aria-valuemax="100">
                                        </div>
                                    </div>
                                </div>
                                <!--end::Progress-->
                            @endif
                            
                            <!--begin::Stats-->
                            <div class="d-flex flex-column">
                                <div class="d-flex flex-stack mb-4">
                                    <div class="d-flex align-items-center me-2">
                                        <div class="symbol symbol-30px me-3">
                                            <div class="symbol-label bg-light-success">
                                                <i class="fa-solid fa-list-check text-success fs-5"></i>
                                            </div>
                                        </div>
                                        <span class="text-gray-700 fw-bold fs-6">{{ __('Total Path Points') }}</span>
                                    </div>
                                    <span class="text-gray-800 fw-bolder fs-6">{{ $pathPoints->count() }}</span>
                                </div>
                                
                                <div class="d-flex flex-stack mb-4">
                                    <div class="d-flex align-items-center me-2">
                                        <div class="symbol symbol-30px me-3">
                                            <div class="symbol-label bg-light-primary">
                                                <i class="fa-solid fa-calendar-days text-primary fs-5"></i>
                                            </div>
                                        </div>
                                        <span class="text-gray-700 fw-bold fs-6">{{ __('Enrolled On') }}</span>
                                    </div>
                                    <span class="text-gray-800 fw-bolder fs-6">{{ $enrollment->created_at->format('M d, Y') }}</span>
                                </div>
                            </div>
                            <!--end::Stats-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Program Overview Card-->
                </div>
                <!--end::Col-->
                
                <!--begin::Col-->
                <div class="col-xl-8">
                    <!--begin::Program Path Card-->
                    <div class="card card-flush h-md-100">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <h3 class="fw-bold text-dark">
                                    <i class="fa-solid fa-route text-primary me-2"></i>{{ __('Program Path') }}
                                </h3>
                            </div>
                            <!--end::Card title-->
                        </div>
                        <!--end::Card header-->
                        
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            @if($pathPoints->count())
                                <!--begin::Timeline-->
                                <div class="timeline-label">
                                    @foreach($pathPoints as $i => $point)
                                        <!--begin::Timeline item-->
                                        <div class="timeline-item">
                                            <!--begin::Timeline line-->
                                            <div class="timeline-line w-40px"></div>
                                            <!--end::Timeline line-->
                                            
                                            <!--begin::Timeline icon-->
                                            <div class="timeline-icon symbol symbol-circle symbol-40px">
                                                <div class="symbol-label bg-primary">
                                                    <span class="text-white fw-bold fs-6">{{ $i+1 }}</span>
                                                </div>
                                            </div>
                                            <!--end::Timeline icon-->
                                            
                                            <!--begin::Timeline content-->
                                            <div class="timeline-content mb-10 mt-n1">
                                                <!--begin::Timeline heading-->
                                                <div class="pe-3 mb-5">
                                                    <!--begin::Title-->
                                                    <div class="fs-5 fw-bold text-gray-800">
                                                        {{ $point->{app()->getLocale() == 'ar' ? 'title_ar' : 'title_en'} }}
                                                    </div>
                                                    <!--end::Title-->
                                                    
                                                    <!--begin::Description-->
                                                    <div class="d-flex align-items-center mt-1 fs-6">
                                                        <div class="text-muted me-2 fs-7">{{ __('Type') }}:</div>
                                                        <span class="badge badge-light-info fs-7">{{ ucfirst(str_replace('_', ' ', $point->table_name)) }}</span>
                                                    </div>
                                                    <!--end::Description-->
                                                </div>
                                                <!--end::Timeline heading-->
                                                
                                                <!--begin::Timeline details-->
                                                <div class="overflow-auto pb-5">
                                                    <div class="d-flex align-items-center border border-dashed border-gray-300 rounded px-7 py-3 mb-5">
                                                        <div class="symbol symbol-35px me-5">
                                                            <div class="symbol-label bg-light-{{ $i % 2 == 0 ? 'primary' : 'success' }}">
                                                                <i class="fa-solid fa-{{ $i % 2 == 0 ? 'book' : 'play' }} text-{{ $i % 2 == 0 ? 'primary' : 'success' }} fs-5"></i>
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                                                                <div class="d-flex flex-column">
                                                                    <div class="d-flex align-items-center mb-1">
                                                                        <span class="text-gray-800 fw-bold fs-6 me-2">{{ $point->{app()->getLocale() == 'ar' ? 'title_ar' : 'title_en'} }}</span>
                                                                    </div>
                                                                    <span class="text-gray-400 fw-semibold fs-7">{{ __('Path Point') }} #{{ $i+1 }}</span>
                                                                </div>
                                                                <div class="d-flex align-items-center">
                                                                    <span class="badge badge-light-{{ $i % 2 == 0 ? 'primary' : 'success' }} fs-8">{{ __('Required') }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--end::Timeline details-->
                                            </div>
                                            <!--end::Timeline content-->
                                        </div>
                                        <!--end::Timeline item-->
                                    @endforeach
                                </div>
                                <!--end::Timeline-->
                            @else
                                <!--begin::Empty state-->
                                <div class="d-flex flex-column flex-center">
                                    <img src="{{ asset('assets/media/illustrations/sketchy-1/5.png') }}" class="mw-400px">
                                    <div class="fs-1 fw-bolder text-gray-400 mb-5">{{ __('No Path Points') }}</div>
                                    <div class="fs-6 text-gray-600 text-center mb-8">
                                        {{ __('No path points have been defined for this program yet.') }}
                                        <br>{{ __('Please contact your administrator for more information.') }}
                                    </div>
                                </div>
                                <!--end::Empty state-->
                            @endif
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Program Path Card-->
                </div>
                <!--end::Col-->
            </div>
            <!--end::Row-->
        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->
</div>
<!--end::Content wrapper-->
@endsection

@push('styles')
    <style>
        .timeline-label {
            position: relative;
        }

        .timeline-item {
            display: flex;
            position: relative;
            margin-bottom: 0;
        }

        .timeline-line {
            position: absolute;
            left: 19px;
            top: 40px;
            bottom: -30px;
            border-left: 1px dashed #E4E6EF;
        }

        .timeline-item:last-child .timeline-line {
            display: none;
        }

        .timeline-icon {
            position: relative;
            z-index: 1;
        }

        .timeline-content {
            flex: 1;
            margin-left: 20px;
        }

        .symbol-circle {
            border-radius: 50%;
        }

        .symbol-label {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
        }

        .border-dashed {
            border-style: dashed !important;
        }

        .overflow-auto {
            overflow-x: auto;
        }

        .card-flush .card-header {
            border-bottom: 1px solid #eff2f5;
        }

        .progress {
            background-color: #f1f3f6;
        }

        .progress-bar {
            transition: width 0.6s ease;
        }

        .badge {
            font-size: 0.75rem;
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .timeline-content {
                margin-left: 15px;
            }
            
            .timeline-line {
                left: 19px;
            }
        }

        @media (max-width: 768px) {
            .d-flex.flex-stack {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .d-flex.flex-stack > * {
                margin-bottom: 10px;
            }
            
            .timeline-item {
                flex-direction: column;
            }
            
            .timeline-content {
                margin-left: 0;
                margin-top: 15px;
            }
            
            .timeline-line {
                display: none;
            }
            
            /* Make timeline details responsive */
            .timeline-content .d-flex.justify-content-between {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .timeline-content .d-flex.align-items-center:last-child {
                margin-top: 10px;
            }
        }

        @media (max-width: 576px) {
            .timeline-content .border {
                padding: 1rem !important;
            }
            
            .symbol-35px {
                width: 30px !important;
                height: 30px !important;
            }
            
            .timeline-content .fs-6 {
                font-size: 0.875rem !important;
            }
            
            .timeline-content .fs-7 {
                font-size: 0.75rem !important;
            }
        }

        /* Hover effects */
        .card {
            transition: all 0.3s ease;
        }

        .timeline-item:hover .timeline-content {
            transform: translateX(5px);
            transition: transform 0.3s ease;
        }

        .timeline-item:hover .timeline-icon .symbol-label {
            transform: scale(1.1);
            transition: transform 0.3s ease;
        }

        /* Animation for progress bar */
        @keyframes progressAnimation {
            0% {
                width: 0%;
            }
            100% {
                width: var(--progress-width);
            }
        }

        .progress-bar {
            animation: progressAnimation 1.5s ease-in-out;
        }
    </style>
@endpush