@extends('admin.layouts.master')
@section('title',  __('admin.questionBank.title_h'))
@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">{{ __('admin.questionBank.list') }}</h1>
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
                        <li class="breadcrumb-item text-muted">{{ __('admin.questionBank.title') }}</li>
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
                                       class="form-control form-control-solid w-250px ps-14" placeholder="{{ __('admin.questionBank.search') }}"/>
                            </div>
                            <!--end::Search-->
                        </div>
                        <!--begin::Card title-->
                        <!--begin::Card toolbar-->
                        <div class="card-toolbar">
                            <!--begin::Toolbar-->
                            <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                                @if(auth()->user()->hasPermissionTo(\App\Enums\PermissionEnum::CREATE_USERS->value))
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#kt_modal_add_school">
                                        <span class="svg-icon svg-icon-2"><i class="fa-solid fa-plus"></i></span>
                                        {{ __('admin.questionBank.create') }}
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
                                <th class="min-w-200px text-end "> الاسم</th>
                                <th class="min-w-200px text-end ">name</th>
                                <th class="min-w-100px text-end "> {{ __('admin.questionBank.action') }}</th>
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
    @if(auth()->user()->hasPermissionTo(\App\Enums\PermissionEnum::CREATE_SCHOOLS->value))
        <!--begin::Modal - Add Users-->
        @include('admin.question_bank_type.modals.create')
        <!--end::Modal - Add Users-->
    @endif
    @if(auth()->user()->hasPermissionTo(\App\Enums\PermissionEnum::UPDATE_SCHOOLS->value))
        <!--begin::Modal - Update user-->
        @include('admin.question_bank_type.modals.edit')
        <!--end::Modal - Update user-->
    @endif
    @if(auth()->user()->hasPermissionTo(\App\Enums\PermissionEnum::UPDATE_SCHOOLS->value))
        <!--begin::Modal - Update user-->
        @include('admin.question_bank_type.modals.add_question')
        <!--end::Modal - Update user-->
    @endif
@endsection
@section('scripts')
    @if(auth()->user()->hasPermissionTo(\App\Enums\PermissionEnum::LIST_SCHOOLS->value))
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
                        ajax: "/question-bank/all",
                        columns: [
                            {
                                data: 'name_ar',
                                name: 'name_ar',
                                orderable: false,
                                searchable: false,
                                className: 'text-center'
                            },
                            {
                                data: 'name_en',
                                name: 'name_en',
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

    @if(auth()->user()->hasPermissionTo(\App\Enums\PermissionEnum::CREATE_EXAMS->value))
        <script>
            "use strict";

            // Class definition
            var KTUsersAddUser = function () {
                // Shared variables
                const element = document.getElementById('kt_modal_add_school');
                const form = element.querySelector('#kt_modal_add_school_form');
                const modal = new bootstrap.Modal(element);

                // Init add schedule modal
                var initAddUser = () => {

                    // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
                    var validator = FormValidation.formValidation(
                        form,
                        {
                            fields: {
                                'name_ar': {
                                    validators: {
                                        notEmpty: {
                                            message: 'Arabic name is required'
                                        }
                                    }
                                },
                                'name_en': {
                                    validators: {
                                        notEmpty: {
                                            message: 'English name is required'
                                        }
                                    }
                                },
                                'value_id[]': {
                                    validators: {
                                        notEmpty: {
                                            message: 'At least one value must be selected'
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

    @if(auth()->user()->hasPermissionTo(\App\Enums\PermissionEnum::UPDATE_EXAMS->value))
        <script>
            "use strict";

            // Class definition
            var KTUsersUpdateDetails = function () {
                // Shared variables
                const element = document.getElementById('kt_modal_update_school');
                const form = element.querySelector('#kt_modal_update_school_form');
                const currentLocale = "{{ app()->getLocale() }}";
                const modal = new bootstrap.Modal(element);
                // Function to populate the form with user data
                var populateForm = (response) => {
                    form.querySelector('[name="name_ar"]').value = response.question_bank.name.ar || "";
                    form.querySelector('[name="name_en"]').value = response.question_bank.name.en || "";
                    $("#kt_modal_update_school_form").attr("data-user-id", response.question_bank.id);

                    const percentagesContainer = document.getElementById('percentages-container-update');
                    percentagesContainer.innerHTML = '';
                    response.bank_values.forEach(option => {
                        const div = document.createElement('div');
                        div.classList.add('form-group', 'mb-2');

                        const valueName = JSON.parse(option.value_name);
                        div.innerHTML = `
                            <label class="required fw-semibold fs-6 mb-2">
                                ${valueName[currentLocale]} Percentage
                            </label>
                            <input type="text"
                                   name="percentages[${option.value_id}]"
                                   value="${option.percentage}"
                                   class="form-control form-control-solid mb-3 mb-lg-0"
                                   placeholder="Enter percentage for ${valueName[currentLocale]}">
                        `;
                        percentagesContainer.appendChild(div);
                    });

                    /*select new values*/
                    const select_values_update = document.getElementById('list_value_update');
                    const values = response.new_values;

                    select_values_update.innerHTML = ''; // clear old options

                    const placeholder = document.createElement('option');
                    select_values_update.appendChild(placeholder);
                    values.forEach(function (value) {
                        const option = document.createElement('option');
                        option.value = value.id;
                        option.textContent = value.name[currentLocale];

                        select_values_update.appendChild(option);
                    });


                    //new values percentage
                    const percentagesContainerNew = document.getElementById('percentages-container-new');
                    const valueSelect = document.getElementById('list_value_update');


                    // Add a percentage input for each selected option
                    valueSelect.addEventListener('change', function () {
                        percentagesContainerNew.innerHTML = '';
                        const selectedOptions = Array.from(valueSelect.selectedOptions).map(opt => ({
                            id: opt.value,
                            text: opt.text
                        }));

                        selectedOptions.forEach(option => {
                            const div = document.createElement('div');
                            div.classList.add('form-group', 'mb-2');
                            div.innerHTML = `
                            <label class="required fw-semibold fs-6 mb-2">${option.text} Percentage</label>
                            <input type="text" name="percentages[${option.id}]" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Enter percentage for ${option.text}">
                              `;
                            percentagesContainerNew.appendChild(div);
                        });

                        // Add to validator
                        validator.addField(`percentages[${option.id}]`, {
                            validators: {
                                notEmpty: {
                                    message: 'Percentage is required'
                                },
                                numeric: {
                                    message: 'Percentage must be a number'
                                },
                                between: {
                                    min: 0,
                                    max: 100,
                                    message: 'Percentage must be between 0 and 100'
                                }
                            }
                        });

                    });

                    validator.getFields().forEach(field => {
                        if (field.startsWith('percentages[')) {
                            const fieldId = field.match(/percentages\[(\d+)\]/)[1];
                            if (!selectedOptions.some(opt => opt.id === fieldId)) {
                                validator.removeField(field);
                            }
                        }
                    });
                };

                // Fetch user data when modal is opened
                element.addEventListener('show.bs.modal', function (event) {
                    let button = event.relatedTarget;
                    let questionBank = button.getAttribute('data-user-id');

                    if (questionBank) {
                        $.ajax({
                            url: `questionBank/${questionBank}/edit`,
                            type: "GET",
                            success: function (response) {
                                console.log(response.new_values)
                                populateForm(response);
                            },
                            error: function () {
                                console.error("Error fetching school data");
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
                                'name_ar': {
                                    validators: {
                                        notEmpty: {
                                            message: 'Full name_ar is required'
                                        }
                                    }
                                },

                                'name_en': {
                                    validators: {
                                        notEmpty: {
                                            message: 'Full name_en is required'
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

                                    // Get form data and send AJAX request
                                    let formData = new FormData(form);
                                    let userId = $('#kt_modal_update_school_form').data('user-id');
                                    let updateUrl = `/questionBank/${userId}`;
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

    @if(auth()->user()->hasPermissionTo(\App\Enums\PermissionEnum::UPDATE_EXAMS->value))
        <script>
            "use strict";

            // Class definition
            var KTUAddQuestion = function () {
                // Shared variables
                const element = document.getElementById('kt_crud_question');
                const form = element.querySelector('#kt_crud_question_form');
                const currentLocale = "{{ app()->getLocale() }}";
                const modal = new bootstrap.Modal(element);



                // Function to populate the form with user data
                var populateForm = (response) => {
                    /*select new values*/
                    const related_value = document.getElementById('related_value_id');
                    const values = response.related_bank_values;

                    related_value.innerHTML = ''; // clear old options

                    const placeholder = document.createElement('option');
                    placeholder.value = "";
                    placeholder.textContent = 'select value'
                    related_value.appendChild(placeholder);
                    values.forEach(function (value) {
                        const option = document.createElement('option');
                        option.value = value.value_id;
                        const localizedName = JSON.parse(value.value_name);
                        option.textContent = localizedName[currentLocale] || '';

                        related_value.appendChild(option);
                    });

                };

                // Fetch user data when modal is opened
                element.addEventListener('show.bs.modal', function (event) {
                    let button = event.relatedTarget;
                    let questionBank = button.getAttribute('data-user-id');

                    if (questionBank) {
                        $.ajax({
                            url: `related-bank-values/${questionBank}`,
                            type: "GET",
                            success: function (response) {
                                console.log(response)
                                populateForm(response);
                            },
                            error: function () {
                                console.error("Error fetching school data");
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
                                'questions[][ar]': {
                                    selector: 'input[name^="questions"][name$="[ar]"]',
                                    validators: {
                                        notEmpty: {
                                            message: 'Arabic question is required'
                                        }
                                    }
                                },
                                'questions[][en]': {
                                    selector: 'input[name^="questions"][name$="[en]"]',
                                    validators: {
                                        notEmpty: {
                                            message: 'English question is required'
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

                                    // Get form data and send AJAX request
                                    let formData = new FormData(form);
                                    let userId = $('#kt_crud_question_form').data('user-id');
                                    let updateUrl = `/add-question-store/${userId}`;
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
                KTUAddQuestion.init();
            });

        </script>
    @endif

    @if(auth()->user()->hasPermissionTo(\App\Enums\PermissionEnum::DELETE_EXAMS->value))
        <script>
            // handle delete user
            $(document).on("click", '[data-kt-users-table-filter="delete_row"]', function (e) {
                e.preventDefault();

                var userId = $(this).data("user-id");

                Swal.fire({
                    text: "Are you sure you want to delete this Question Bank?",
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
                            url: "{{ route('admin.questionBank.destroy', ':id') }}".replace(':id', userId),
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
                                    text: "This Question Bank has questions that cannot be deleted",
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
