@extends('admin.layouts.master')
@section('title', __('dashboard.title'))
@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                        <span class="text-gradient">
                            <span class="path1"></span><span class="path2"></span>{{ __('dashboard.multipurpose') }}
                        </span>
                    </h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                            <span class="text-muted">{{ __('dashboard.home') }}</span>
                        </li>
                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
            </div>
            <!--end::Toolbar container-->
        </div>
        <!--end::Toolbar-->
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-fluid h-100 p-0">
                <div class="d-flex flex-column flex-center flex-column-fluid h-100 p-0">
                    <!--begin::Content-->
                    <div class="d-flex flex-column flex-center text-center p-0 h-100 w-100">
                        <!--begin::Wrapper-->
                        <div class="card card-flush w-100 h-100 d-flex flex-column justify-content-center border-0 bg-transparent">
                            <div class="card-body p-10 position-relative">
                                <!-- Fixed Background Circles -->
                                <div class="position-fixed w-100 h-100 top-0 start-0 overflow-hidden opacity-15 z-0 fixed-background">
                                    <div class="position-absolute rounded-circle bg-primary w-300px h-300px top-50px start-10 animate-bounce" style="animation-delay: 0.5s;"></div>
                                    <div class="position-absolute rounded-circle bg-success w-150px h-150px top-100px end-10 animate-bounce" style="animation-delay: 1s;"></div>
                                    <div class="position-absolute rounded-circle bg-warning w-200px h-200px bottom-100px start-20 animate-bounce" style="animation-delay: 1.5s;"></div>
                                    <div class="position-absolute rounded-circle bg-info w-250px h-250px bottom-50px end-30 animate-bounce" style="animation-delay: 2s;"></div>
                                </div>
                                <!--begin::Logo-->
                                <div class="mb-10 animate__animated animate__fadeInDown">
                                    <img alt="Logo" src="{{asset('assets/media/logos/furass.png')}}" class="welcome-logo pulse" style="width: 270px; height: 190px;" />
                                </div>
                                <!--end::Logo-->

                                <!--begin::Title-->
                                <div class="mb-10 position-relative animate__animated animate__fadeIn" style="animation-delay: 0.3s;">
                                    <span class="text-gradient-primary fs-2x fw-bold tracking-wide">
                                        Welcome to Your Dashboard
                                    </span>
                                    <div class="mt-5">
                                        <span class="text-gradient-info fs-1 fw-bold d-inline-flex align-items-center">
                                            {{auth()->user()->name}}
                                            <i class="fas fa-hand-sparkles ms-3 fs-2x text-warning animate__animated animate__swing animate__infinite" style="animation-duration: 3s;"></i>
                                        </span>
                                    </div>
                                </div>
                                <!--end::Title-->

                                <!--begin::Text-->
                                <div class="fw-semibold fs-4 text-gray-600 mb-10 position-relative animate__animated animate__fadeIn" style="animation-delay: 0.6s;">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <span class="bullet bullet-dot bg-primary me-3 h-10px w-10px"></span>
                                        <span>This is your opportunity to get creative</span>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-center mt-3">
                                        <span class="bullet bullet-dot bg-success me-3 h-10px w-10px"></span>
                                        <span>Make a name that gives readers an idea</span>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-center mt-3">
                                        <span class="bullet bullet-dot bg-warning me-3 h-10px w-10px"></span>
                                        <span>Explore all the amazing features</span>
                                    </div>
                                </div>
                                <!--end::Text-->

                                <!--begin::Stats-->
                                <div class="row g-5 g-xl-10 mb-10 animate__animated animate__fadeIn" style="animation-delay: 0.9s;">
                                    <div class="col-md-4">
                                        <div class="card card-bordered bg-primary bg-opacity-10 border-primary border-opacity-20 h-100">
                                            <div class="card-body">
                                                <i class="fas fa-chart-line fs-2x text-primary mb-3"></i>
                                                <div class="fs-3 fw-bold text-dark">Analytics</div>
                                                <div class="text-gray-600">Track your performance</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card card-bordered bg-success bg-opacity-10 border-success border-opacity-20 h-100">
                                            <div class="card-body">
                                                <i class="fas fa-cog fs-2x text-success mb-3"></i>
                                                <div class="fs-3 fw-bold text-dark">Tools</div>
                                                <div class="text-gray-600">Powerful features</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card card-bordered bg-info bg-opacity-10 border-info border-opacity-20 h-100">
                                            <div class="card-body">
                                                <i class="fas fa-users fs-2x text-info mb-3"></i>
                                                <div class="fs-3 fw-bold text-dark">Community</div>
                                                <div class="text-gray-600">Connect with others</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Stats-->
                            </div>
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Content-->
                </div>
            </div>
            <!--end::Content container-->
        </div>
        <!--end::Content-->
    </div>

    @push('styles')
        <style>
            /* ========== Fixed Background Elements ========== */
            .fixed-background {
                position: fixed;
                width: 100%;
                height: 100%;
                top: 0;
                left:0;
                overflow: hidden;
                opacity: 0.15;
                z-index: 0;
                pointer-events: none;
            }

            /* ========== Main Content Styling ========== */
            .card-flush {
                position: relative;
                z-index: 1;
                background-color: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(3px);
                border: none;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
                transition: all 0.3s ease;
            }

            .theme-dark .card-flush {
                background-color: rgba(30, 30, 45, 0.95);
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            }

            /* ========== Text Gradients ========== */
            .text-gradient {
                background: linear-gradient(90deg, #6a11cb 0%, #2575fc 100%);
                -webkit-background-clip: text;
                background-clip: text;
                -webkit-text-fill-color: transparent;
                position: relative;
            }

            .text-gradient-primary {
                background: linear-gradient(90deg, #6a11cb 0%, #2575fc 100%);
                -webkit-background-clip: text;
                background-clip: text;
                -webkit-text-fill-color: transparent;
            }

            .text-gradient-info {
                background: linear-gradient(90deg, #17ead9 0%, #6078ea 100%);
                -webkit-background-clip: text;
                background-clip: text;
                -webkit-text-fill-color: transparent;
            }

            /* ========== Logo Styling ========== */
            /*.welcome-logo {*/
            /*    transition: all 0.3s ease;*/
            /*    filter: drop-shadow(0 10px 15px rgba(106, 17, 203, 0.2));*/
            /*    animation: pulse 4s infinite;*/
            /*}*/

            .welcome-logo:hover {
                /*transform: scale(1.05) rotate(-5deg);*/
                filter: drop-shadow(0 15px 20px rgba(106, 17, 203, 0.3));
            }

            /* ========== Animations ========== */
            /*@keyframes pulse {*/
            /*    0% { transform: scale(1); }*/
            /*    50% { transform: scale(1.03); }*/
            /*    100% { transform: scale(1); }*/
            /*}*/

            /*@keyframes floating {*/
            /*    0% { transform: translateY(0px); }*/
            /*    50% { transform: translateY(-15px); }*/
            /*    100% { transform: translateY(0px); }*/
            /*}*/

            /*@keyframes bounce {*/
            /*    0%, 100% { transform: translateY(0); }*/
            /*    50% { transform: translateY(-40px); }*/
            /*}*/

            /*.animate-bounce {*/
            /*    animation: bounce 8s infinite ease-in-out;*/
            /*}*/

            /*.floating {*/
            /*    animation: floating 6s ease-in-out infinite;*/
            /*}*/

            /* ========== Stats Cards ========== */
            .card-bordered {
                transition: all 0.3s ease;
                border-width: 1px;
                border-style: solid;
            }

            .card-bordered:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            }

            .theme-dark .card-bordered:hover {
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
            }


            /* ========== Responsive Adjustments ========== */
            @media (max-width: 768px) {
                .welcome-logo {
                    width: 200px !important;
                    height: 140px !important;
                }

                .fs-2x {
                    font-size: 1.5rem !important;
                }

                .fs-1 {
                    font-size: 2rem !important;
                }

                .fixed-background div {
                    width: 200px !important;
                    height: 200px !important;
                }
            }
        </style>
    @endpush
@endsection
