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
            dom: '<"top-row d-flex justify-content-between"lB>rt<"bottom-row d-flex justify-content-between"ip>',
            lengthMenu: [[10, 50, 100, 500, -1], [10, 50, 100, 500, 'All Records']],
            ajax: "/user/all",
            columns: [
                {
                    data: 'name',
                    name: 'name',
                    orderable: false,
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
                    data: 'phone_number',
                    name: 'phone_number',
                    orderable: false,
                    searchable: false,
                    className: 'text-center'
                },
                {
                    data: 'role',
                    name: 'role',
                    orderable: false,
                    searchable: false,
                    className: 'text-center'
                },
                {
                    data: 'created_at',
                    name: 'created_at',
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
                    filename: 'users-report',
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
                            { width: 120 }, // Name
                            { width: 150 }, // Email
                            { width: 100 }, // Phone
                            { width: 100 }, // Role
                            { width: 120 }  // Created At
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
            initExportButtons();
        }
    }
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTUsersList.init();
});
