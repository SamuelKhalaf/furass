"use strict";

// Class definition
var KTUsersAddRole = function () {
    // Shared variables
    const element = document.getElementById('kt_modal_add_role');
    const form = element.querySelector('#kt_modal_add_role_form');
    const modal = new bootstrap.Modal(element);

    // Init add schedule modal
    var initAddRole = () => {

        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        var validator = FormValidation.formValidation(
            form,
            {
                fields: {
                    'role_name': {
                        validators: {
                            notEmpty: {
                                message: 'Role name is required'
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

        // Close button handler
        const closeButton = element.querySelector('[data-kt-roles-modal-action="close"]');
        closeButton.addEventListener('click', e => {
            e.preventDefault();

            Swal.fire({
                text: "Are you sure you would like to close?",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Yes, close it!",
                cancelButtonText: "No, return",
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: "btn btn-active-light"
                }
            }).then(function (result) {
                if (result.value) {
                    modal.hide(); // Hide modal
                }
            });
        });

        // Cancel button handler
        const cancelButton = element.querySelector('[data-kt-roles-modal-action="cancel"]');
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
                    form.reset(); // Reset form
                    modal.hide(); // Hide modal
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

         // Submit button handler
         const submitButton = element.querySelector('[data-kt-roles-modal-action="submit"]');
         submitButton.addEventListener('click', function (e) {
             // Prevent default button action
             e.preventDefault();

             // Validate form before submit
             if (validator) {
                 validator.validate().then(function (status) {

                     if (status === 'Valid') {
                         // Show loading indication
                         submitButton.setAttribute('data-kt-indicator', 'on');

                         // Disable button to avoid multiple click
                         submitButton.disabled = true;

                         // Collect form data
                         let roleName = form.querySelector('[name="role_name"]').value;
                         let selectedPermissions = [...form.querySelectorAll('input[name="permissions[]"]:checked')].map(el => el.value);

                         // Send AJAX request using jQuery
                         $.ajax({
                             url: form.getAttribute('action'),
                             method: "POST",
                             data: {
                                 _token: $("meta[name='csrf-token']").attr("content"),
                                 role_name: roleName,
                                 permissions: selectedPermissions
                             },
                             success: function (data) {
                                 submitButton.removeAttribute('data-kt-indicator');
                                 submitButton.disabled = false;

                                 if (data.success) {
                                     Swal.fire({
                                         text: data.message,
                                         icon: "success",
                                         confirmButtonText: "Ok, got it!",
                                         customClass: {
                                             confirmButton: "btn btn-primary"
                                         }
                                     }).then(() => {
                                         modal.hide();
                                         form.reset();
                                         window.location.reload();
                                     });
                                 } else {
                                     Swal.fire({
                                         text: "Error saving role. Please try again.",
                                         icon: "error",
                                         confirmButtonText: "Ok, got it!",
                                         customClass: {
                                             confirmButton: "btn btn-primary"
                                         }
                                     });
                                 }
                             },
                             error: function (xhr, status, error) {
                                 submitButton.removeAttribute('data-kt-indicator');
                                 submitButton.disabled = false;

                                 let errorMessage = "Something went wrong! Please try again later.";

                                 if (xhr.responseJSON && xhr.responseJSON.errors) {
                                     errorMessage = Object.values(xhr.responseJSON.errors).join("\n");
                                 }

                                 Swal.fire({
                                     text: errorMessage,
                                     icon: "error",
                                     confirmButtonText: "Ok, got it!",
                                     customClass: {
                                         confirmButton: "btn btn-primary"
                                     }
                                 });
                             }
                         });
                     } else {
                         // Show popup warning. For more info check the plugin's official documentation: https://sweetalert2.github.io/
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


    }

    // Select all handler
    const handleSelectAll = () =>{
        // Define the parent container (form)
        const form = document.getElementById('kt_modal_add_role_form');

        // Check if the form exists
        if (!form) return;

        form.addEventListener('change', function(e) {
            // Handle the "Select All" checkbox change
            if (e.target && e.target.id === 'kt_roles_select_all') {
                const selectAllChecked = e.target.checked;
                const allCheckboxes = form.querySelectorAll('[type="checkbox"]:not(#kt_roles_select_all)'); // Exclude the "Select All" checkbox

                // Apply the checked state to all checkboxes
                allCheckboxes.forEach(function(checkbox) {
                    checkbox.checked = selectAllChecked;
                });
            }
            // Handle individual checkbox change
            else if (e.target && e.target.type === 'checkbox') {
                const allCheckboxes = form.querySelectorAll('[type="checkbox"]:not(#kt_roles_select_all)');
                const selectAll = form.querySelector('#kt_roles_select_all');

                // Check if all checkboxes are checked
                const allChecked = Array.from(allCheckboxes).every(function(checkbox) {
                    return checkbox.checked;
                });

                // Update the "Select All" checkbox state
                if (selectAll) {
                    selectAll.checked = allChecked;
                }
            }
        });
    }

    return {
        // Public functions
        init: function () {
            initAddRole();
            handleSelectAll();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTUsersAddRole.init();
});
