@extends('admin.layouts.master')
@section('title', 'Other Entities')
@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Other Entities List</h1>
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
                        <li class="breadcrumb-item text-muted">Other Entities</li>
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
                                       class="form-control form-control-solid w-250px ps-14" placeholder="Search Other Entities"/>
                            </div>
                            <!--end::Search-->
                        </div>
                        <!--begin::Card title-->
                        <!--begin::Card toolbar-->
                        <div class="card-toolbar">
                            <!--begin::Toolbar-->
                            <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                                <!-- No create button for other entities - view/delete only -->
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
                                <th class="w-200px">{{ __('schools.name') }}</th>
                                <th class="w-125px">{{ __('schools.address') }}</th>
                                <th class="w-125px">{{ __('schools.email') }}</th>
                                <th class="w-125px">{{ __('schools.phone') }}</th>
                                <th class="w-125px">Entity Type</th>
                                <th class="w-100px">{{ __('schools.actions') }}</th>
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
                            if (lastLogin.includes('minutes')){
                                timeCount = parseInt(lastLogin.split(' ')[0]);
                                timeFormat = 'minutes';
                            }else if (lastLogin.includes('hours')){
                                timeCount = parseInt(lastLogin.split(' ')[0]);
                                timeFormat = 'hours';
                            }else if (lastLogin.includes('days')){
                                timeCount = parseInt(lastLogin.split(' ')[0]);
                                timeFormat = 'days';
                            }else if (lastLogin.includes('weeks')){
                                timeCount = parseInt(lastLogin.split(' ')[0]);
                                timeFormat = 'weeks';
                            }else if (lastLogin.includes('months')){
                                timeCount = parseInt(lastLogin.split(' ')[0]);
                                timeFormat = 'months';
                            }else if (lastLogin.includes('years')){
                                timeCount = parseInt(lastLogin.split(' ')[0]);
                                timeFormat = 'years';
                            }
                        }

                        // Calculate real date
                        const realDate = moment().subtract(timeCount, timeFormat).format();
                        dateRow[2].setAttribute('data-order', realDate);
                    });

                    // Init datatable --- more info on datatables: https://datatables.net/manual/
                    datatable = $(table).DataTable({
                        dom: '<"top-row d-flex justify-content-between"lB>rt<"bottom-row d-flex justify-content-between"ip>',
                        lengthMenu: [[10, 50, 100, 500, -1], [10, 50, 100, 500, 'All Records']],
                        processing: true,
                        serverSide: true,
                        ajax: "/other-entities/all",
                        columns: [
                            {
                                data: 'name',
                                name: 'name',
                                orderable: false,
                                className: 'text-center'
                            },
                            {
                                data: 'address',
                                name: 'address',
                                orderable: false,
                                searchable: false,
                                className: 'text-center'
                            },
                            {
                                data: 'email',
                                name: 'email',
                                orderable: false,
                                searchable: false,
                                className: 'text-center'
                            },
                            {
                                data: 'phone',
                                name: 'phone',
                                orderable: false,
                                searchable: false,
                                className: 'text-center'
                            },
                            {
                                data: 'entity_type',
                                name: 'entity_type',
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
                        ],
                        buttons: [
                            {
                                extend: 'csv',
                                text: '<i class="fa-solid fa-file-csv"></i> CSV',
                                className: 'btn btn-light-info btn-sm me-1',
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
                                className: 'btn btn-light-success btn-sm me-1',
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
                                className: 'btn btn-light-primary btn-sm me-1',
                                filename: 'other-entities-report',
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
                                        { width: 150 }, // Name
                                        { width: 200 }, // Address
                                        { width: 150 }, // Email
                                        { width: 100 }, // Phone
                                        { width: 100 }  // Entity Type
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
                                }
                            }
                        ]
                    });

                    // Re-init functions on every table re-draw
                    datatable.on('draw', function () {
                        handleSearchDatatable();
                        KTMenu.createInstances();
                    });
                }

                // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
                var handleSearchDatatable = () => {
                    const filterSearch = document.querySelector('[data-kt-user-table-filter="search"]');
                    filterSearch.addEventListener('keyup', function (e) {
                        datatable.search(e.target.value).draw();
                    });
                }

                // Public methods
                return {
                    init: function () {
                        if (!table) {
                            return;
                        }

                        initUserTable();
                        handleSearchDatatable();
                    }
                };
            }();

            // On document ready
            KTUtil.onDOMContentLoaded(function () {
                KTUsersList.init();
            });
        </script>
    @endif

    @if(auth()->user()->hasPermissionTo(\App\Enums\PermissionEnum::DELETE_SCHOOLS->value))
        <script>
            // handle delete other entity
            $(document).on("click", '[data-kt-users-table-filter="delete_row"]', function (e) {
                e.preventDefault();

                var userId = $(this).data("user-id");

                Swal.fire({
                    text: "Are you sure you want to delete this entity?",
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
                            url: "{{ route('admin.schools.destroy', ':id') }}".replace(':id', userId),
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
                                    text: "Failed to delete the entity. Try again Later!",
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