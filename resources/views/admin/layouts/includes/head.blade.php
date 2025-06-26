<head><base href=""/>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <title>@yield('title')</title>

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
    @stack('styles')
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
    </style>
</head>
