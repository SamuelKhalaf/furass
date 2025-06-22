@php use App\Enums\PermissionEnum; @endphp
@extends('admin.layouts.master')
@section('title', __('trips.title'))
@push('styles')
    <style>
        /* Calendar container styling */
        .flatpickr-calendar {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        /* Align inner content (calendar + time) */
        .flatpickr-innerContainer {
            display: flex;
            /*align-items: stretch;*/
        }

        /* Calendar days container */
        .flatpickr-days {
            padding: 10px;
        }

        /* Styling for selected day */
        .flatpickr-day.selected {
            background-color: #10b981;
            color: white;
            font-weight: bold;
        }

        /* Styling for today */
        .flatpickr-day.today {
            background-color: #3b82f6;
            color: white;
        }

         Time container
        .flatpickr-time {
            /*width: 100px;*/
            background: #fafafa;
            padding: 16px 12px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border-left: 1px solid #ddd;
            box-sizing: border-box;
        }

        /* Time input styling */
        .flatpickr-time input {
            width: 45px;
            font-size: 16px;
            padding: 4px 6px;
            text-align: center;
            border: 1px solid #ccc;
            border-radius: 6px;
            background: #fff;
            margin: 2px 0;
        }

        /* Separator styling */
        .flatpickr-time-separator {
            font-size: 18px;
            margin: 0 4px;
        }
        .flatpickr-time .numInputWrapper
        {
            height: 35px;
        }
    </style>
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
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">{{ __('trips.list') }}</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="{{route('admin.dashboard')}}"
                               class="text-muted text-hover-primary">{{ __('dashboard.home') }}</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">{{ __('trips.title') }}</li>
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
                                <span class="svg-icon svg-icon-1 position-absolute ms-6"><i
                                        class="fa-solid fa-magnifying-glass"></i></span>
                                <input type="text" data-kt-user-table-filter="search"
                                       class="form-control form-control-solid w-250px ps-14"
                                       placeholder="{{ __('trips.search') }}"/>
                            </div>
                            <!--end::Search-->
                        </div>
                        <!--begin::Card title-->
                        <!--begin::Card toolbar-->
                        <div class="card-toolbar">
                            <!--begin::Toolbar-->
                            <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                                @if(auth()->user()->hasPermissionTo(PermissionEnum::CREATE_TRIPS->value))
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#kt_modal_add_trip">
                                        <span class="svg-icon svg-icon-2"><i class="fa-solid fa-plus"></i></span>
                                        {{ __('trips.create') }}
                                    </button>
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
                                <th class="min-w-125px">{{ __('trips.name') }}</th>
                                <th class="min-w-125px">{{ __('trips.company_name') }}</th>
                                <th class="min-w-100px">{{ __('trips.location') }}</th>
                                <th class="min-w-150px">{{ __('trips.start_date') }}</th>
                                <th class="min-w-150px">{{ __('trips.end_date') }}</th>
                                <th class="min-w-50px">{{ __('trips.media') }}</th>
                                <th class="min-w-50px">{{ __('trips.documents') }}</th>
                                <th class="min-w-100px">{{ __('trips.actions') }}</th>
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
    @if(auth()->user()->hasPermissionTo(PermissionEnum::CREATE_TRIPS->value))
        <!--begin::Modal - Add Users-->
        @include('admin.trips.modals.create')
        <!--end::Modal - Add Users-->
    @endif
    @if(auth()->user()->hasPermissionTo(PermissionEnum::UPDATE_TRIPS->value))
        <!--begin::Modal - Update user-->
        @include('admin.trips.modals.edit')
        <!--end::Modal - Update user-->
    @endif
    @include('admin.trips.modals.preview')
@endsection
@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            flatpickr(".flatpickr-input", {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                onClose: function(selectedDates, dateStr, instance) {
                    if (!dateStr) {
                        instance.input.placeholder = "Select date & time";
                    }
                }
            });
        });
    </script>
    @if(auth()->user()->hasPermissionTo(PermissionEnum::LIST_TRIPS->value))
        <script>
            $('#kt_table_users').on('draw.dt', function () {
                KTMenu.createInstances();
            });
            "use strict";

            var KTUsersList = function () {
                // Define shared variables
                var table = document.getElementById('kt_table_users');
                var datatable;
                var toolbarBase;
                var toolbarSelected;
                var selectedCount;

                // Private functions
                var initUserTable = function () {
                    // Set date data order
                    const tableRows = table.querySelectorAll('tbody tr');

                    tableRows.forEach(row => {
                        const dateRow = row.querySelectorAll('td');
                        const lastLogin = dateRow[2].innerText.toLowerCase(); // Get last login time
                        let timeCount = 0;
                        let timeFormat = 'minutes';

                        // Determine date & time format -- add more formats when necessary
                        if (!lastLogin) {
                            return;
                        } else {
                            if (lastLogin.includes('yesterday')) {
                                timeCount = 1;
                                timeFormat = 'days';
                            } else if (lastLogin.includes('mins')) {
                                timeCount = parseInt(lastLogin.replace(/\D/g, ''));
                                timeFormat = 'minutes';
                            } else if (lastLogin.includes('hours')) {
                                timeCount = parseInt(lastLogin.replace(/\D/g, ''));
                                timeFormat = 'hours';
                            } else if (lastLogin.includes('days')) {
                                timeCount = parseInt(lastLogin.replace(/\D/g, ''));
                                timeFormat = 'days';
                            } else if (lastLogin.includes('weeks')) {
                                timeCount = parseInt(lastLogin.replace(/\D/g, ''));
                                timeFormat = 'weeks';
                            }
                        }

                        // Subtract date/time from today -- more info on moment datetime subtraction: https://momentjs.com/docs/#/durations/subtract/
                        const realDate = moment().subtract(timeCount, timeFormat).format();

                        // Insert real date to last login attribute
                        // dateRow[2].setAttribute('data-order', realDate);

                        // Set real date for joined column
                        const joinedDate = moment(dateRow[3].innerHTML, "DD MMM YYYY, LT").format(); // select date from 5th column in table
                        dateRow[3].setAttribute('data-order', joinedDate);
                    });

                    // Init datatable --- more info on datatables: https://datatables.net/manual/
                    datatable = $(table).DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: "/trips/all",
                        columns: [
                            {
                                data: 'name',
                                name: 'name',
                                orderable: false,
                                className: 'text-center'
                            },
                            {
                                data: 'company_name',
                                name: 'company_name',
                                orderable: false,
                                searchable: false,
                                className: 'text-center'
                            },
                            {
                                data: 'location',
                                name: 'location',
                                orderable: false,
                                searchable: false,
                                className: 'text-center'
                            },
                            {
                                data: 'start_date',
                                name: 'start_date',
                                orderable: false,
                                searchable: false,
                                className: 'text-center'
                            },
                            {
                                data: 'end_date',
                                name: 'end_date',
                                orderable: false,
                                searchable: false,
                                className: 'text-center'
                            },
                            {
                                data: 'media',
                                name: 'media',
                                orderable: false,
                                searchable: false,
                                className: 'text-center'
                            },
                            {
                                data: 'documents',
                                name: 'documents',
                                orderable: false,
                                searchable: false,
                                className: 'text-center'
                            },
                            {
                                data: 'actions',
                                name: 'actions',
                                orderable: false,
                                searchable: false,
                                className: 'text-center'
                            }
                        ]
                    });

                    // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
                    datatable.on('draw', function () {
                        initToggleToolbar();
                        handleDeleteRows();
                        toggleToolbars();
                    });
                }

                // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
                var handleSearchDatatable = () => {
                    const filterSearch = document.querySelector('[data-kt-user-table-filter="search"]');
                    filterSearch.addEventListener('keyup', function (e) {
                        datatable.search(e.target.value).draw();
                    });
                }

                // Filter Datatable
                var handleFilterDatatable = () => {
                    // Select filter options
                    const filterForm = document.querySelector('[data-kt-user-table-filter="form"]');
                    if (!filterForm) return;
                    const filterButton = filterForm.querySelector('[data-kt-user-table-filter="filter"]');
                    if (!filterButton) return;
                    const selectOptions = filterForm.querySelectorAll('select');

                    // Filter datatable on submit
                    filterButton.addEventListener('click', function () {
                        var filterString = '';

                        // Get filter values
                        selectOptions.forEach((item, index) => {
                            if (item.value && item.value !== '') {
                                if (index !== 0) {
                                    filterString += ' ';
                                }

                                // Build filter value options
                                filterString += item.value;
                            }
                        });

                        // Filter datatable --- official docs reference: https://datatables.net/reference/api/search()
                        datatable.search(filterString).draw();
                    });
                }

                // Reset Filter
                var handleResetForm = () => {
                    // Select reset button
                    const resetButton = document.querySelector('[data-kt-user-table-filter="reset"]');
                    if (!resetButton) return;
                    // Reset datatable
                    resetButton.addEventListener('click', function () {
                        // Select filter options
                        const filterForm = document.querySelector('[data-kt-user-table-filter="form"]');
                        const selectOptions = filterForm.querySelectorAll('select');

                        // Reset select2 values -- more info: https://select2.org/programmatic-control/add-select-clear-items
                        selectOptions.forEach(select => {
                            $(select).val('').trigger('change');
                        });

                        // Reset datatable --- official docs reference: https://datatables.net/reference/api/search()
                        datatable.search('').draw();
                    });
                }


                // Delete subscirption
                var handleDeleteRows = () => {
                    // Add event listener to the document (event delegation)
                }

                // Init toggle toolbar
                var initToggleToolbar = () => {
                    // Toggle selected action toolbar
                    // Select all checkboxes
                    const checkboxes = table.querySelectorAll('[type="checkbox"]');

                    // Select elements
                    toolbarBase = document.querySelector('[data-kt-user-table-toolbar="base"]');
                    toolbarSelected = document.querySelector('[data-kt-user-table-toolbar="selected"]');
                    selectedCount = document.querySelector('[data-kt-user-table-select="selected_count"]');
                    const deleteSelected = document.querySelector('[data-kt-user-table-select="delete_selected"]');

                    // Toggle delete selected toolbar
                    checkboxes.forEach(c => {
                        // Checkbox on click event
                        c.addEventListener('click', function () {
                            setTimeout(function () {
                                toggleToolbars();
                            }, 50);
                        });
                    });
                    if (!deleteSelected) return;
                    // Deleted selected rows
                    deleteSelected.addEventListener('click', function () {
                        // SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
                        Swal.fire({
                            text: "Are you sure you want to delete selected customers?",
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
                            if (result.value) {
                                Swal.fire({
                                    text: "You have deleted all selected customers!.",
                                    icon: "success",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn fw-bold btn-primary",
                                    }
                                }).then(function () {
                                    // Remove all selected customers
                                    checkboxes.forEach(c => {
                                        if (c.checked) {
                                            datatable.row($(c.closest('tbody tr'))).remove().draw();
                                        }
                                    });

                                    // Remove header checked box
                                    const headerCheckbox = table.querySelectorAll('[type="checkbox"]')[0];
                                    headerCheckbox.checked = false;
                                }).then(function () {
                                    toggleToolbars(); // Detect checked checkboxes
                                    initToggleToolbar(); // Re-init toolbar to recalculate checkboxes
                                });
                            } else if (result.dismiss === 'cancel') {
                                Swal.fire({
                                    text: "Selected customers was not deleted.",
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn fw-bold btn-primary",
                                    }
                                });
                            }
                        });
                    });
                }

                // Toggle toolbars
                const toggleToolbars = () => {
                    // Select refreshed checkbox DOM elements
                    const allCheckboxes = table.querySelectorAll('tbody [type="checkbox"]');

                    // Detect checkboxes state & count
                    let checkedState = false;
                    let count = 0;

                    // Count checked boxes
                    allCheckboxes.forEach(c => {
                        if (c.checked) {
                            checkedState = true;
                            count++;
                        }
                    });

                    // Ensure toolbar elements exist before modifying them
                    if (toolbarBase && toolbarSelected && selectedCount) {
                        // Toggle toolbars
                        if (checkedState) {
                            selectedCount.innerHTML = count;
                            toolbarBase.classList.add('d-none');
                            toolbarSelected.classList.remove('d-none');
                        } else {
                            toolbarBase.classList.remove('d-none');
                            toolbarSelected.classList.add('d-none');
                        }
                    }
                }

                return {
                    // Public functions
                    init: function () {
                        if (!table) {
                            return;
                        }

                        initUserTable();
                        initToggleToolbar();
                        handleSearchDatatable();
                        handleResetForm();
                        handleDeleteRows();
                        handleFilterDatatable();

                    }
                }
            }();

            // On document ready
            KTUtil.onDOMContentLoaded(function () {
                KTUsersList.init();
            });

        </script>
    @endif

    @if(auth()->user()->hasPermissionTo(PermissionEnum::CREATE_TRIPS->value))
        <script>
            "use strict";

            // Class definition
            var KTUsersAddUser = function () {
                // Shared variables
                const element = document.getElementById('kt_modal_add_trip');
                const form = element.querySelector('#kt_modal_add_trip_form');
                const modal = new bootstrap.Modal(element);

                // Init add schedule modal
                var initAddUser = () => {

                    // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
                    var validator = FormValidation.formValidation(
                        form,
                        {
                            fields: {
                                'event_name': {
                                    validators: {
                                        notEmpty: {
                                            message: 'Trip name is required'
                                        }
                                    }
                                },
                                'company_name': {
                                    validators: {
                                        notEmpty: {
                                            message: 'Company name is required'
                                        }
                                    }
                                },
                                'location': {
                                    validators: {
                                        notEmpty: {
                                            message: 'Location is required'
                                        }
                                    }
                                },
                                'start_date': {
                                    validators: {
                                        notEmpty: {
                                            message: 'Event start date is required'
                                        }
                                    }
                                },
                                'end_date': {
                                    validators: {
                                        notEmpty: {
                                            message: 'Event end date is required'
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

                    // Submit button handler
                    const submitButton = element.querySelector('[data-kt-users-modal-action="submit"]');
                    submitButton.addEventListener('click', e => {
                        e.preventDefault();

                        if (validator) {
                            validator.validate().then(function (status) {
                                if (status === 'Valid') {
                                    submitButton.setAttribute('data-kt-indicator', 'on');
                                    submitButton.disabled = true;

                                    // Get form data
                                    let formData = new FormData(form);

                                    // Send AJAX request
                                    $.ajax({
                                        url: form.getAttribute('action'),
                                        type: "POST",
                                        data: formData,
                                        processData: false,
                                        contentType: false,
                                        success: function (response) {
                                            submitButton.removeAttribute("data-kt-indicator");
                                            submitButton.disabled = false;

                                            Swal.fire({
                                                text: response.message,
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
                                                    location.reload();
                                                }
                                            });
                                        },
                                        error: function (xhr) {
                                            submitButton.removeAttribute("data-kt-indicator");
                                            submitButton.disabled = false;

                                            let errorMessage = "Something went wrong! Please try again later.";

                                            if (xhr.responseJSON && xhr.responseJSON.errors) {
                                                errorMessage = Object.values(xhr.responseJSON.errors).join("\n");
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
                                        text: "Please fix the errors and try again.",
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
                    // Cancel button handler
                    const cancelButton = element.querySelector('[data-kt-users-modal-action="cancel"]');
                    cancelButton.addEventListener('click', e => {
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
                                modal.hide();
                                form.reset();
                            } else if (result.dismiss === 'cancel') {
                                Swal.fire({
                                    text: "Your form has not been cancelled!.",
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

                    // Close button handler
                    const closeButton = element.querySelector('[data-kt-users-modal-action="close"]');
                    closeButton.addEventListener('click', e => {
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
                                modal.hide();
                                form.reset();
                            } else if (result.dismiss === 'cancel') {
                                Swal.fire({
                                    text: "Your form has not been cancelled!.",
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
                }

                return {
                    // Public functions
                    init: function () {
                        initAddUser();
                    }
                };
            }();

            // On document ready
            KTUtil.onDOMContentLoaded(function () {
                KTUsersAddUser.init();
            });
        </script>
    @endif

    @if(auth()->user()->hasPermissionTo(PermissionEnum::UPDATE_TRIPS->value))
        <script>
            "use strict";

            // Class definition
            var KTUsersUpdateDetails = function () {
                // Shared variables
                const element = document.getElementById('kt_modal_update_trip');
                const form = element.querySelector('#kt_modal_update_trip_form');
                const modal = new bootstrap.Modal(element);

                // Function to populate the form with trip data
                var populateForm = (response) => {
                    // Populate basic fields
                    form.querySelector('[name="event_name"]').value = response.trip.event_name || "";
                    form.querySelector('[name="company_name"]').value = response.trip.company_name || "";
                    form.querySelector('[name="location"]').value = response.trip.location || "";
                    form.querySelector('[name="start_date"]').value = response.trip.start_date || "";
                    form.querySelector('[name="end_date"]').value = response.trip.end_date || "";
                    form.querySelector('[name="description"]').value = response.trip.description || "";

                    // Handle media file
                    if (response.trip.media_path) {
                        $('#current_media_path').val(response.trip.media_path);
                        $('#current_media_name').text(response.trip.media_name || 'Current Media File');
                        $('#edit_media_preview_btn').removeClass('d-none').attr('data-content', response.trip.media_path);
                        $('#remove_media_btn').removeClass('d-none');
                    } else {
                        $('#current_media_path').val('');
                        $('#current_media_name').text('');
                        $('#edit_media_preview_btn').addClass('d-none');
                        $('#remove_media_btn').addClass('d-none');
                    }

                    // Handle document file
                    if (response.trip.document_path) {
                        $('#current_document_path').val(response.trip.document_path);
                        $('#current_document_name').text(response.trip.document_name || 'Current Document File');
                        $('#edit_document_preview_btn').removeClass('d-none').attr('data-content', response.trip.document_path);
                        $('#remove_document_btn').removeClass('d-none');
                    } else {
                        $('#current_document_path').val('');
                        $('#current_document_name').text('');
                        $('#edit_document_preview_btn').addClass('d-none');
                        $('#remove_document_btn').addClass('d-none');
                    }

                    // Handle programs selection (assuming response has program_ids array)
                    if (response.program_ids && response.program_ids.length > 0) {
                        $('#edit_program_ids').val(response.program_ids).trigger('change');
                    } else {
                        $('#edit_program_ids').val([]).trigger('change');
                    }

                    // Set the trip ID for the form
                    $("#kt_modal_update_trip_form").attr("data-user-id", response.trip.id);
                };

                // Reset form function
                var resetForm = () => {
                    form.reset();
                    $('#edit_program_ids').val([]).trigger('change');
                    $('#current_media_path').val('');
                    $('#current_media_name').text('');
                    $('#edit_media_preview_btn').addClass('d-none');
                    $('#remove_media_btn').addClass('d-none');
                    $('#current_document_path').val('');
                    $('#current_document_name').text('');
                    $('#edit_document_preview_btn').addClass('d-none');
                    $('#remove_document_btn').addClass('d-none');
                };

                // Fetch trip data when modal is opened
                element.addEventListener('show.bs.modal', function (event) {
                    let button = event.relatedTarget;
                    let tripId = button.getAttribute('data-user-id');

                    if (tripId) {
                        $.ajax({
                            url: `/trips/${tripId}/edit`,
                            type: "GET",
                            success: function (response) {
                                populateForm(response);
                            },
                            error: function (xhr) {
                                console.error("Error fetching trip data", xhr);
                                Swal.fire({
                                    text: "Error loading trip data. Please try again.",
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

                // Init update trip modal
                var initUpdateDetails = () => {
                    // Init form validation
                    var validator = FormValidation.formValidation(
                        form,
                        {
                            fields: {
                                'event_name': {
                                    validators: {
                                        notEmpty: {
                                            message: 'Trip name is required'
                                        }
                                    }
                                },
                                'company_name': {
                                    validators: {
                                        notEmpty: {
                                            message: 'Company name is required'
                                        }
                                    }
                                },
                                'location': {
                                    validators: {
                                        notEmpty: {
                                            message: 'Location is required'
                                        }
                                    }
                                },
                                'start_date': {
                                    validators: {
                                        notEmpty: {
                                            message: 'Event start date is required'
                                        }
                                    }
                                },
                                'end_date': {
                                    validators: {
                                        notEmpty: {
                                            message: 'Event end date is required'
                                        }
                                    }
                                },
                                // 'program_ids[]': {
                                //     validators: {
                                //         notEmpty: {
                                //             message: 'At least one program must be selected'
                                //         }
                                //     }
                                // }
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

                    // Submit button handler
                    const submitButton = element.querySelector('[data-kt-users-modal-action="submit"]');
                    submitButton.addEventListener('click', e => {
                        e.preventDefault();

                        if (validator) {
                            validator.validate().then(function (status) {
                                if (status === 'Valid') {
                                    submitButton.setAttribute('data-kt-indicator', 'on');
                                    submitButton.disabled = true;

                                    // Get form data and send AJAX request
                                    let formData = new FormData(form);
                                    let tripId = $('#kt_modal_update_trip_form').data('user-id');
                                    let updateUrl = `/trips/${tripId}`;

                                    $.ajax({
                                        url: updateUrl,
                                        type: "POST",
                                        data: formData,
                                        processData: false,
                                        contentType: false,
                                        success: function (response) {
                                            submitButton.removeAttribute('data-kt-indicator');
                                            submitButton.disabled = false;

                                            Swal.fire({
                                                text: response.message || "Trip updated successfully!",
                                                icon: "success",
                                                buttonsStyling: false,
                                                confirmButtonText: "Ok, got it!",
                                                customClass: {
                                                    confirmButton: "btn btn-primary"
                                                }
                                            }).then(function (result) {
                                                if (result.isConfirmed) {
                                                    resetForm();
                                                    modal.hide();
                                                    location.reload();

                                                    // // Reload the DataTable
                                                    // if (typeof $('#kt_table_users').DataTable === 'function') {
                                                    //     $('#kt_table_users').DataTable().ajax.reload();
                                                    // } else {
                                                    //     location.reload();
                                                    // }
                                                }
                                            });
                                        },
                                        error: function (xhr) {
                                            submitButton.removeAttribute('data-kt-indicator');
                                            submitButton.disabled = false;

                                            let errorMessage = "Something went wrong! Please try again later.";

                                            if (xhr.responseJSON && xhr.responseJSON.errors) {
                                                errorMessage = Object.values(xhr.responseJSON.errors).flat().join("\n");
                                            } else if (xhr.responseJSON && xhr.responseJSON.message) {
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
                                        text: "Please fix the errors and try again.",
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

                    // Cancel button handler
                    const cancelButton = element.querySelector('[data-kt-users-modal-action="cancel"]');
                    if (cancelButton) {
                        cancelButton.addEventListener('click', resetAndCloseModal);
                    }

                    // Close button handler
                    const closeButton = element.querySelector('[data-kt-users-modal-action="close"]');
                    if (closeButton) {
                        closeButton.addEventListener('click', resetAndCloseModal);
                    }

                    function resetAndCloseModal(e) {
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
                                resetForm();
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
                    }

                    // Reset form when modal is hidden
                    element.addEventListener('hidden.bs.modal', function () {
                        resetForm();
                    });
                }

                return {
                    // Public functions
                    init: function () {
                        initUpdateDetails();
                    }
                };
            }();

            // On document ready
            KTUtil.onDOMContentLoaded(function () {
                KTUsersUpdateDetails.init();
                $('#edit_program_ids').select2({
                    dropdownParent: $('#kt_modal_update_trip')
                });
            });

            // Additional JavaScript for file handling and preview functionality
            $(document).ready(function() {
                // Handle remove media button
                $('#remove_media_btn').on('click', function() {
                    $('#edit_media').val('');
                    $('#current_media_path').val('');
                    $('#current_media_name').text('');
                    $('#edit_media_preview_btn').addClass('d-none');
                    $('#remove_media_btn').addClass('d-none');
                    $('#edit_media_preview_btn').attr('data-content', '');
                });

                // Handle remove document button
                $('#remove_document_btn').on('click', function() {
                    $('#edit_document').val('');
                    $('#current_document_path').val('');
                    $('#current_document_name').text('');
                    $('#edit_document_preview_btn').addClass('d-none');
                    $('#remove_document_btn').addClass('d-none');
                    $('#edit_document_preview_btn').attr('data-content', '');
                });
            });
        </script>
    @endif

    @if(auth()->user()->hasPermissionTo(PermissionEnum::DELETE_TRIPS->value))
        <script>
            // handle delete user
            $(document).on("click", '[data-kt-users-table-filter="delete_row"]', function (e) {
                e.preventDefault();

                var userId = $(this).data("user-id");

                Swal.fire({
                    text: "Are you sure you want to delete this Trip?",
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
                            url: "{{ route('admin.trips.destroy', ':id') }}".replace(':id', userId),
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
                                    text: "Failed to delete the Trip. Try again Later!",
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

    <!-- handle preview modal -->
    <script>
        $(document).ready(function() {
            // Handle preview trigger clicks
            $(document).on('click', '.preview-trigger', function(e) {
                e.preventDefault();

                const filePath = $(this).data('content');
                const modal = $('#kt_modal_preview');
                const previewBody = $('#preview-body');
                const previewTitle = $('#preview-title');

                // Clear previous content
                previewBody.empty();

                if (!filePath) {
                    previewBody.html('<p class="text-muted">No file available for preview</p>');
                    previewTitle.text('Preview - No File');
                    modal.modal('show');
                    return;
                }

                // Get file extension
                const fileExtension = filePath.split('.').pop().toLowerCase();
                const fileName = filePath.split('/').pop();

                // Update modal title
                previewTitle.text(`Preview - ${fileName}`);

                // Handle different file types
                switch(fileExtension) {
                    case 'jpg':
                    case 'jpeg':
                    case 'png':
                        // Image preview
                        previewBody.html(`
                    <div class="image-preview">
                        <img src="${filePath}" class="img-fluid rounded" alt="Preview" style="max-height: 500px; max-width: 100%;"
                             onerror="this.parentElement.innerHTML='<p class=\\'text-danger\\'>Error loading image</p>'">
                    </div>
                `);
                        break;

                    case 'mp4':
                        // Video preview
                        previewBody.html(`
                    <div class="video-preview">
                        <video controls class="w-100 rounded" style="max-height: 500px;">
                            <source src="${filePath}" type="video/${fileExtension === 'mov' ? 'quicktime' : fileExtension}">
                            <p class="text-danger">Your browser does not support the video tag.</p>
                        </video>
                    </div>
                `);
                        break;

                    case 'pdf':
                        // PDF preview
                        previewBody.html(`
                    <div class="pdf-preview">
                        <iframe src="${window.location.origin}/${filePath}" width="100%" height="500px" class="rounded border">
                            <p class="text-muted">
                                Your browser does not support PDF preview.
                                <a href="${window.location.origin}/${filePath}" target="_blank" class="btn btn-primary btn-sm">
                                    <i class="bi bi-download"></i> Download PDF
                                </a>
                            </p>
                        </iframe>
                    </div>
                `);
                        break;

                    case 'doc':
                    case 'docx':
                        // Word document - show download option
                        previewBody.html(`
                    <div class="document-preview text-center">
                        <i class="bi bi-file-earmark-word fs-4x text-primary mb-4"></i>
                        <h5>Word Document</h5>
                        <p class="text-muted mb-4">Preview not available for this file type</p>
                        <a href="${window.location.origin}/${filePath}" target="_blank" class="btn btn-primary">
                            <i class="bi bi-download"></i> Download Document
                        </a>
                    </div>
                `);
                        break;

                    case 'txt':
                        // Text file preview
                        fetch(filePath)
                            .then(response => response.text())
                            .then(text => {
                                previewBody.html(`
                            <div class="text-preview">
                                <pre class="bg-light p-4 rounded" style="max-height: 500px; overflow-y: auto; white-space: pre-wrap;">${text}</pre>
                            </div>
                        `);
                            })
                            .catch(error => {
                                previewBody.html(`
                            <div class="document-preview text-center">
                                <i class="bi bi-file-earmark-text fs-4x text-info mb-4"></i>
                                <h5>Text Document</h5>
                                <p class="text-danger mb-4">Error loading file content</p>
                                <a href="${window.location.origin}/${filePath}" target="_blank" class="btn btn-info">
                                    <i class="bi bi-download"></i> Download File
                                </a>
                            </div>
                        `);
                            });
                        break;

                    default:
                        // Unknown file type
                        previewBody.html(`
                    <div class="document-preview text-center">
                        <i class="bi bi-file-earmark fs-4x text-secondary mb-4"></i>
                        <h5>Unknown File Type</h5>
                        <p class="text-muted mb-4">Preview not available for .${fileExtension} files</p>
                        <a href="${window.location.origin}/${filePath}" target="_blank" class="btn btn-secondary">
                            <i class="bi bi-download"></i> Download File
                        </a>
                    </div>
                `);
                }

                // Show the modal
                modal.modal('show');
            });

            // Handle modal close button
            $(document).on('click', '[data-kt-users-modal-action="close"]', function() {
                $('#kt_modal_preview').modal('hide');
            });

            // Clear content when modal is hidden
            $('#kt_modal_preview').on('hidden.bs.modal', function() {
                $('#preview-body').empty();
                $('#preview-title').text('Preview');
            });

            // Handle loading states
            $(document).on('loadstart', '#preview-body video, #preview-body img', function() {
                $(this).after('<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>');
            });

            $(document).on('loadend load', '#preview-body video, #preview-body img', function() {
                $(this).siblings('.spinner-border').remove();
            });
        });
    </script>
@endsection
