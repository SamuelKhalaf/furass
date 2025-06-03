"use strict";

// Class definition
var KTUsersPermissionsList = function () {
    // Shared variables
    var datatable;
    var table;

    // Init add schedule modal
    var initPermissionsList = () => {
        // Set date data order
        const tableRows = table.querySelectorAll('tbody tr');

        tableRows.forEach(row => {
            const dateRow = row.querySelectorAll('td');
            const realDate = moment(dateRow[2].innerHTML, 'DD MMM YYYY, hh:mm A').format(); // select date from 2nd column in table
            dateRow[2].setAttribute('data-order', realDate);
        });

         // Init datatable --- more info on datatables: https://datatables.net/manual/
        datatable = $(table).DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "/permissions-data",
            "columns": [
                { data: 'name', name: 'name' },
                { data: 'assigned_roles', name: 'assigned_roles' },
                { data: 'created_at', name: 'created_at'},
                { data: 'actions', name: 'actions' }
            ],
            'order':[],
            'columnDefs': [
                { orderable: false, targets: 1 },
                { orderable: false, targets: 3 }
            ]
        });
    }

    // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
    var handleSearchDatatable = () => {
        const filterSearch = document.querySelector('[data-kt-permissions-table-filter="search"]');
        filterSearch.addEventListener('keyup', function (e) {
            datatable.search(e.target.value).draw();
        });
    }

    // Delete permission
    var handleDeleteRows = () => {
        // Use event delegation for dynamically loaded elements
        $('#kt_permissions_table').on('click', '[data-kt-permissions-table-filter="delete_row"]', function (e) {
            e.preventDefault();

            // Select parent row
            const parent = $(this).closest('tr');
            const permissionId = $(this).data('id'); // Ensure you pass the ID in the button's data-id attribute
            const permissionName = parent.find('td:first').text().trim();

            // SweetAlert2 confirmation
            Swal.fire({
                text: "Are you sure you want to delete " + permissionName + "?",
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
                        url: "/permissions/" + permissionId,
                        type: "DELETE",
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                        },
                        success: function (response) {
                            Swal.fire({
                                text: response.message,
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn fw-bold btn-primary",
                                }
                            }).then(function () {
                                // Remove row from DataTable
                                datatable.row(parent).remove().draw();
                            });
                        },
                        error: function (xhr) {
                            let errorMessage = "Something went wrong! Please try again.";

                            if (xhr.status === 422 && xhr.responseJSON) {
                                errorMessage = xhr.responseJSON.message;

                                if (errorMessage.includes("assigned to one or more roles")) {
                                    errorMessage = "Cannot delete this permission because it is assigned to one or more roles. Remove the assignment first.";
                                }
                            } else if (xhr.status === 403) {
                                errorMessage = "You do not have permission to perform this action.";
                            } else if (xhr.status === 500) {
                                errorMessage = "Internal server error. Please contact support.";
                            }

                            Swal.fire({
                                text: errorMessage,
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn fw-bold btn-primary"
                                }
                            });
                        }
                    });
                }
            });
        });
    };



    return {
        // Public functions
        init: function () {
            table = document.querySelector('#kt_permissions_table');

            if (!table) {
                return;
            }

            initPermissionsList();
            handleSearchDatatable();
            handleDeleteRows();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTUsersPermissionsList.init();
});
