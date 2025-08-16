@extends('admin.layouts.master')
@section('title', __('users.title'))
@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">{{__('users.list')}}</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="{{route('admin.dashboard')}}" class="text-muted text-hover-primary">{{__('dashboard.home')}}</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">{{__('users.title')}}</li>
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
            <div id="kt_app_content_container" class="app-container container-xxl">
                <!--begin::Card-->
                <div class="card">
                    <!--begin::Card header-->
                    <div class="card-header border-0 pt-6">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <!--begin::Search-->
                            <div class="d-flex align-items-center position-relative my-1">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1"
                                              transform="rotate(45 17.0365 15.1223)" fill="currentColor"/>
                                        <path
                                            d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                            fill="currentColor"/>
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                                <input type="text" data-kt-user-table-filter="search"
                                       class="form-control form-control-solid w-250px ps-14" placeholder="{{ __('users.search') }}"/>
                            </div>
                            <!--end::Search-->
                        </div>
                        <!--begin::Card title-->
                        <!--begin::Card toolbar-->
                        <div class="card-toolbar">
                            <!--begin::Toolbar-->
                            <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                                <!--begin::Filter-->
                                <!--begin::DateRangePicker-->
                                <!-- <input class="form-control form-control-solid w-100 mw-200px"
                                       placeholder="Pick date range" id="kt_ecommerce_report_views_daterangepicker"/> -->
                                <!--end::DateRangePicker-->
                                <!--end::Filter-->
                                @if(auth()->user()->hasPermissionTo(\App\Enums\PermissionEnum::CREATE_USERS->value))
                                    <!--begin::Add user-->
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#kt_modal_add_user">
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                                        <span class="svg-icon svg-icon-2">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1"
                                                  transform="rotate(-90 11.364 20.364)" fill="currentColor"/>
                                            <rect x="4.36396" y="11.364" width="16" height="2" rx="1"
                                                  fill="currentColor"/>
                                        </svg>
                                    </span>
                                        <!--end::Svg Icon-->
                                        {{ __('users.create') }}
                                    </button>
                                    <!--end::Add user-->
                                @endif
                            </div>
                            <!--end::Toolbar-->
                        </div>
                        <!--end::Card toolbar-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body py-4">
                        <!--begin::Table-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_users">
                            <!--begin::Table head-->
                            <thead>
                            <!--begin::Table row-->
                            <tr class="text-gray-400 fw-bold fs-7 text-uppercase gs-0 text-center">
                                <th class="min-w-125px">{{ __('users.name') }}</th>
                                <th class="min-w-125px">{{ __('users.email') }}</th>
                                <th class="min-w-125px">{{ __('users.phone') }}</th>
                                <th class="min-w-125px">{{ __('users.role') }}</th>
                                <th class="min-w-125px">{{ __('users.created_at') }}</th>
                                <th class="text-end min-w-100px">{{ __('users.actions') }}</th>
                            </tr>
                            <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="text-gray-600 fw-semibold">
                            <!--begin::Table row-->
                            <!--end::Table row-->
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end::Table-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Content container-->
        </div>
        <!--end::Content-->
    </div>
    @if(auth()->user()->hasPermissionTo(\App\Enums\PermissionEnum::CREATE_USERS->value))
        <!--begin::Modal - Add Users-->
        @include('admin.users.modals.create')
        <!--end::Modal - Add Users-->
    @endif
    @if(auth()->user()->hasPermissionTo(\App\Enums\PermissionEnum::UPDATE_USERS->value))
        <!--begin::Modal - Update user-->
        @include('admin.users.modals.edit')
        <!--end::Modal - Update user-->
    @endif
@endsection
@section('scripts')

    @if(auth()->user()->hasPermissionTo(\App\Enums\PermissionEnum::LIST_USERS->value))
        <script>
            $('#kt_table_users').on('draw.dt', function () {
                KTMenu.createInstances();
            });
        </script>
        <script src="{{asset('assets/js/custom/apps/user-management/users/list/table.js')}}"></script>
        <script src="{{asset('assets/js/custom/apps/ecommerce/reports/views/views.js')}}"></script>
    @endif

    @if(auth()->user()->hasPermissionTo(\App\Enums\PermissionEnum::CREATE_USERS->value))
        <script src="{{asset('assets/js/custom/apps/user-management/users/list/add.js')}}"></script>
    @endif

    @if(auth()->user()->hasPermissionTo(\App\Enums\PermissionEnum::UPDATE_USERS->value))
        <script src="{{asset('assets/js/custom/apps/user-management/users/view/update-details.js')}}"></script>
    @endif

    @if(auth()->user()->hasPermissionTo(\App\Enums\PermissionEnum::DELETE_USERS->value))
        <script>
            // handle delete user
            $(document).on("click", '[data-kt-users-table-filter="delete_row"]', function (e) {
                e.preventDefault();

                var userId = $(this).data("user-id");

                Swal.fire({
                    text: "Are you sure you want to delete this user?",
                    icon: "warning",
                    showCancelButton: true,
                    buttonsStyling: false,
                    confirmButtonText: "Yes, delete!",
                    cancelButtonText: "No, cancel",
                    customClass: {
                        confirmButton: "btn fw-bold btn-danger",
                        cancelButton: "btn fw-bold btn-active-light-primary"
                    }
                }).then(function (result) {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('admin.users.destroy', ':id') }}".replace(':id', userId),
                            type: 'DELETE',
                            data: {_token: '{{ csrf_token() }}'},
                            success: function (response) {
                                if (response.success) {
                                    Swal.fire({
                                        text: response.message,
                                        icon: "success",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok",
                                        customClass: {
                                            confirmButton: "btn fw-bold btn-primary",
                                        }
                                    }).then(function () {
                                        $('#kt_table_users').DataTable().ajax.reload();
                                    });
                                } else {
                                    Swal.fire({
                                        text: response.message,
                                        icon: "error",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok",
                                        customClass: {
                                            confirmButton: "btn fw-bold btn-danger",
                                        }
                                    });
                                }
                            },
                            error: function () {
                                Swal.fire({
                                    text: "Failed to delete the user. Try again Later!",
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok",
                                    customClass: {
                                        confirmButton: "btn fw-bold btn-danger",
                                    }
                                });
                            }
                        });
                    }
                });
            });
        </script>
    @endif
@endsection
