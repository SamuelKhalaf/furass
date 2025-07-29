<head><base href=""/>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <title>@yield('title' , 'Furass')</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{asset('assets/imgs/favicon.png')}}" />
    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Vendor Stylesheets(used for this page only)-->
    <link href="{{asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
    <!--end::Vendor Stylesheets-->
    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    @if($isRTL)
        <link href="{{ asset('assets/plugins/global/plugins.bundle.rtl.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/css/style.bundle.rtl.css') }}" rel="stylesheet" type="text/css"/>
    @else
        <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css"/>
    @endif
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

    @stack('styles')
    @if(auth()->user()->hasRole(\App\Enums\RoleEnum::STUDENT->value))
        <style>
            /* Student Dashboard Custom Styles */
            html[data-bs-theme="light"] .student-dashboard #kt_app_sidebar {
                background-color: #fff !important;
            }

            html[data-bs-theme="light"] .student-dashboard #kt_app_sidebar .app-sidebar-logo {
                background-color: #efefef !important;
                border-bottom: 1px solid #838ceb !important;
            }

            html[data-bs-theme="light"] .student-dashboard #kt_app_header {
                background-color: #efefef !important;
            }

            .student-dashboard #kt_app_sidebar .menu-item {
                margin-bottom: 5px !important;
            }

            .student-dashboard #kt_app_sidebar .menu-item .menu-link{
                padding: 4px 13px !important;
            }

            .student-dashboard #kt_app_sidebar .menu-item .menu-link{
                font-size: 17px ;
                color: #0a6aa1;
            }

            /* Menu Items - Hover State */
            .student-dashboard #kt_app_sidebar .menu-item .menu-link:hover {
                background-color: #a3abfa !important;
                color: #fff !important;
                box-shadow: 0 2px 12px #a3abfa;
            }

            /* Menu Items - Active State */
            .student-dashboard  #kt_app_sidebar .menu-item .menu-link.active {
                background-color: #a3abfa !important;
                color: #fff !important;
                font-weight: 600;
                border-radius: 8px;
            }

            .student-dashboard #kt_app_sidebar .menu-item .menu-link .menu-icon i {
                font-size: 20px;
            }
        </style>
    @endif

    {{-- notification styles--}}
    <style>
        /* Notification animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .notification-item {
            animation: fadeIn 0.3s ease-out;
            transition: all 0.3s ease;
            border-radius: 0.65rem;
            position: relative;
            /*background-color: #fff;*/
        }

        .notification-item:hover {
            /*background-color: #f8f9fc;*/
            box-shadow: 0 8px 24px rgba(80, 112, 243, 0.15); /* smooth shadow */
            transform: scale(1.02);
            border-left: 4px solid #3e97ff;
        }

        /* Custom scrollbar for notification container */
        .notification-container::-webkit-scrollbar {
            width: 6px;
        }

        .notification-container::-webkit-scrollbar-track {
            /*background: #f1f1f1;*/
            border-radius: 10px;
        }

        .notification-container::-webkit-scrollbar-thumb {
            /*background: #ccc;*/
            border-radius: 10px;
        }

        .notification-container::-webkit-scrollbar-thumb:hover {
            /*background: #aaa;*/
        }

        /* Unread notification highlight */
        .notification-unread {
            /*background-color: rgba(70, 128, 254, 0.06);*/
            border-left: 3px solid #4680fe;
        }
        .ck-editor__editable_inline {
            min-height: 300px;
        }
    </style>
</head>
