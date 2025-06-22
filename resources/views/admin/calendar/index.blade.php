@php use App\Enums\PermissionEnum; @endphp
@extends('admin.layouts.master')
@section('title', __('calendar.title'))
@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                        Calendar</h1>
                    <!--end::Title-->
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
                    <div class="card-header">
                        <h2 class="card-title fw-bold">Calendar</h2>
                        <div class="card-toolbar">
                            <button class="btn btn-flex btn-primary" data-kt-calendar="add">
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1"
                                              transform="rotate(-90 11.364 20.364)" fill="currentColor"/>
                                        <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor"/>
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                                Add Event
                            </button>
                        </div>
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body">
                        <!--begin::Calendar-->
                        <div id="kt_calendar_app"></div>
                        <!--end::Calendar-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
                <!--begin::Modals-->
                <!--begin::Modal - New Product-->
                <!--end::Modal - New Product-->
                <!--begin::Modal - New Product-->
                <!--end::Modal - New Product-->
                <!--end::Modals-->
            </div>
            <!--end::Content container-->
        </div>
        <!--end::Content-->
    </div>

    @if(auth()->user()->hasAnyPermission([PermissionEnum::CREATE_CONSULTANTS->value,PermissionEnum::UPDATE_CONSULTANTS->value]))
        <!--begin::Modal - Update Calendar-->
        @include('admin.calendar.modals.form')
        <!--end::Modal - Update Calendar-->
    @endif

    <!--begin::Modal - View Calendar-->
    @include('admin.calendar.modals.view')
    <!-- end::Modal  - View Calendar-->

@endsection
@section('scripts')
    <script>
        "use strict";

        // Class definition
        var KTAppCalendar = function () {
            // Shared variables
            // Calendar variables
            var calendar;
            var isEditMode = false;
            var data = {
                id: '',
                eventName: '',
                eventDescription: '',
                eventLocation: '',
                companyName: '',
                startDate: '',
                endDate: '',
                allDay: false,
                eventType: 'trip',
                mediaPath: '',
                documentPath: ''
            };

            // Add event variables
            var eventName;
            var eventDescription;
            var eventLocation;
            var companyName;
            var eventType;
            var startDatepicker;
            var startFlatpickr;
            var endDatepicker;
            var endFlatpickr;
            var startTimepicker;
            var startTimeFlatpickr;
            var endTimepicker
            var endTimeFlatpickr;
            var modal;
            var modalTitle;
            var form;
            var validator;
            var addButton;
            var submitButton;
            var cancelButton;
            var closeButton;

            // View event variables
            var viewEventName;
            var viewAllDay;
            var viewEventDescription;
            var viewEventLocation;
            var viewCompanyName;
            var viewEventType;
            var viewStartDate;
            var viewEndDate;
            var viewModal;
            var viewEditButton;
            var viewDeleteButton;

            // Private functions
            var initCalendarApp = function () {
                // Define variables
                var calendarEl = document.getElementById('kt_calendar_app');
                var todayDate = moment().startOf('day');
                var TODAY = todayDate.format('YYYY-MM-DD');

                // Init calendar --- more info: https://fullcalendar.io/docs/initialize-globals
                calendar = new FullCalendar.Calendar(calendarEl, {
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay'
                    },
                    initialDate: TODAY,
                    navLinks: true,
                    selectable: true,
                    selectMirror: true,

                    // Fetch events from Laravel backend
                    events: function(fetchInfo, successCallback, failureCallback) {
                        fetch('{{ route("admin.calendar.datatable") }}', {
                            method: 'GET',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        })
                            .then(response => response.json())
                            .then(data => {
                                // Transform Laravel data to FullCalendar format
                                const events = data.map(event => ({
                                    id: event.id,
                                    title: event.event_name,
                                    start: event.start_date,
                                    end: event.end_date, // Adjust if you have separate end time
                                    allDay: false, // Adjust based on your needs
                                    extendedProps: {
                                        description: event.description || '',
                                        location: event.location || '',
                                        company_name: event.company_name || '',
                                        event_type: event.event_type || '',
                                        media_path: event.media_path || '',
                                        document_path: event.document_path || ''
                                    },
                                    className: getEventClassName(event.event_type)
                                }));
                                successCallback(events);
                            })
                            .catch(error => {
                                console.error('Error fetching events:', error);
                                failureCallback(error);
                            });
                    },

                    // Select dates action
                    select: function (arg) {
                        formatArgs(arg);
                        handleNewEvent();
                    },

                    // Click event
                    eventClick: function (arg) {
                        formatArgs({
                            id: arg.event.id,
                            title: arg.event.title,
                            description: arg.event.extendedProps.description,
                            location: arg.event.extendedProps.location,
                            company_name: arg.event.extendedProps.company_name,
                            event_type: arg.event.extendedProps.event_type,
                            media_path: arg.event.extendedProps.media_path,
                            document_path: arg.event.extendedProps.document_path,
                            startStr: arg.event.startStr,
                            endStr: arg.event.endStr,
                            allDay: arg.event.allDay
                        });

                        handleViewEvent();
                    },

                    editable: true,
                    dayMaxEvents: true,

                    // Handle changing calendar views
                    datesSet: function () {
                        // do some stuff
                    }
                });

                calendar.render();
            }

            // Get event class name based on event type
            const getEventClassName = (eventType) => {
                switch(eventType) {
                    case 'trip':
                        return 'fc-event-primary';
                    case 'workshop':
                        return 'fc-event-success';
                    default:
                        return 'fc-event-info';
                }
            }

            // Init validator
            const initValidator = () => {
                validator = FormValidation.formValidation(
                    form,
                    {
                        fields: {
                            'calendar_event_name': {
                                validators: {
                                    notEmpty: {
                                        message: 'Event name is required'
                                    }
                                }
                            },
                            'calendar_event_description': {
                                validators: {
                                    notEmpty: {
                                        message: 'Description is required'
                                    }
                                }
                            },
                            'calendar_event_location': {
                                validators: {
                                    notEmpty: {
                                        message: 'Location is required'
                                    }
                                }
                            },
                            'calendar_event_start_date': {
                                validators: {
                                    notEmpty: {
                                        message: 'Event date is required'
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
            }

            // Initialize datepickers
            const initDatepickers = () => {
                startFlatpickr = flatpickr(startDatepicker, {
                    enableTime: true,
                    dateFormat: "Y-m-d H:i",
                    time_24hr: false
                });

                endFlatpickr = flatpickr(endDatepicker, {
                    enableTime: true,
                    dateFormat: "Y-m-d H:i",
                    time_24hr: false
                });
            }

            // Handle add button
            const handleAddButton = () => {
                addButton.addEventListener('click', e => {
                    // Reset form data
                    data = {
                        id: '',
                        eventName: '',
                        eventDescription: '',
                        eventLocation: '',
                        companyName: '',
                        startDate: new Date(),
                        endDate: new Date(),
                        allDay: false,
                        eventType: 'trip',
                        mediaPath: '',
                        documentPath: ''
                    };
                    handleNewEvent();
                });
            }

            // Handle add new event
            const handleNewEvent = () => {
                isEditMode = false;
                modalTitle.innerText = "Add a New Event";
                modal.show();
                data = {
                    id: '',
                    eventName: '',
                    eventDescription: '',
                    eventLocation: '',
                    companyName: '',
                    startDate: new Date(),
                    endDate: new Date(),
                    allDay: false,
                    eventType: '',
                    mediaPath: '',
                    documentPath: ''
                };
                populateForm(data);
            }

            // Handle edit event
            const handleEditEvent = () => {
                isEditMode = true;
                modalTitle.innerText = "Edit Event";
                modal.show();
                populateForm(data);
            }

            // Handle view event
            const handleViewEvent = () => {
                viewModal.show();

                // Populate view data
                viewEventName.innerText = data.eventName;
                viewEventDescription.innerText = data.eventDescription || '--';
                viewEventLocation.innerText = data.eventLocation || '--';
                viewStartDate.innerText = moment(data.startDate).format(' DD MMM, YYYY - h:mm A');
                viewEndDate.innerText = moment(data.endDate).format(' DD MMM, YYYY - h:mm A');
            }

            // Handle delete event
            const handleDeleteEvent = () => {
                viewDeleteButton.addEventListener('click', e => {
                    e.preventDefault();

                    Swal.fire({
                        text: "Are you sure you would like to delete this event?",
                        icon: "warning",
                        showCancelButton: true,
                        buttonsStyling: false,
                        confirmButtonText: "Yes, delete it!",
                        cancelButtonText: "No, return",
                        customClass: {
                            confirmButton: "btn btn-primary",
                            cancelButton: "btn btn-active-light"
                        }
                    }).then(function (result) {
                        if (result.value) {
                            // Delete from Laravel backend
                            $.ajax({
                                url: `{{ route("admin.calendar.destroy", "") }}/${data.id}`,
                                type: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function(result) {
                                    if (result.success) {
                                        calendar.refetchEvents();
                                        viewModal.hide();

                                        Swal.fire({
                                            text: "Event deleted successfully!",
                                            icon: "success",
                                            buttonsStyling: false,
                                            confirmButtonText: "Ok, got it!",
                                            customClass: {
                                                confirmButton: "btn btn-primary"
                                            }
                                        });
                                    } else {
                                        Swal.fire({
                                            text: "Error deleting event.",
                                            icon: "error",
                                            buttonsStyling: false,
                                            confirmButtonText: "Ok, got it!",
                                            customClass: {
                                                confirmButton: "btn btn-primary"
                                            }
                                        });
                                    }
                                },
                                error: function(xhr, status, error) {
                                    console.error('Error:', error);
                                    Swal.fire({
                                        text: "An error occurred while deleting the event.",
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
                });
            }

            // Handle edit button
            const handleEditButton = () => {
                viewEditButton.addEventListener('click', e => {
                    e.preventDefault();
                    viewModal.hide();
                    handleEditEvent();
                });
            }

            // Handle cancel button
            const handleCancelButton = () => {
                cancelButton.addEventListener('click', function (e) {
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
                        }
                    });
                });
            }

            // Handle close button
            const handleCloseButton = () => {
                closeButton.addEventListener('click', function (e) {
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
                        }
                    });
                });
            }

            // Helper functions
            const resetFormValidator = (element) => {
                element.addEventListener('hidden.bs.modal', e => {
                    if (validator) {
                        validator.resetForm(true);
                    }
                });
            }

            // Populate form
            const populateForm = () => {
                eventName.value = data.eventName || '';
                eventDescription.value = data.eventDescription || '';
                eventLocation.value = data.eventLocation || '';
                eventType.value = data.eventType || '';

                if (data.startDate) {
                    startFlatpickr.setDate(data.startDate, true);
                }
                if (data.endDate) {
                    endFlatpickr.setDate(data.endDate, true);
                }
            }

            // Format FullCalendar responses
            const formatArgs = (res) => {
                data.id = res.id || '';
                data.eventName = res.title || '';
                data.eventDescription = res.description || '';
                data.eventLocation = res.location || '';
                data.companyName = res.company_name || '';
                data.eventType = res.event_type || 'trip';
                data.startDate = res.startStr || '';
                data.endDate = res.endStr || res.startStr || '';
                data.allDay = res.allDay || false;
                data.mediaPath = res.media_path || '';
                data.documentPath = res.document_path || '';
            }

            const handleFormSubmit = function(e) {
                e.preventDefault();

                if (validator) {
                    validator.validate().then(function (status) {
                        if (status == 'Valid') {
                            submitButton.setAttribute('data-kt-indicator', 'on');
                            submitButton.disabled = true;

                            // Prepare form data
                            const formattedStartDate = moment(startFlatpickr.selectedDates[0]).format('YYYY-MM-DD HH:mm:ss');
                            const formattedEndDate = moment(endFlatpickr.selectedDates[0]).format('YYYY-MM-DD HH:mm:ss');

                            const formData = new FormData();
                            formData.append('event_name', eventName.value);
                            formData.append('location', eventLocation.value);
                            formData.append('description', eventDescription.value);
                            formData.append('event_type', eventType.value);
                            formData.append('start_date', formattedStartDate);
                            formData.append('end_date', formattedEndDate);

                            const url = isEditMode
                                ? `{{ route("admin.calendar.update", "") }}/${data.id}`
                                : '{{ route("admin.calendar.store") }}';

                            if (isEditMode) {
                                formData.append('_method', 'PUT');
                            }

                            $.ajax({
                                url: url,
                                type: 'POST',
                                data: formData,
                                processData: false,
                                contentType: false,
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                beforeSend: function() {
                                    submitButton.setAttribute('data-kt-indicator', 'on');
                                    submitButton.disabled = true;
                                },
                                success: function(data) {
                                    submitButton.removeAttribute('data-kt-indicator');
                                    submitButton.disabled = false;

                                    if (data.success) {
                                        Swal.fire({
                                            text: isEditMode
                                                ? "Event updated successfully!"
                                                : "New event added to calendar!",
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
                                                calendar.refetchEvents();
                                            }
                                        });
                                    } else {
                                        Swal.fire({
                                            text: data.message || "An error occurred",
                                            icon: "error",
                                            buttonsStyling: false,
                                            confirmButtonText: "Ok, got it!",
                                            customClass: {
                                                confirmButton: "btn btn-primary"
                                            }
                                        });
                                    }
                                },
                                error: function(xhr, status, error) {
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
                                    })
                                }
                            });
                        } else {
                            Swal.fire({
                                text: "Please fix the errors in the form",
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
            };

            return {
                // Public Functions
                init: function () {
                    // Define variables
                    const element = document.getElementById('kt_modal_add_event');
                    form = element.querySelector('#kt_modal_add_event_form');
                    eventName = form.querySelector('[name="calendar_event_name"]');
                    eventDescription = form.querySelector('[name="calendar_event_description"]');
                    eventLocation = form.querySelector('[name="calendar_event_location"]');
                    companyName = form.querySelector('[name="calendar_company_name"]');
                    eventType = form.querySelector('[name="calendar_event_type"]');
                    startDatepicker = form.querySelector('#kt_calendar_datepicker_start_date');
                    endDatepicker = form.querySelector('#kt_calendar_datepicker_end_date');
                    addButton = document.querySelector('[data-kt-calendar="add"]');
                    submitButton = form.querySelector('#kt_modal_add_event_submit');
                    cancelButton = form.querySelector('#kt_modal_add_event_cancel');
                    closeButton = element.querySelector('#kt_modal_add_event_close');
                    modalTitle = form.querySelector('[data-kt-calendar="title"]');
                    modal = new bootstrap.Modal(element);

                    // View event modal
                    const viewElement = document.getElementById('kt_modal_view_event');
                    viewModal = new bootstrap.Modal(viewElement);
                    viewEventName = viewElement.querySelector('[data-kt-calendar="event_name"]');
                    viewEventDescription = viewElement.querySelector('[data-kt-calendar="event_description"]');
                    viewEventLocation = viewElement.querySelector('[data-kt-calendar="event_location"]');
                    viewCompanyName = viewElement.querySelector('[data-kt-calendar="company_name"]');
                    viewEventType = viewElement.querySelector('[data-kt-calendar="event_type"]');
                    viewStartDate = viewElement.querySelector('[data-kt-calendar="event_start_date"]');
                    viewEndDate = viewElement.querySelector('[data-kt-calendar="event_end_date"]');
                    viewEditButton = viewElement.querySelector('#kt_modal_view_event_edit');
                    viewDeleteButton = viewElement.querySelector('#kt_modal_view_event_delete');

                    submitButton.addEventListener('click', handleFormSubmit);

                    initCalendarApp();
                    initValidator();
                    initDatepickers();
                    handleEditButton();
                    handleAddButton();
                    handleDeleteEvent();
                    handleCancelButton();
                    handleCloseButton();
                    resetFormValidator(element);
                }
            };
        }();

        // On document ready
        KTUtil.onDOMContentLoaded(function () {
            KTAppCalendar.init();
        });
    </script>
@endsection
