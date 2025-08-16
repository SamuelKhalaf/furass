@extends('admin.layouts.master')
@section('title', __('Consultant Calendar'))
@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                        {{ __('My Consultations') }}</h1>
                </div>
                <!--end::Page title-->
            </div>
            <!--end::Toolbar container-->
        </div>
        <!--end::Toolbar-->

        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-xxl">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title fw-bold">{{ __('Consultation Schedule') }}</h2>
                    </div>
                    <div class="card-body">
                        <div id="kt_consultant_calendar"></div>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Content-->
    </div>

    @include('admin.calendar.modals.consultant_view')
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('kt_consultant_calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
                },
                noEventsContent: 'No consultations scheduled',
                initialView: 'dayGridMonth',
                editable: false,
                events: {
                    url: '{{ route("admin.consultant.calendar.events") }}',
                    method: 'GET',
                    failure: function() {
                        toastr.error('Failed to load consultation schedule');
                    }
                },
                eventClassNames: function(arg) {
                    return ['fc-event-consultation'];
                },
                eventDidMount: function(info) {
                    info.el.style.borderLeft = '4px solid #3699FF';
                    info.el.style.backgroundColor = 'rgba(54, 153, 255, 0.15)';
                },
                eventClick: function(info) {
                    var event = info.event;
                    var modal = $('#kt_modal_consultant_view_event');

                    // Set modal content
                    modal.find('[data-kt-calendar="student_name"]').text(event.extendedProps.student_name);
                    modal.find('[data-kt-calendar="event_type"]').text(event.extendedProps.type);
                    modal.find('[data-kt-calendar="event_description"]').text(event.extendedProps.description);
                    modal.find('[data-kt-calendar="event_start_date"]').text(event.start.toLocaleString());
                    modal.find('[data-kt-calendar="event_end_date"]').text(event.end.toLocaleString());
                    modal.find('[data-kt-calendar="event_status"]').text(event.extendedProps.status);

                    // Status badge styling
                    var statusBadge = modal.find('[data-kt-calendar="event_status"]');
                    statusBadge.removeClass('badge-light-primary badge-light-danger badge-light-warning');

                    switch(event.extendedProps.status) {
                        case 'pending':
                            statusBadge.addClass('badge-light-warning');
                            break;
                        case 'done':
                            statusBadge.addClass('badge-light-primary');
                            break;
                        case 'cancelled':
                            statusBadge.addClass('badge-light-danger');
                            break;
                    }

                    modal.modal('show');
                }
            });

            calendar.render();
        });
    </script>
@endpush
