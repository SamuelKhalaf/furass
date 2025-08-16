@php use App\Enums\PermissionEnum; @endphp
@extends('admin.layouts.master')
@section('title', __('notifications.notifications'))
@push('styles')
@endpush
@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                        {{ __('notifications.notifications') }}</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="{{route('admin.dashboard')}}" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">{{ __('notifications.notifications') }}</li>
                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-end" data-kt-notification-table-toolbar="base">
                        <a href="{{ route('admin.notifications.all') }}" class="btn btn-primary">
                            {{ __('notifications.all_notifications') }}
                            <i class="fas fa-chevron-right ms-1"></i>
                        </a>
                    </div>
                    <!--end::Toolbar-->
                </div>
                <!--end::Card toolbar-->
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
                    <!--begin::Card body-->
                    <div class="card-body p-0">
                        <!--begin::Wrapper-->
                        <div class="card-px text-center py-20 my-10">
                            <!--begin::Title-->
                            <h2 class="fs-2x fw-bold mb-10">{{ __('notifications.welcome_center') }}</h2>
                            <!--end::Title-->
                            <!--begin::Description-->
                            <p class="text-gray-400 fs-4 fw-semibold mb-10">{{ __('notifications.center_description') }}</p>
                            <!--end::Description-->
                            <!--begin::Action-->
                            <a href="#" class="btn btn-primary" data-bs-toggle="modal"
                               data-bs-target="#kt_modal_add_notification">{{ __('notifications.send_notification_action') }}</a>
                            <!--end::Action-->
                        </div>
                        <!--end::Wrapper-->
                        <!--begin::Illustration-->
                        <div class="text-center px-4">
                            <img class="mw-100 mh-300px" alt="" src="{{asset('assets/media/illustrations/sketchy-1/1.png')}}"/>
                        </div>
                        <!--end::Illustration-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
                <!--begin::Modals-->
                @if(auth()->user()->hasPermissionTo(PermissionEnum::SEND_NOTIFICATIONS->value))
                    <!--begin::Modal - Notifications - Add-->
                    @include('admin.notifications.modals.create')
                    <!--end::Modal - Notifications - Add-->
                @endif
                <!--end::Modals-->
            </div>
            <!--end::Content container-->
        </div>
        <!--end::Content-->
    </div>

@endsection
@section('scripts')
    <script>
        "use strict";

        // Class definition
        var KTModalNotificationsAdd = function () {
            var submitButton;
            var cancelButton;
            var closeButton;
            var validator;
            var form;
            var modal;

            // Load users for select2
            var loadUsers = function () {
                $('#users_select').select2({
                    ajax: {
                        url: '{{ route("admin.users.search") }}',
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            return {
                                q: params.term,
                                page: params.page
                            };
                        },
                        processResults: function (data, params) {
                            params.page = params.page || 1;
                            return {
                                results: data.items,
                                pagination: {
                                    more: (params.page * 30) < data.total_count
                                }
                            };
                        },
                        cache: true
                    },
                    placeholder: 'Search and select users...',
                    minimumInputLength: 2,
                    templateResult: function (user) {
                        if (user.loading) {
                            return user.text;
                        }
                        return $('<span>' + user.name + ' (' + user.email + ')</span>');
                    },
                    templateSelection: function (user) {
                        return user.name || user.text;
                    }
                });
            };

            // Init form inputs
            var handleForm = function () {
                // Init form validation rules
                validator = FormValidation.formValidation(
                    form,
                    {
                        fields: {
                            'title': {
                                validators: {
                                    notEmpty: {
                                        message: 'Notification title is required'
                                    },
                                    stringLength: {
                                        max: 50,
                                        message: 'Title must be less than 50 characters'
                                    }
                                }
                            },
                            'body': {
                                validators: {
                                    notEmpty: {
                                        message: 'Message body is required'
                                    }
                                }
                            },
                            'link': {
                                validators: {
                                    uri: {
                                        message: 'Please enter a valid URL'
                                    }
                                }
                            }
                        },
                        plugins: {
                            trigger: new FormValidation.plugins.Trigger(),
                            bootstrap: new FormValidation.plugins.Bootstrap5({
                                rowSelector: '.fv-row',
                                eleInvalidClass: '',
                                eleValidClass: ''
                            })
                        }
                    }
                );

                // Action buttons
                submitButton.addEventListener('click', function (e) {
                    e.preventDefault();

                    // Validate form before submit
                    if (validator) {
                        validator.validate().then(function (status) {

                            if (status == 'Valid') {
                                // Check if at least one recipient is selected
                                var recipientGroups = $('input[name="recipient_groups[]"]:checked').length;
                                var specificUsers = $('#users_select').val();

                                if (recipientGroups === 0 && (!specificUsers || specificUsers.length === 0)) {
                                    Swal.fire({
                                        text: "Please select at least one recipient group or specific user.",
                                        icon: "warning",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok, got it!",
                                        customClass: {
                                            confirmButton: "btn btn-primary"
                                        }
                                    });
                                    return;
                                }

                                submitButton.setAttribute('data-kt-indicator', 'on');
                                submitButton.disabled = true;

                                // Prepare form data
                                var formData = new FormData(form);

                                // Send AJAX request
                                $.ajax({
                                    url: '{{ route("admin.notifications.store") }}',
                                    type: 'POST',
                                    data: formData,
                                    processData: false,
                                    contentType: false,
                                    success: function (response) {
                                        submitButton.removeAttribute('data-kt-indicator');
                                        submitButton.disabled = false;

                                        Swal.fire({
                                            text: "Notification has been sent successfully!",
                                            icon: "success",
                                            buttonsStyling: false,
                                            confirmButtonText: "Ok, got it!",
                                            customClass: {
                                                confirmButton: "btn btn-primary"
                                            }
                                        }).then(function (result) {
                                            if (result.isConfirmed) {
                                                modal.hide();
                                                form.reset();
                                                $('#users_select').val(null).trigger('change');
                                                // Optionally reload the page or update the UI
                                                location.reload();
                                            }
                                        });
                                    },
                                    error: function (xhr) {
                                        submitButton.removeAttribute('data-kt-indicator');
                                        submitButton.disabled = false;

                                        var errorMessage = "Sorry, looks like there are some errors detected, please try again.";
                                        if (xhr.responseJSON && xhr.responseJSON.message) {
                                            errorMessage = xhr.responseJSON.message;
                                        }

                                        Swal.fire({
                                            text: errorMessage,
                                            icon: "error",
                                            buttonsStyling: false,
                                            confirmButtonText: "Ok, got it!",
                                            customClass: {
                                                confirmButton: "btn btn-primary"
                                            }
                                        });
                                    }
                                });
                            } else {
                                Swal.fire({
                                    text: "Sorry, looks like there are some errors detected, please try again.",
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn btn-primary"
                                    }
                                });
                            }
                        });
                    }
                });

                cancelButton.addEventListener('click', function (e) {
                    e.preventDefault();

                    Swal.fire({
                        text: "Are you sure you would like to cancel?",
                        icon: "warning",
                        showCancelButton: true,
                        buttonsStyling: false,
                        confirmButtonText: "Yes, cancel it!",
                        cancelButtonText: "No, return",
                        customClass: {
                            confirmButton: "btn btn-primary",
                            cancelButton: "btn btn-active-light"
                        }
                    }).then(function (result) {
                        if (result.value) {
                            form.reset();
                            $('#users_select').val(null).trigger('change');
                            modal.hide();
                        } else if (result.dismiss === 'cancel') {
                            Swal.fire({
                                text: "Your form has not been cancelled!",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-primary",
                                }
                            });
                        }
                    });
                });

                closeButton.addEventListener('click', function (e) {
                    e.preventDefault();

                    Swal.fire({
                        text: "Are you sure you would like to cancel?",
                        icon: "warning",
                        showCancelButton: true,
                        buttonsStyling: false,
                        confirmButtonText: "Yes, cancel it!",
                        cancelButtonText: "No, return",
                        customClass: {
                            confirmButton: "btn btn-primary",
                            cancelButton: "btn btn-active-light"
                        }
                    }).then(function (result) {
                        if (result.value) {
                            form.reset();
                            $('#users_select').val(null).trigger('change');
                            modal.hide();
                        } else if (result.dismiss === 'cancel') {
                            Swal.fire({
                                text: "Your form has not been cancelled!",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-primary",
                                }
                            });
                        }
                    });
                })
            }

            return {
                // Public functions
                init: function () {
                    // Elements
                    modal = new bootstrap.Modal(document.querySelector('#kt_modal_add_notification'));

                    form = document.querySelector('#kt_modal_add_notification_form');
                    submitButton = form.querySelector('#kt_modal_add_notification_submit');
                    cancelButton = form.querySelector('#kt_modal_add_notification_cancel');
                    closeButton = form.querySelector('#kt_modal_add_notification_close');

                    handleForm();
                    loadUsers();
                }
            };
        }();

        // On document ready
        KTUtil.onDOMContentLoaded(function () {
            KTModalNotificationsAdd.init();
        });
    </script>
@endsection
