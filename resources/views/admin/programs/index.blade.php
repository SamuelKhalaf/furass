@php use App\Enums\PermissionEnum; @endphp
@extends('admin.layouts.master')
@section('title', __('programs.title'))
@push('styles')
    <style>
        .path-point-item {
            transition: all 0.3s ease;
            cursor: move;
        }
        .path-point-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        .path-point-item.sortable-ghost {
            opacity: 0.4;
        }
        .path-visual {
            position: relative;
        }
        .path-connector {
            position: absolute;
            left: 50%;
            top: 100%;
            width: 2px;
            height: 20px;
            background: #007bff;
            transform: translateX(-50%);
        }
        .path-point-item:last-child .path-connector {
            display: none;
        }
        .available-points {
            max-height: 300px;
            overflow-y: auto;
        }
        .available-point {
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .available-point:hover {
            background-color: #f8f9fa;
            transform: translateX(5px);
        }
        .path-step-number {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: #007bff;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 10px;
        }
        .empty-path {
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            padding: 40px;
            text-align: center;
            color: #6c757d;
        }
    </style>
    <style>
        .path-point-item {
            position: relative;
            transition: all 0.3s ease;
            cursor: move;
            background: white;
            border: 1px solid #e9ecef;
        }

        .path-point-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .path-point-item.sortable-ghost {
            opacity: 0.5;
            background: #f8f9fa;
        }

        .drag-handle {
            cursor: move;
        }

        .path-step-number {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: #009ef7;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 12px;
            flex-shrink: 0;
        }

        .path-connector {
            position: relative;
            height: 15px;
            width: 2px;
            background: #009ef7;
            margin: 0 auto;
            display: block;
        }

        .available-point {
            cursor: pointer;
            transition: all 0.2s ease;
            background: white;
        }

        .available-point:hover {
            background-color: #f5f8fa;
            border-color: #009ef7;
        }

        .empty-path {
            border: 2px dashed #e9ecef;
            border-radius: 6px;
            padding: 40px 20px;
            text-align: center;
            color: #7e8299;
            background: #fafafa;
        }

        @media (max-width: 768px) {
            .modal-dialog {
                margin: 0.5rem;
            }

            .modal-content {
                padding: 10px;
            }

            .path-point-item {
                padding: 12px;
            }
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
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">{{ __('programs.list') }}</h1>
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
                        <li class="breadcrumb-item text-muted">{{ __('programs.title') }}</li>
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
                                       placeholder="{{ __('programs.search') }}"/>
                            </div>
                            <!--end::Search-->
                        </div>
                        <!--begin::Card title-->
                        <!--begin::Card toolbar-->
{{--                        <div class="card-toolbar">--}}
                            <!--begin::Toolbar-->
{{--                            <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">--}}
{{--                                @if(auth()->user()->hasPermissionTo(PermissionEnum::CREATE_PROGRAMS->value))--}}
{{--                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"--}}
{{--                                            data-bs-target="#kt_modal_add_program">--}}
{{--                                        <span class="svg-icon svg-icon-2"><i class="fa-solid fa-plus"></i></span>--}}
{{--                                        {{ __('programs.create') }}--}}
{{--                                    </button>--}}
{{--                                @endif--}}
{{--                            </div>--}}
                            <!--end::Toolbar-->
{{--                        </div>--}}
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
                                <th class="min-w-125px">{{ __('programs.title_ar') }}</th>
                                <th class="min-w-125px">{{ __('programs.title_en') }}</th>
                                <th class="min-w-125px">{{ __('programs.description_ar') }}</th>
                                <th class="min-w-125px">{{ __('programs.description_en') }}</th>
                                <th class="min-w-100px">{{ __('programs.actions') }}</th>
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
    @if(auth()->user()->hasPermissionTo(PermissionEnum::CREATE_PROGRAMS->value))
        <!--begin::Modal - Add Users-->
        @include('admin.programs.modals.create')
        <!--end::Modal - Add Users-->
    @endif
    @if(auth()->user()->hasPermissionTo(PermissionEnum::UPDATE_PROGRAMS->value))
        <!--begin::Modal - Update user-->
        @include('admin.programs.modals.edit')
        <!--end::Modal - Update user-->
    @endif
@endsection
@section('scripts')
    @if(auth()->user()->hasPermissionTo(PermissionEnum::LIST_PROGRAMS->value))
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
                        ajax: "/programs/all",
                        columns: [
                            {
                                data: 'title_ar',
                                name: 'title_ar',
                                orderable: false,
                                className: 'text-center'
                            },
                            {
                                data: 'title_en',
                                name: 'title_en',
                                orderable: false,
                                className: 'text-center'
                            },
                            {
                                data: 'description_ar',
                                name: 'description_ar',
                                orderable: false,
                                className: 'text-center'
                            },
                            {
                                data: 'description_en',
                                name: 'description_en',
                                orderable: false,
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

    @if(auth()->user()->hasPermissionTo(PermissionEnum::CREATE_PROGRAMS->value))
        <script>
            "use strict";

            // Class definition
            var KTUsersAddUser = function () {
                // Shared variables
                const element = document.getElementById('kt_modal_add_program');
                const form = element.querySelector('#kt_modal_add_program_form');
                const modal = new bootstrap.Modal(element);

                // Init add schedule modal
                var initAddUser = () => {

                    // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
                    var validator = FormValidation.formValidation(
                        form,
                        {
                            fields: {
                                'name': {
                                    validators: {
                                        notEmpty: {
                                            message: 'Program name is required'
                                        }
                                    }
                                },
                                'email': {
                                    validators: {
                                        notEmpty: {
                                            message: 'Valid email address is required'
                                        }
                                    }
                                },
                                'phone_number': {
                                    validators: {
                                        notEmpty: {
                                            message: 'Valid phone number is required'
                                        }
                                    }
                                },
                                'bio': {
                                    validators: {
                                        notEmpty: {
                                            message: 'Bio field is required'
                                        }
                                    }
                                },
                                'password': {
                                    validators: {
                                        notEmpty: {
                                            message: 'Password field is required'
                                        }
                                    }
                                },
                                'password_confirmation': {
                                    validators: {
                                        notEmpty: {
                                            message: 'Confirm password field is required'
                                        }
                                    }
                                },
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

    <script>
        "use strict";

        // Class definition
        var KTProgramsUpdateDetails = function () {
            // Shared variables
            const element = document.getElementById('kt_modal_update_program');
            const form = element.querySelector('#kt_modal_update_program_form');
            const modal = new bootstrap.Modal(element);

            // Path management variables
            let programPathData = [];
            let availablePathPoints = {};
            let sortableInstance = null;

            // Function to populate the form with program data
            var populateForm = (response) => {
                // Basic program info
                form.querySelector('[name="title_ar"]').value = response.program.title_ar || "";
                form.querySelector('[name="title_en"]').value = response.program.title_en || "";
                form.querySelector('[name="description_ar"]').value = response.program.description_ar || "";
                form.querySelector('[name="description_en"]').value = response.program.description_en || "";

                // Store available path points
                availablePathPoints = {};
                response.path_points.forEach(point => {
                    availablePathPoints[point.id] = point;
                });

                // Render available points
                renderAvailablePathPoints();

                // Load program path points
                programPathData = [];
                if (response.program.path_points && response.program.path_points.length > 0) {
                    programPathData = response.program.path_points.map(point => ({
                        id: point.id,
                        title_en: point.title_en,
                        title_ar: point.title_ar,
                        table_name: point.table_name,
                        order: point.pivot ? point.pivot.order : point.order
                    }));
                    // Sort by order
                    programPathData.sort((a, b) => a.order - b.order);
                }

                updatePathVisual();
                updatePathData();
                initializeSortable();
            };

            // Initialize sortable functionality
            function initializeSortable() {
                const pathContainer = document.getElementById('programPath');
                if (!pathContainer) return;

                // Destroy previous instance if exists
                if (sortableInstance) {
                    sortableInstance.destroy();
                }

                sortableInstance = new Sortable(pathContainer, {
                    animation: 150,
                    ghostClass: 'sortable-ghost',
                    handle: '.drag-handle',
                    onEnd: function() {
                        updatePathDataFromDOM();
                        updatePathVisual();
                    }
                });
            }

            // Render available path points
            function renderAvailablePathPoints() {
                const container = document.querySelector('.available-points');
                if (!container) return;

                let html = '';
                Object.values(availablePathPoints).forEach(point => {
                    html += `
                <div class="available-point border rounded p-2 mb-2" data-id="${point.id}">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-location-dot text-success me-2"></i>
                        <div class="flex-grow-1">
                            <strong>${point.title_en}</strong> / ${point.title_ar}
                        </div>
                        <button class="btn btn-sm btn-icon btn-light-success ms-2"
                                onclick="event.preventDefault();
                                KTProgramsUpdateDetails.addPathPoint(${point.id})"
                                title="Add to new step">
                            <i class="fa-solid fa-plus-circle"></i>
                        </button>
                        <button class="btn btn-sm btn-icon btn-light-primary ms-2"
                                onclick="event.preventDefault();
                                KTProgramsUpdateDetails.addPathPoint(${point.id}, true)"
                                title="Add to current step">
                            <i class="fas fa-layer-group"></i>
                        </button>
                    </div>
                </div>
            `;
                });

                container.innerHTML = html;

                // // Add click listeners
                // container.querySelectorAll('.available-point').forEach(point => {
                //     point.addEventListener('click', function() {
                //         const pathPointId = parseInt(this.dataset.id);
                //         addPathPoint(pathPointId);
                //     });
                // });
            }
            // Add path point to program
            function addPathPoint(pathPointId, sameOrder = false) {
                const point = availablePathPoints[pathPointId];
                if (!point) return;

                // Check if already exists
                if (programPathData.some(p => p.id === pathPointId)) {
                    Swal.fire({
                        text: "This path point is already in the program",
                        icon: "warning",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary",
                        }
                    });
                    return;
                }

                // Determine the order number
                let order;
                if (sameOrder && programPathData.length > 0) {
                    // Use the same order as the last point
                    order = programPathData[programPathData.length - 1].order;
                } else {
                    // Use the next sequential order
                    order = programPathData.length > 0
                        ? Math.max(...programPathData.map(p => p.order)) + 1
                        : 1;
                }

                programPathData.push({
                    id: point.id,
                    title_en: point.title_en,
                    title_ar: point.title_ar,
                    table_name: point.table_name,
                    order: order
                });

                updatePathVisual();
                updatePathData();
            }
            // Remove path point from program
            function removePathPoint(pathPointId) {
                programPathData = programPathData.filter(p => p.id !== pathPointId);

                // Recalculate order
                programPathData.forEach((point, index) => {
                    point.order = index + 1;
                });

                updatePathVisual();
                updatePathData();
            }

            // Clear all path points
            function clearPath() {
                if (programPathData.length === 0) return;

                Swal.fire({
                    text: "Are you sure you want to clear all path points?",
                    icon: "warning",
                    showCancelButton: true,
                    buttonsStyling: false,
                    confirmButtonText: "Yes, clear them!",
                    cancelButtonText: "No, keep them",
                    customClass: {
                        confirmButton: "btn btn-primary",
                        cancelButton: "btn btn-active-light"
                    }
                }).then(function (result) {
                    if (result.isConfirmed) {
                        programPathData = [];
                        updatePathVisual();
                        updatePathData();
                    }
                });
            }

            // Update path visual representation
            function updatePathVisual() {
                const pathContainer = document.getElementById('programPath');

                if (programPathData.length === 0) {
                    pathContainer.innerHTML = `
                <div class="empty-path">
                    <i class="fas fa-route fa-2x mb-3 text-muted"></i>
                    <p class="mb-0">Drag path points here to create learning path</p>
                    <small class="text-muted">You can reorder by dragging</small>
                </div>
            `;
                } else {
                    // Group points by order
                    const groupedPoints = {};
                    programPathData.forEach(point => {
                        if (!groupedPoints[point.order]) {
                            groupedPoints[point.order] = [];
                        }
                        groupedPoints[point.order].push(point);
                    });

                    let pathHtml = '';
                    Object.keys(groupedPoints).forEach(order => {
                        const points = groupedPoints[order];

                        points.forEach((point, index) => {
                            pathHtml += `
                <div class="path-point-item card mb-3 p-3" data-id="${point.id}">
                    <div class="d-flex align-items-center">
                        <div class="path-step-number">${order}</div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1">${point.title_en} / ${point.title_ar}</h6>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-grip-vertical drag-handle text-muted me-2" title="Drag to reorder"></i>
                            <button type="button" class="btn btn-sm btn-light-danger"
                                    onclick="KTProgramsUpdateDetails.removePathPoint(${point.id})"
                                    title="Remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    ${index < points.length - 1 ? '<div class="path-connector"></div>' : ''}
                </div>
                `;
                        });

                        // Add connector between different order groups
                        if (order < Math.max(...Object.keys(groupedPoints).map(Number))) {
                            pathHtml += '<div class="path-connector"></div>';
                        }
                    });

                    pathContainer.innerHTML = pathHtml;
                }

                updateSummary();
            }
            // Update path data from DOM after reordering
            function updatePathDataFromDOM() {
                const pathItems = document.querySelectorAll('.path-point-item');
                const newPathData = [];
                let currentOrder = 1;

                pathItems.forEach((item, index) => {
                    const pathPointId = parseInt(item.dataset.id);
                    const pathPoint = programPathData.find(p => p.id === pathPointId);

                    if (pathPoint) {
                        // Check if this is a new order group
                        if (index > 0 &&
                            !item.previousElementSibling.classList.contains('path-point-item')) {
                            currentOrder++;
                        }

                        newPathData.push({
                            ...pathPoint,
                            order: currentOrder
                        });
                    }
                });

                programPathData = newPathData;
                updatePathData();
            }

            // Update hidden input with path data
            function updatePathData() {
                const pathPointsInput = document.getElementById('pathPointsData');
                if (pathPointsInput) {
                    pathPointsInput.value = programPathData.map(p => p.id);
                }
            }

            // Update summary information
            function updateSummary() {
                document.getElementById('totalSteps').textContent = programPathData.length;
                // document.getElementById('estimatedDuration').textContent =
                //     programPathData.length > 0 ? `~${programPathData.length * 2} hours` : '-';
            }

            // Fetch program data when modal is opened
            element.addEventListener('show.bs.modal', function (event) {
                let button = event.relatedTarget;
                let programId = button.getAttribute('data-program-id');

                if (programId) {
                    form.action = form.action.replace('__ID__', programId);
                    document.getElementById('program_id').value = programId;

                    $.ajax({
                        url: `/programs/${programId}/edit`,
                        type: "GET",
                        success: function (response) {
                            populateForm(response);
                        },
                        error: function () {
                            console.error("Error fetching program data");
                            Swal.fire({
                                text: "Error fetching program data",
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
            });

            // Init update program modal
            var initUpdateDetails = () => {
                // Init form validation
                var validator = FormValidation.formValidation(
                    form,
                    {
                        fields: {
                            'title_ar': {
                                validators: {
                                    notEmpty: {
                                        message: 'Arabic title is required'
                                    }
                                }
                            },
                            'title_en': {
                                validators: {
                                    notEmpty: {
                                        message: 'English title is required'
                                    }
                                }
                            },
                            'description_ar': {
                                validators: {
                                    notEmpty: {
                                        message: 'Arabic description is required'
                                    }
                                }
                            },
                            'description_en': {
                                validators: {
                                    notEmpty: {
                                        message: 'English description is required'
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

                // Add clear path button event listener here
                const clearButton = element.querySelector('.clear-path-btn');
                if (clearButton) {
                    clearButton.addEventListener('click', function(e) {
                        e.preventDefault();
                        KTProgramsUpdateDetails.clearPath();
                    });
                }

                // Submit button handler
                const submitButton = element.querySelector('[data-kt-users-modal-action="submit"]');
                submitButton.addEventListener('click', function(e) {
                    e.preventDefault();

                    if (validator) {
                        validator.validate().then(function (status) {
                            if (status === 'Valid') {
                                submitButton.setAttribute('data-kt-indicator', 'on');
                                submitButton.disabled = true;

                                // Get form data
                                let formData = new FormData(form);
                                let programId = form.querySelector('input[name="id"]').value;

                                // Add path points data
                                if (programPathData.length > 0) {
                                    console.log(programPathData);
                                    programPathData.forEach((point, index) => {
                                        formData.append(`path_points[${index}][id]`, point.id);
                                        formData.append(`path_points[${index}][order]`, point.order);                                    });
                                }

                                // Send AJAX request
                                $.ajax({
                                    url: `/programs/${programId}`,
                                    type: "POST",
                                    data: formData,
                                    processData: false,
                                    contentType: false,
                                    success: function (response) {
                                        submitButton.removeAttribute('data-kt-indicator');
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
                                                // Optionally refresh the page or update UI
                                                if (typeof KTProgramsList !== 'undefined') {
                                                    KTProgramsList.reload();
                                                }
                                            }
                                        });
                                    },
                                    error: function (xhr) {
                                        submitButton.removeAttribute('data-kt-indicator');
                                        submitButton.disabled = false;

                                        let errorMessage = "Something went wrong! Please try again later.";

                                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                                            errorMessage = Object.values(xhr.responseJSON.errors).join("\n");
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
                cancelButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    resetAndCloseModal(e);
                });

                // Close button handler
                const closeButton = element.querySelector('[data-kt-users-modal-action="close"]');
                closeButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    resetAndCloseModal(e);
                });

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
                        if (result.isConfirmed) {
                            form.reset();
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
            }

            return {
                // Public functions
                init: function () {
                    initUpdateDetails();
                },
                addPathPoint: function(pathPointId, sameOrder = false) {
                    addPathPoint(pathPointId, sameOrder);
                },
                removePathPoint: function(pathPointId) {
                    removePathPoint(pathPointId);
                },
                clearPath: function() {
                    clearPath();
                }
            };
        }();

        // On document ready
        KTUtil.onDOMContentLoaded(function () {
            KTProgramsUpdateDetails.init();
        });
    </script>
@endsection
