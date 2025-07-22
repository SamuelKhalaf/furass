"use strict";

// Class definition
var KTUsersUpdateDetails = function () {
    // Shared variables
    const element = document.getElementById('kt_modal_update_details');
    const form = element.querySelector('#kt_modal_update_user_form');
    const modal = new bootstrap.Modal(element);

    // Function to populate the form with user data
    var populateForm = (userData) => {
        form.querySelector('[name="name"]').value = userData.name || "";
        form.querySelector('[name="email"]').value = userData.email || "";
        form.querySelector('[name="phone_number"]').value = userData.phone_number || "";
        $("#kt_modal_update_user_form").attr("data-user-id", userData.id);

        // Select the user's roles
        let roleSelect = form.querySelector('[name="role"]');
        if (roleSelect && userData.role) {
            Array.from(roleSelect.options).forEach(option => {
                option.selected = option.value === userData.role;
            });

            // Handle schools selection for Sub Admin
            const schoolsGroup = $('.schools-input-group');
            const schoolsSelect = $('#kt_modal_update_user_schools');
            schoolsSelect.html(''); // Clear all options

            if (userData.all_schools && userData.all_schools.length > 0) {
                // Populate all available schools
                userData.all_schools.forEach(school => {
                    const label = `${school.user.name}`;
                    schoolsSelect.append(new Option(label, school.id, false, false));
                });
            }

            if (userData.role === 'Sub Admin') {
                schoolsGroup.show();
                if (userData.schools && userData.schools.length > 0) {
                    // Preselect the schools assigned to this user
                    const selectedIds = userData.schools.map(school => school.id);
                    schoolsSelect.val(selectedIds).trigger('change');
                }
            } else {
                schoolsGroup.hide();
                $('#kt_modal_update_user_schools').val(null).trigger('change');
            }
        }
        // check the user is active or not
        if (userData.is_active && userData.is_active === 1) {
            form.querySelector('[name="is_active"]').checked = true;
            form.querySelector('[name="is_active"]').value = 1;
            form.querySelector('.form-check-label').innerText = "Active";
        }else {
            form.querySelector('[name="is_active"]').checked = false;
            form.querySelector('[name="is_active"]').value = 0;
            form.querySelector('.form-check-label').innerText = "Inactive";
        }
    };

    var initSchoolsSelect = () => {
        // Initialize Select2 for schools
        const $schoolsSelect = $('#kt_modal_update_user_schools');
        if ($schoolsSelect.data('select2')) return;

        $schoolsSelect.select2({
            placeholder: "Select schools",
            allowClear: false,
        });

        // Handle role change to show/hide schools select
        $('select[name="role"]').on('change', function() {
            const selectedRole = $(this).val();
            const schoolsGroup = $('.schools-input-group');

            if (selectedRole === 'Sub Admin') {
                schoolsGroup.show();
                // Add validation for schools when sub-admin is selected
                if (validator) {
                    validator.addField('schools[]', {
                        validators: {
                            notEmpty: {
                                message: 'At least one school must be selected for sub-admin'
                            }
                        }
                    });
                }
            } else {
                schoolsGroup.hide();
                $('#kt_modal_update_user_schools').val(null).trigger('change');
                // Remove validation for schools when other roles are selected
                if (validator) {
                    validator.removeField('schools[]');
                }
            }
        });
    };

    // Fetch user data when modal is opened
    element.addEventListener('show.bs.modal', function (event) {
        let button = event.relatedTarget;
        let userId = button.getAttribute('data-user-id');

        if (userId) {
            $.ajax({
                url: `/users/${userId}/edit`,
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
                        let updateUrl = `/users/${userId}`;
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
            initSchoolsSelect();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTUsersUpdateDetails.init();
});
