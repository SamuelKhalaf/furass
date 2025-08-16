@extends('admin.layouts.master')
@section('title', __('Calendar'))
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
                        {{ __('My Calendar') }}</h1>
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
                        <h2 class="card-title fw-bold">{{ __('My Schedule') }}</h2>
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
            </div>
            <!--end::Content container-->
        </div>
        <!--end::Content-->
    </div>
    <!--begin::Modal - View Calendar-->
    @include('admin.calendar.modals.student_view')
    <!-- end::Modal  - View Calendar-->
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('kt_calendar_app');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
                },
                noEventsContent: 'No events to display',
                initialView: 'dayGridMonth',
                editable: false,
                multiMonthMaxColumns: 1,
                showNonCurrentDates: false,
                fixedWeekCount: false,
                events: {
                    url: '{{ route("admin.student.calendar.events") }}',
                    method: 'GET',
                    failure: function() {
                        toastr.error('Failed to load calendar events');
                    }
                },
                eventClassNames: function(arg) {
                    return ['fc-event-' + arg.event.extendedProps.type];
                },
                eventDidMount: function(info) {
                    // Add custom styling to events
                    info.el.style.borderLeft = '4px solid';
                    info.el.style.borderLeftColor = info.event.backgroundColor;
                    info.el.style.backgroundColor = info.event.backgroundColor + '33'; // Add opacity
                    info.el.style.color = '#181C32'; // Dark text for better readability
                },
                eventClick: function(info) {
                    var event = info.event;
                    var modal = $('#kt_modal_view_event');

                    // Set event type badge with appropriate styling
                    var typeBadge = modal.find('[data-kt-calendar="event_type"]');

                    typeBadge.text(event.extendedProps.type.charAt(0).toUpperCase() + event.extendedProps.type.slice(1));
                    // Set badge color based on an event type
                    switch(event.extendedProps.type) {
                        case 'consultation':
                            typeBadge.removeClass('badge-light-danger badge-light-warning')
                                .addClass('badge-light-primary');
                            break;
                        case 'trip':
                            typeBadge.removeClass('badge-light-primary badge-light-warning')
                                .addClass('badge-light-danger');
                            break;
                        case 'workshop':
                            typeBadge.removeClass('badge-light-primary badge-light-danger')
                                .addClass('badge-light-warning');
                            break;
                    }

                    // Set other event details
                    modal.find('[data-kt-calendar="event_name"]').text(event.title);
                    // Set modal content
                    modal.find('[data-kt-calendar="event_name"]').text(event.title);
                    modal.find('[data-kt-calendar="event_description"]').text(event.extendedProps.description || 'No description available');
                    modal.find('[data-kt-calendar="event_start_date"]').text(event.start ? event.start.toLocaleString() : 'N/A');
                    modal.find('[data-kt-calendar="event_end_date"]').text(event.end ? event.end.toLocaleString() : 'N/A');
                    modal.find('[data-kt-calendar="event_location"]').text(event.extendedProps.location || 'No location specified');

                    // Show modal
                    modal.modal('show');

                    // Set up edit button if needed
                    modal.find('#kt_modal_view_event_edit').off('click').on('click', function() {
                        // Handle edit functionality here
                    });

                    // Set up delete button if needed
                    modal.find('#kt_modal_view_event_delete').off('click').on('click', function() {
                        // Handle delete functionality here
                    });
                }
            });

            calendar.render();
        });
    </script>
@endpush

@push('styles')
    <style>
        /* Event styling */
        .fc-event {
            border-left: 4px solid !important;
            border-radius: 4px !important;
            padding: 4px 8px !important;
            margin: 2px 0 !important;
        }

        /* Consultation events */
        .fc-event-consultation {
            background-color: rgba(54, 153, 255, 0.15) !important;
            border-left-color: #3699FF !important;
        }

        /* Trip events */
        .fc-event-trip {
            background-color: rgba(246, 78, 96, 0.15) !important;
            border-left-color: #F64E60 !important;
        }

        /* Workshop events */
        .fc-event-workshop {
            background-color: rgba(255, 168, 0, 0.15) !important;
            border-left-color: #FFA800 !important;
        }

        /* Time display */
        .fc-event-time {
            font-weight: bold;
            margin-right: 5px;
        }

        /* Hover effects */
        .fc-event:hover {
            opacity: 0.9;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        /* Event type badge styling */
        [data-kt-calendar="event_type"] {
            font-size: 0.9rem;
            padding: 0.35rem 0.75rem;
            text-transform: capitalize;
        }

        /* Color variants */
        .badge-light-primary {
            background-color: rgba(54, 153, 255, 0.1);
            color: #3699FF;
        }
        .badge-light-danger {
            background-color: rgba(246, 78, 96, 0.1);
            color: #F64E60;
        }
        .badge-light-warning {
            background-color: rgba(255, 168, 0, 0.1);
            color: #FFA800;
        }
    </style>
@endpush
