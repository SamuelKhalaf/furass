@extends('admin.layouts.master')
@section('title', 'Path Points')
@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Path Points</h1>
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
                        <li class="breadcrumb-item text-muted">Path Points</li>
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
                                <input type="text" data-kt-path-points-table-filter="search"
                                       class="form-control form-control-solid w-250px ps-14" placeholder="Search Path Points"/>
                            </div>
                            <!--end::Search-->
                        </div>
                        <!--begin::Card title-->
                        <!--begin::Card toolbar-->
                        <div class="card-toolbar">
                            <!--begin::Toolbar-->
                            <div class="d-flex justify-content-end" data-kt-path-points-table-toolbar="base">
                                @if(auth()->user()->hasPermissionTo(\App\Enums\PermissionEnum::CREATE_PATH_POINTS->value))
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#kt_modal_add_path_point">
                                        <span class="svg-icon svg-icon-2"><i class="fa-solid fa-plus"></i></span>
                                        Add Path Point
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
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_path_points">
                            <!--begin::Table head-->
                            <thead>
                            <!--begin::Table row-->
                            <tr class="text-gray-400 fw-bold fs-7 text-uppercase gs-0 text-center">
                                <th class="w-200px">Title</th>
                                <th class="w-125px">Point Type</th>
                                <th class="w-100px">Grade</th>
                                <th class="w-150px">Assigned To</th>
                                <th class="w-125px">Created At</th>
                                <th class="w-100px">Actions</th>
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
    @if(auth()->user()->hasPermissionTo(\App\Enums\PermissionEnum::CREATE_PATH_POINTS->value))
        <!--begin::Modal - Add Path Point-->
        @include('admin.path_points.modals.create')
        <!--end::Modal - Add Path Point-->
    @endif
    @if(auth()->user()->hasPermissionTo(\App\Enums\PermissionEnum::UPDATE_PATH_POINTS->value))
        <!--begin::Modal - Update Path Point-->
        @include('admin.path_points.modals.edit')
        <!--end::Modal - Update Path Point-->
    @endif
@endsection
@section('scripts')
    @if(auth()->user()->hasPermissionTo(\App\Enums\PermissionEnum::LIST_PATH_POINTS->value))
        <script>
            $('#kt_table_path_points').on('draw.dt', function () {
                KTMenu.createInstances();
            });
            "use strict";

            var KTPathPointsList = function () {
                // Define shared variables
                var table = document.getElementById('kt_table_path_points');
                var datatable;
                var toolbarBase;
                var toolbarSelected;
                var selectedCount;

                // Private functions
                var initPathPointsTable = function () {
                    // Init datatable --- more info on datatables: https://datatables.net/manual/
                    datatable = $(table).DataTable({
                        dom: '<"top-row d-flex justify-content-between"lB>rt<"bottom-row d-flex justify-content-between"ip>',
                        lengthMenu: [[10, 50, 100, 500, -1], [10, 50, 100, 500, 'All Records']],
                        processing: true,
                        serverSide: true,
                        ajax: "{{ route('admin.path_points.data') }}",
                        columns: [
                            {
                                data: 'title_display',
                                name: 'title_display',
                                orderable: false,
                                className: 'text-start'
                            },
                            {
                                data: 'table_name',
                                name: 'table_name',
                                orderable: true,
                                className: 'text-center'
                            },
                            {
                                data: 'grade_display',
                                name: 'grade',
                                orderable: true,
                                className: 'text-center'
                            },
                            {
                                data: 'meta_display',
                                name: 'meta_display',
                                orderable: false,
                                searchable: false,
                                className: 'text-center'
                            },
                            {
                                data: 'created_at',
                                name: 'created_at',
                                orderable: true,
                                className: 'text-center'
                            },
                            {
                                data: 'actions',
                                name: 'actions',
                                orderable: false,
                                searchable: false,
                                className: 'text-center'
                            }
                        ],
                        buttons: [
                            {
                                extend: 'csv',
                                text: '<i class="fa-solid fa-file-csv"></i> CSV',
                                className: 'btn btn-light-info btn-sm me-2',
                                exportOptions: {
                                    columns: ':visible:not(:last-child)', // Exclude actions column
                                    modifier: {
                                        search: 'none'
                                    }
                                }
                            },
                            {
                                extend: 'excel',
                                text: '<i class="fa-solid fa-file-excel"></i> Excel',
                                className: 'btn btn-light-success btn-sm me-2',
                                exportOptions: {
                                    columns: ':visible:not(:last-child)', // Exclude actions column
                                    modifier: {
                                        page: 'all'
                                    }
                                }
                            },
                            {
                                extend: 'pdfHtml5',
                                text: '<i class="fa-solid fa-file-pdf"></i> PDF',
                                className: 'btn btn-light-primary btn-sm',
                                filename: 'path-points-report',
                                orientation: 'landscape',
                                pageSize: 'A4',
                                exportOptions: {
                                    columns: ':visible:not(:last-child)', // Exclude actions column
                                    search: 'applied',
                                    order: 'applied'
                                },
                                customize: function(doc) {
                                    // Page margins and styling
                                    doc.pageMargins = [25, 70, 25, 70];
                                    doc.defaultStyle.fontSize = 10;
                                    doc.styles.tableHeader.fontSize = 12;
                                    doc.styles.title = {
                                        color: 'black',
                                        fontSize: '14',
                                        alignment: 'center'
                                    };

                                    // Calculate column widths for landscape orientation
                                    var totalTableWidth = 842 - 50; // A4 landscape width minus margins
                                    var columns = [
                                        { width: 200 }, // Title
                                        { width: 125 }, // Point Type
                                        { width: 100 }, // Grade
                                        { width: 150 }, // Assigned To
                                        { width: 125 }  // Created At
                                    ];

                                    var tableContent = doc.content[1]?.table;
                                    if (tableContent) {
                                        tableContent.widths = columns.map(col => col.width);
                                    }

                                    // Header styling
                                    doc.styles.tableHeader = {
                                        alignment: 'center',
                                        fillColor: '#dedede',
                                        color: 'black',
                                        bold: true
                                    };

                                    doc.styles.tableBodyEven = {
                                        alignment: 'center',
                                        fontSize: 10,
                                        margin: [0, 5, 0, 5]
                                    };

                                    doc.styles.tableBodyOdd = {
                                        alignment: 'center',
                                        fontSize: 10,
                                        margin: [0, 5, 0, 5]
                                    };

                                    // Footer
                                    doc['footer'] = function(currentPage, pageCount) {
                                        var now = new Date();
                                        var formattedDate = ('0' + now.getDate()).slice(-2) + '-' +
                                            ('0' + (now.getMonth() + 1)).slice(-2) + '-' +
                                            now.getFullYear() + ' ' +
                                            ('0' + now.getHours()).slice(-2) + ':' +
                                            ('0' + now.getMinutes()).slice(-2) + ':' +
                                            ('0' + now.getSeconds()).slice(-2);

                                        return {
                                            columns: [
                                                {
                                                    width: '*',
                                                    text: `Generated at: ${formattedDate}`,
                                                    alignment: 'left',
                                                    fontSize: 8,
                                                    margin: [10, 0]
                                                },
                                                {
                                                    width: '*',
                                                    text: `Page ${currentPage} of ${pageCount}`,
                                                    alignment: 'right',
                                                    fontSize: 8,
                                                    margin: [0, 0, 10, 0]
                                                }
                                            ]
                                        };
                                    };

                                    // Table layout
                                    var objLayout = {};
                                    objLayout['hLineWidth'] = function(i) { return 0.5; };
                                    objLayout['vLineWidth'] = function(i) { return 0.5; };
                                    objLayout['hLineColor'] = function(i) { return '#aaa'; };
                                    objLayout['vLineColor'] = function(i) { return '#aaa'; };
                                    objLayout['paddingLeft'] = function(i) { return 4; };
                                    objLayout['paddingRight'] = function(i) { return 4; };
                                    objLayout['paddingTop'] = function(i) { return 1; };
                                    objLayout['paddingBottom'] = function(i) { return 1; };
                                    doc.content[1].layout = objLayout;

                                    // Style header rows
                                    for (var row = 0; row < doc.content[1].table.headerRows; row++) {
                                        var header = doc.content[1].table.body[row];
                                        for (var col = 0; col < header.length; col++) {
                                            header[col].fillColor = '#dedede';
                                            header[col].color = 'black';
                                            header[col].bold = true;
                                        }
                                    }
                                }
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

                var initExportButtons = function() {
                    // Append buttons container next to the length menu
                    datatable.buttons().container()
                        .addClass('d-inline-block ms-3')
                        .appendTo($('.dataTables_length').parent());
                }

                // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
                var handleSearchDatatable = () => {
                    const filterSearch = document.querySelector('[data-kt-path-points-table-filter="search"]');
                    filterSearch.addEventListener('keyup', function (e) {
                        datatable.search(e.target.value).draw();
                    });
                }

                // Delete path point
                var handleDeleteRows = () => {
                    // Add event listener to the document (event delegation)
                    $(document).on("click", '[data-kt-path-points-table-filter="delete_row"]', function (e) {
                        e.preventDefault();

                        var pathPointId = $(this).data("path-point-id");

                        Swal.fire({
                            text: "Are you sure you want to delete this path point?",
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
                                    url: "{{ route('admin.path_points.destroy', ':id') }}".replace(':id', pathPointId),
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
                                                datatable.ajax.reload();
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
                                            text: "Failed to delete the path point. Try again Later!",
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
                }

                // Init toggle toolbar
                var initToggleToolbar = () => {
                    // Toggle selected action toolbar
                    // Select all checkboxes
                    const checkboxes = table.querySelectorAll('[type="checkbox"]');

                    // Select elements
                    toolbarBase = document.querySelector('[data-kt-path-points-table-toolbar="base"]');
                    toolbarSelected = document.querySelector('[data-kt-path-points-table-toolbar="selected"]');
                    selectedCount = document.querySelector('[data-kt-path-points-table-select="selected_count"]');
                    const deleteSelected = document.querySelector('[data-kt-path-points-table-select="delete_selected"]');

                    // Toggle delete selected toolbar
                    checkboxes.forEach(c => {
                        // Checkbox on click event
                        c.addEventListener('click', function () {
                            setTimeout(function () {
                                toggleToolbars();
                            }, 50);
                        });
                    });
                }

                // Toggle toolbars
                const toggleToolbars = () => {
                    // Select refreshed checkbox DOM elements
                    const allCheckboxes = table.querySelectorAll('tbody [type="checkbox"]');

                    // Detect checkbox state & count
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

                        initPathPointsTable();
                        initToggleToolbar();
                        handleSearchDatatable();
                        handleDeleteRows();
                        initExportButtons();
                    }
                }
            }();

            // On document ready
            KTUtil.onDOMContentLoaded(function () {
                KTPathPointsList.init();
            });

        </script>
    @endif

    @if(auth()->user()->hasPermissionTo(\App\Enums\PermissionEnum::CREATE_PATH_POINTS->value))
        <script>
            "use strict";

            // Class definition
            var KTPathPointsAddPathPoint = function () {
                // Shared variables
                const element = document.getElementById('kt_modal_add_path_point');
                const form = element.querySelector('#kt_modal_add_path_point_form');
                const modal = new bootstrap.Modal(element);

                // Init add path point modal
                var initAddPathPoint = () => {

                    // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
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
                                'table_name': {
                                    validators: {
                                        notEmpty: {
                                            message: 'Table name is required'
                                        }
                                    }
                                },
                                'grade': {
                                    validators: {
                                        notEmpty: {
                                            message: 'Grade is required'
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

                    // Handle table name change to show/hide relevant fields
                    const tableNameSelect = form.querySelector('[name="table_name"]');
                    const eventGroup = form.querySelector('#event_group');
                    const questionBankGroup = form.querySelector('#question_bank_group');

                    tableNameSelect.addEventListener('change', function() {
                        if (this.value === 'events') {
                            eventGroup.style.display = 'block';
                            questionBankGroup.style.display = 'none';
                        } else if (this.value === 'evaluation_tests') {
                            eventGroup.style.display = 'none';
                            questionBankGroup.style.display = 'block';
                        } else {
                            eventGroup.style.display = 'none';
                            questionBankGroup.style.display = 'none';
                        }
                    });

                    // Submit button handler
                    const submitButton = element.querySelector('[data-kt-path-points-modal-action="submit"]');
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
                                        url: "{{ route('admin.path_points.store') }}",
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
                                                    $('#kt_table_path_points').DataTable().ajax.reload();
                                                    // Reset conditional fields
                                                    eventGroup.style.display = 'none';
                                                    questionBankGroup.style.display = 'none';
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
                    const cancelButton = element.querySelector('[data-kt-path-points-modal-action="cancel"]');
                    cancelButton.addEventListener('click', e => {
                        e.preventDefault();
                        resetAndCloseModal();
                    });

                    // Close button handler
                    const closeButton = element.querySelector('[data-kt-path-points-modal-action="close"]');
                    closeButton.addEventListener('click', e => {
                        e.preventDefault();
                        resetAndCloseModal();
                    });

                    function resetAndCloseModal() {
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
                                eventGroup.style.display = 'none';
                                questionBankGroup.style.display = 'none';
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
                        initAddPathPoint();
                    }
                };
            }();

            // On document ready
            KTUtil.onDOMContentLoaded(function () {
                KTPathPointsAddPathPoint.init();
            });
        </script>
    @endif

    @if(auth()->user()->hasPermissionTo(\App\Enums\PermissionEnum::UPDATE_PATH_POINTS->value))
        <script>
            "use strict";

            // Class definition
            var KTPathPointsUpdateDetails = function () {
                // Shared variables
                const element = document.getElementById('kt_modal_update_path_point');
                const form = element.querySelector('#kt_modal_update_path_point_form');
                const modal = new bootstrap.Modal(element);

                // Function to populate the form with path point data
                var populateForm = (response) => {
                    form.querySelector('[name="title_ar"]').value = response.title_ar || "";
                    form.querySelector('[name="title_en"]').value = response.title_en || "";
                    form.querySelector('[name="table_name"]').value = response.table_name || "";
                    form.querySelector('[name="grade"]').value = response.grade || "";
                    $("#kt_modal_update_path_point_form").attr("data-path-point-id", response.id);

                    // Handle conditional fields based on table_name
                    const eventGroup = form.querySelector('#event_group_edit');
                    const questionBankGroup = form.querySelector('#question_bank_group_edit');

                    if (response.table_name === 'events') {
                        eventGroup.style.display = 'block';
                        questionBankGroup.style.display = 'none';
                        if (response.event_id) {
                            form.querySelector('[name="event_id"]').value = response.event_id;
                        }
                    } else if (response.table_name === 'evaluation_tests') {
                        eventGroup.style.display = 'none';
                        questionBankGroup.style.display = 'block';
                        if (response.question_bank_type_id) {
                            form.querySelector('[name="question_bank_type_id"]').value = response.question_bank_type_id;
                        }
                    } else {
                        eventGroup.style.display = 'none';
                        questionBankGroup.style.display = 'none';
                    }
                };

                // Fetch path point data when modal is opened
                element.addEventListener('show.bs.modal', function (event) {
                    let button = event.relatedTarget;
                    let pathPointId = button.getAttribute('data-path-point-id');

                    if (pathPointId) {
                        $.ajax({
                            url: "{{ route('admin.path_points.edit', ':id') }}".replace(':id', pathPointId),
                            type: "GET",
                            success: function (response) {
                                populateForm(response);
                            },
                            error: function () {
                                console.error("Error fetching path point data");
                            }
                        });
                    }
                });

                // Init update path point modal
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
                                'table_name': {
                                    validators: {
                                        notEmpty: {
                                            message: 'Table name is required'
                                        }
                                    }
                                },
                                'grade': {
                                    validators: {
                                        notEmpty: {
                                            message: 'Grade is required'
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

                    // Handle table name change to show/hide relevant fields
                    const tableNameSelect = form.querySelector('[name="table_name"]');
                    const eventGroup = form.querySelector('#event_group_edit');
                    const questionBankGroup = form.querySelector('#question_bank_group_edit');

                    tableNameSelect.addEventListener('change', function() {
                        if (this.value === 'events') {
                            eventGroup.style.display = 'block';
                            questionBankGroup.style.display = 'none';
                        } else if (this.value === 'evaluation_tests') {
                            eventGroup.style.display = 'none';
                            questionBankGroup.style.display = 'block';
                        } else {
                            eventGroup.style.display = 'none';
                            questionBankGroup.style.display = 'none';
                        }
                    });

                    // Submit button handler
                    const submitButton = element.querySelector('[data-kt-path-points-modal-action="submit"]');
                    submitButton.addEventListener('click', e => {
                        e.preventDefault();

                        if (validator) {
                            validator.validate().then(function (status) {
                                if (status === 'Valid') {
                                    submitButton.setAttribute('data-kt-indicator', 'on');
                                    submitButton.disabled = true;

                                    // Get form data and send AJAX request
                                    let formData = new FormData(form);
                                    let pathPointId = $('#kt_modal_update_path_point_form').data('path-point-id');
                                    let updateUrl = "{{ route('admin.path_points.update', ':id') }}".replace(':id', pathPointId);

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
                                                    $('#kt_table_path_points').DataTable().ajax.reload();
                                                    // Reset conditional fields
                                                    eventGroup.style.display = 'none';
                                                    questionBankGroup.style.display = 'none';
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
                    const cancelButton = element.querySelector('[data-kt-path-points-modal-action="cancel"]');
                    cancelButton.addEventListener('click', resetAndCloseModal);

                    // Close button handler
                    const closeButton = element.querySelector('[data-kt-path-points-modal-action="close"]');
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
                                // Reset conditional fields
                                eventGroup.style.display = 'none';
                                questionBankGroup.style.display = 'none';
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
                KTPathPointsUpdateDetails.init();
            });

        </script>
    @endif

    @if(auth()->user()->hasPermissionTo(\App\Enums\PermissionEnum::DELETE_PATH_POINTS->value))
        <script>
            // handle delete path point
            $(document).on("click", '[data-kt-path-points-table-filter="delete_row"]', function (e) {
                e.preventDefault();

                var pathPointId = $(this).data("path-point-id");

                Swal.fire({
                    text: "Are you sure you want to delete this path point?",
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
                            url: "{{ route('admin.path_points.destroy', ':id') }}".replace(':id', pathPointId),
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
                                        $('#kt_table_path_points').DataTable().ajax.reload();
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
                                    text: "Failed to delete the path point. Try again Later!",
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
