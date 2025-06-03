"use strict";

// Class definition
var KTUsersViewRole = function () {
    // Shared variables
    var datatable;
    var table;

    // Init add schedule modal
    var initViewRole = () => {
        // Set date data order
        const tableRows = table.querySelectorAll('tbody tr');

        tableRows.forEach(row => {
            const dateRow = row.querySelectorAll('td');
            const realDate = moment(dateRow[3].innerHTML, "DD MMM YYYY, LT").format();
            dateRow[3].setAttribute('data-order', realDate);
        });

        var roleId = $('#kt_roles_view_table').data('role-id');

         // Init datatable --- more info on datatables: https://datatables.net/manual/
        datatable = $(table).DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: '/roles/' + roleId + '/users',
                type: 'GET',
            },
            columns: [
                { data: 'name', name: 'name' },
                { data: 'created_at', name: 'created_at' },
                { data: 'actions', name: 'actions' }
            ],
            order: [],
            pageLength: 5,
            lengthChange: false,
            columnDefs: [
                { orderable: false, targets: 0 },
                { orderable: false, targets: 2 }
            ]
        });
    }

    // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
    var handleSearchDatatable = () => {
        const filterSearch = document.querySelector('[data-kt-roles-table-filter="search"]');
        filterSearch.addEventListener('keyup', function (e) {
            datatable.search(e.target.value).draw();
        });
    }

    // Delete user
    var handleDeleteRows = () => {
        // Select all delete buttons
        document.addEventListener('click', function (e) {
            const deleteButton = e.target.closest('[data-kt-roles-table-filter="delete_row"]');

            if (!deleteButton) return;

            e.preventDefault();

            const userId = deleteButton.getAttribute('data-user-id');
            const roleId = deleteButton.getAttribute('data-role-id');
            const parentRow = deleteButton.closest('tr');
            const userName = parentRow.querySelector('td:nth-child(1)').innerText;

            if (!userId || !roleId) {
                console.error("User ID or Role ID missing!");
                return;
            }

            Swal.fire({
                text: `Are you sure you want to remove ${userName} from the role?`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, remove!",
                cancelButtonText: "No, cancel",
                customClass: {
                    confirmButton: "btn fw-bold btn-danger",
                    cancelButton: "btn fw-bold"
                }
            }).then(function (result) {
                if (result.value) {
                    $.ajax({
                        url: `/roles/${roleId}/users/${userId}`,
                        type: "DELETE",
                        data: { _token: $('meta[name="csrf-token"]').attr('content') },
                        success: function (response) {
                            if (response.success) {
                                Swal.fire({
                                    text: `${userName} has been removed from the role!`,
                                    icon: "success",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn fw-bold btn-primary",
                                    }
                                }).then(function () {
                                    // Remove row from DataTable
                                    datatable.row($(parentRow)).remove().draw();
                                });
                            } else {
                                Swal.fire({
                                    text: `Failed to remove ${userName} from the role.`,
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn fw-bold btn-primary",
                                    }
                                });
                            }
                        },
                        error: function () {
                            Swal.fire({
                                text: "Error occurred while processing your request.",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn fw-bold btn-primary",
                                }
                            });
                        }
                    });
                }
            });
        });

    };

    // Init toggle toolbar
    var initToggleToolbar = () => {
        // Toggle selected action toolbar
        // Select all checkboxes
        const checkboxes = table.querySelectorAll('[type="checkbox"]');

        // Select elements
        const deleteSelected = document.querySelector('[data-kt-view-roles-table-select="delete_selected"]');

        // Toggle delete selected toolbar
        checkboxes.forEach(c => {
            // Checkbox on click event
            c.addEventListener('click', function () {
                setTimeout(function () {
                    toggleToolbars();
                }, 50);
            });
        });

        // Deleted selected rows
        deleteSelected.addEventListener('click', function () {
            // SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
            Swal.fire({
                text: "Are you sure you want to delete selected users?",
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
                        text: "You have deleted all selected users!.",
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn fw-bold btn-primary",
                        }
                    }).then(function () {
                        // Remove all selected users
                        checkboxes.forEach(c => {
                            if (c.checked) {
                                datatable.row($(c.closest('tbody tr'))).remove().draw();
                            }
                        });

                        // Remove header checked box
                        const headerCheckbox = table.querySelectorAll('[type="checkbox"]')[0];
                        headerCheckbox.checked = false;
                    }).then(function(){
                        toggleToolbars(); // Detect checked checkboxes
                        initToggleToolbar(); // Re-init toolbar to recalculate checkboxes
                    });
                } else if (result.dismiss === 'cancel') {
                    Swal.fire({
                        text: "Selected users was not deleted.",
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
        // Define variables
        const toolbarBase = document.querySelector('[data-kt-view-roles-table-toolbar="base"]');
        const toolbarSelected = document.querySelector('[data-kt-view-roles-table-toolbar="selected"]');
        const selectedCount = document.querySelector('[data-kt-view-roles-table-select="selected_count"]');

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

    return {
        // Public functions
        init: function () {
            table = document.querySelector('#kt_roles_view_table');

            if (!table) {
                return;
            }

            initViewRole();
            handleSearchDatatable();
            handleDeleteRows();
            initToggleToolbar();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTUsersViewRole.init();
});
