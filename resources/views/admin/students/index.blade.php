@extends('admin.layouts.master')
@section('title', __('students.title'))
@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">{{ __('students.list') }}</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="{{route('admin.dashboard')}}" class="text-muted text-hover-primary">{{ __('dashboard.home') }}</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">{{ __('students.title') }}</li>
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
                                <span class="svg-icon svg-icon-1 position-absolute ms-6"><i class="fa-solid fa-magnifying-glass"></i></span>
                                <input type="text" data-kt-user-table-filter="search"
                                       class="form-control form-control-solid w-250px ps-14" placeholder="{{ __('students.search') }}"/>
                            </div>
                            <!--end::Search-->
                        </div>
                        <!--begin::Card title-->
                        <!--begin::Card toolbar-->
                        <div class="card-toolbar">
                            <!--begin::Toolbar-->
                            <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                                @if(auth()->user()->hasPermissionTo(\App\Enums\PermissionEnum::CREATE_STUDENTS->value))
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#kt_modal_add_user">
                                        <span class="svg-icon svg-icon-2"><i class="fa-solid fa-plus"></i></span>
                                        {{ __('students.create') }}
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
                                <th class="min-w-125px">{{ __('students.name') }}</th>
                                <th class="min-w-125px">{{ __('students.school') }}</th>
                                <th class="min-w-125px">{{ __('students.grade') }}</th>
                                <th class="min-w-125px">{{ __('students.birth_date') }}</th>
                                <th class="min-w-125px">{{ __('students.gender') }}</th>
                                <th class="min-w-100px">{{ __('students.actions') }}</th>
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
    @if(auth()->user()->hasPermissionTo(\App\Enums\PermissionEnum::CREATE_STUDENTS->value))
        <!--begin::Modal - Add Users-->
        @include('admin.students.modals.create')
        <!--end::Modal - Add Users-->
    @endif
    @if(auth()->user()->hasPermissionTo(\App\Enums\PermissionEnum::UPDATE_STUDENTS->value))
        <!--begin::Modal - Update user-->
        @include('admin.students.modals.edit')
        <!--end::Modal - Update user-->
    @endif
@endsection
@section('scripts')
    @if(auth()->user()->hasPermissionTo(\App\Enums\PermissionEnum::LIST_STUDENTS->value))
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
                        if (!lastLogin){
                            return;
                        }else {
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
                        ajax: "/students/all",
                        columns: [
                            {
                                data: 'avatar_name',
                                name: 'avatar_name',
                                orderable: false,
                                className: 'text-center'
                            },
                            {
                                data: 'school.name',
                                name: 'school.name',
                                orderable: false,
                                searchable: false,
                                className: 'text-center'
                            },
                            {
                                data: 'grade',
                                name: 'grade',
                                orderable: false,
                                searchable: false,
                                className: 'text-center'
                            },
                            {
                                data: 'birth_date',
                                name: 'birth_date',
                                orderable: false,
                                searchable: false,
                                className: 'text-center'
                            },
                            {
                                data: 'gender',
                                name: 'gender',
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

    @if(auth()->user()->hasPermissionTo(\App\Enums\PermissionEnum::CREATE_STUDENTS->value))
        <script>
            "use strict";

            // Class definition
            var KTUsersAddUser = function () {
                // Shared variables
                const element = document.getElementById('kt_modal_add_user');
                const form = element.querySelector('#kt_modal_add_user_form');
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
                                            message: 'Full name is required'
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
                                'gender': {
                                    validators: {
                                        notEmpty: {
                                            message: 'gender field is required'
                                        }
                                    }
                                },
                                'birth_date': {
                                    validators: {
                                        notEmpty: {
                                            message: 'birth date field is required'
                                        }
                                    }
                                },
                                'grade': {
                                    validators: {
                                        notEmpty: {
                                            message: 'grade field is required'
                                        }
                                    }
                                },
                                'school_id': {
                                    validators: {
                                        notEmpty: {
                                            message: 'school field is required'
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
                        // Initialize Flatpickr for the birth date input
                        if (typeof flatpickr !== 'undefined') {
                            flatpickr("#student_birth_date", {
                                dateFormat: "Y-m-d"
                            });
                        }
                    }
                };
            }();

            // On document ready
            KTUtil.onDOMContentLoaded(function () {
                KTUsersAddUser.init();
            });
        </script>
    @endif

    @if(auth()->user()->hasPermissionTo(\App\Enums\PermissionEnum::UPDATE_STUDENTS->value))
        <script>
            "use strict";

            // Class definition
            var KTUsersUpdateDetails = function () {
                // Shared variables
                const element = document.getElementById('kt_modal_update_details');
                const form = element.querySelector('#kt_modal_update_user_form');
                const modal = new bootstrap.Modal(element);

                // Function to populate the form with user data
                var populateForm = (response) => {
                    form.querySelector('[name="name"]').value = response.user.name || "";
                    form.querySelector('[name="email"]').value = response.user.email || "";
                    form.querySelector('[name="phone_number"]').value = response.user.phone_number || "";
                    form.querySelector('[name="birth_date"]').value = response.birth_date || "";
                    $("#kt_modal_update_user_form").attr("data-user-id", response.id);

                    // Set the selected school and grade in the edit modal
                    let schoolSelect = form.querySelector('[name="school_id"]');
                    if (schoolSelect && response.school_id) {
                        schoolSelect.value = response.school_id;
                    }
                    let gradeSelect = form.querySelector('[name="grade"]');
                    if (gradeSelect && response.grade) {
                        gradeSelect.value = response.grade;
                    }
                    let genderSelect = form.querySelector('[name="gender"]');
                    if (genderSelect && response.gender) {
                        genderSelect.value = response.gender;
                    }

                    // check the user is active or not
                    if (response.user.is_active && response.user.is_active === 1) {
                        form.querySelector('[name="is_active"]').checked = true;
                        form.querySelector('[name="is_active"]').value = 1;
                        form.querySelector('.form-check-label').innerText = "Active";
                    }else {
                        form.querySelector('[name="is_active"]').checked = false;
                        form.querySelector('[name="is_active"]').value = 0;
                        form.querySelector('.form-check-label').innerText = "Inactive";
                    }
                };

                // Fetch user data when modal is opened
                element.addEventListener('show.bs.modal', function (event) {
                    let button = event.relatedTarget;
                    let userId = button.getAttribute('data-user-id');

                    if (userId) {
                        $.ajax({
                            url: `/students/${userId}/edit`,
                            type: "GET",
                            success: function (response) {
                                populateForm(response);
                            },
                            error: function () {
                                console.error("Error fetching user data");
                            }
                        });
                    }
                });

                // Init update user modal
                var initUpdateDetails = () => {
                    // Init form validation
                    var validator = FormValidation.formValidation(
                        form,
                        {
                            fields: {
                                'name': {
                                    validators: {
                                        notEmpty: {
                                            message: 'Full name is required'
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
                                'role': {
                                    validators: {
                                        notEmpty: {
                                            message: 'role field is required'
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

                                    // Get form data and send AJAX request
                                    let formData = new FormData(form);
                                    let userId = $('#kt_modal_update_user_form').data('user-id');
                                    let updateUrl = `/students/${userId}`;
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
                                                text: response.message,
                                                icon: "success",
                                                buttonsStyling: false,
                                                confirmButtonText: "Ok, got it!",
                                                customClass: {
                                                    confirmButton: "btn btn-primary"
                                                }
                                            }).then(function (result) {
                                                if (result.isConfirmed) {
                                                    form.reset();
                                                    modal.hide();
                                                    location.reload();
                                                }
                                            });
                                        },
                                        error: function (xhr) {
                                            submitButton.removeAttribute('data-kt-indicator');
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

                    // Cancel button handler (Shared logic with close button)
                    const cancelButton = element.querySelector('[data-kt-users-modal-action="cancel"]');
                    cancelButton.addEventListener('click', resetAndCloseModal);

                    // Close button handler
                    const closeButton = element.querySelector('[data-kt-users-modal-action="close"]');
                    closeButton.addEventListener('click', resetAndCloseModal);

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
                                form.reset();
                                modal.hide();
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
                    }
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
            });

        </script>
    @endif

    @if(auth()->user()->hasPermissionTo(\App\Enums\PermissionEnum::DELETE_STUDENTS->value))
        <script>
            // handle delete user
            $(document).on("click", '[data-kt-users-table-filter="delete_row"]', function (e) {
                e.preventDefault();

                var userId = $(this).data("user-id");

                Swal.fire({
                    text: "Are you sure you want to delete this student?",
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
                            url: "{{ route('admin.students.destroy', ':id') }}".replace(':id', userId),
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
                                    text: "Failed to delete the student. Try again Later!",
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
