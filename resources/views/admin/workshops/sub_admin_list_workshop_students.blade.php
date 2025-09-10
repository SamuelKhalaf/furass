@extends('admin.layouts.master')
@section('title', __('workshops.management.workshop_students_list'))
@section('content')
    <!--begin::Content wrapper-->
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                        {{ __('workshops.management.workshop_students_list') }}
                    </h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">{{ __('Dashboard') }}</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.sub-admin.workshops.index') }}" class="text-muted text-hover-primary">{{ __('workshops.management.manage_workshops') }}</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">{{ $event->event_name }}</li>
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
                <!--begin::Actions-->
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <a href="{{ route('admin.sub-admin.volunteer-hours.add', [$program->id, $pathPoint->id]) }}" class="btn btn-sm btn-success">
                        <i class="fa-solid fa-clock me-1"></i>{{ __('workshops.management.add_volunteer_hours') }}
                    </a>
                    <a href="{{ route('admin.sub-admin.workshop.attendance', [$program->id, $pathPoint->id]) }}" class="btn btn-sm btn-primary">
                        <i class="fa-solid fa-user-check me-1"></i>{{ __('workshops.management.manage_attendance') }}
                    </a>
                </div>
                <!--end::Actions-->
            </div>
            <!--end::Toolbar container-->
        </div>
        <!--end::Toolbar-->

        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-fluid">
                <!--begin::Row-->
                <div class="row g-5 g-xl-8">
                    <!--begin::Col-->
                    <div class="col-xl-4">
                        <!--begin::Workshop Details Card-->
                        <div class="card card-flush h-md-100">
                            <!--begin::Card header-->
                            <div class="card-header">
                                <!--begin::Card title-->
                                <div class="card-title">
                                    <h3 class="fw-bold text-dark">{{ __('workshops.management.workshop_details') }}</h3>
                                </div>
                                <!--end::Card title-->
                            </div>
                            <!--end::Card header-->

                            <!--begin::Card body-->
                            <div class="card-body pt-0">
                                <!--begin::Workshop Info-->
                                <div class="d-flex flex-stack mb-4">
                                    <span class="text-gray-700 fw-bold fs-6">{{ __('workshops.management.workshop_name') }}</span>
                                    <span class="text-gray-800 fw-bolder fs-6">{{ $event->event_name }}</span>
                                </div>

                                <div class="d-flex flex-stack mb-4">
                                    <span class="text-gray-700 fw-bold fs-6">{{ __('workshops.management.company_organization') }}</span>
                                    <span class="text-gray-800 fw-bolder fs-6">{{ $event->company_name }}</span>
                                </div>

                                <div class="d-flex flex-stack mb-4">
                                    <span class="text-gray-700 fw-bold fs-6">{{ __('workshops.management.location') }}</span>
                                    <span class="text-gray-800 fw-bolder fs-6">{{ $event->location }}</span>
                                </div>

                                <div class="d-flex flex-stack mb-4">
                                    <span class="text-gray-700 fw-bold fs-6">{{ __('workshops.management.date') }}</span>
                                    <span class="text-gray-800 fw-bolder fs-6">{{ \Carbon\Carbon::parse($event->start_date)->format('M d, Y') }}</span>
                                </div>

                                <div class="d-flex flex-stack mb-4">
                                    <span class="text-gray-700 fw-bold fs-6">{{ __('workshops.management.time') }}</span>
                                    <span class="text-gray-800 fw-bolder fs-6">
                                        {{ \Carbon\Carbon::parse($event->start_date)->format('h:i A') }} -
                                        {{ \Carbon\Carbon::parse($event->end_date)->format('h:i A') }}
                                    </span>
                                </div>

                                <div class="d-flex flex-stack mb-4">
                                    <span class="text-gray-700 fw-bold fs-6">{{ __('workshops.management.total_students') }}</span>
                                    <span class="text-gray-800 fw-bolder fs-6">{{ $students->count() }}</span>
                                </div>

                                <!--begin::Statistics-->
                                <div class="separator separator-dashed my-5"></div>

                                @php
                                    $attendedCount = $students->filter(function($student) {
                                        return $student->tripAttendances->where('status', 'attended')->count() > 0;
                                    })->count();

                                    $absentCount = $students->filter(function($student) {
                                        return $student->tripAttendances->where('status', 'absent')->count() > 0;
                                    })->count();

                                    $evaluatedCount = $students->filter(function($student) {
                                        return $student->tripEvaluations->count() > 0;
                                    })->count();
                                @endphp

                                <div class="d-flex flex-stack mb-4">
                                    <div class="d-flex align-items-center me-2">
                                        <div class="symbol symbol-30px me-3">
                                            <div class="symbol-label bg-light-success">
                                                <i class="fa-solid fa-user-check text-success fs-5"></i>
                                            </div>
                                        </div>
                                        <span class="text-gray-700 fw-bold fs-6">{{ __('workshops.management.attended') }}</span>
                                    </div>
                                    <span class="text-gray-800 fw-bolder fs-6">{{ $attendedCount }}</span>
                                </div>

                                <div class="d-flex flex-stack mb-4">
                                    <div class="d-flex align-items-center me-2">
                                        <div class="symbol symbol-30px me-3">
                                            <div class="symbol-label bg-light-danger">
                                                <i class="fa-solid fa-user-times text-danger fs-5"></i>
                                            </div>
                                        </div>
                                        <span class="text-gray-700 fw-bold fs-6">{{ __('workshops.management.absent') }}</span>
                                    </div>
                                    <span class="text-gray-800 fw-bolder fs-6">{{ $absentCount }}</span>
                                </div>

                                <div class="d-flex flex-stack mb-4">
                                    <div class="d-flex align-items-center me-2">
                                        <div class="symbol symbol-30px me-3">
                                            <div class="symbol-label bg-light-warning">
                                                <i class="fa-solid fa-star text-warning fs-5"></i>
                                            </div>
                                        </div>
                                        <span class="text-gray-700 fw-bold fs-6">{{ __('workshops.management.evaluated') }}</span>
                                    </div>
                                    <span class="text-gray-800 fw-bolder fs-6">{{ $evaluatedCount }}</span>
                                </div>
                                <!--end::Statistics-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Workshop Details Card-->
                    </div>
                    <!--end::Col-->

                    <!--begin::Col-->
                    <div class="col-xl-8">
                        <!--begin::Students List Card-->
                        <div class="card card-flush h-md-100">
                            <!--begin::Card header-->
                            <div class="card-header">
                                <!--begin::Card title-->
                                <div class="card-title">
                                    <h3 class="fw-bold text-dark">{{ __('workshops.management.students_list') }}</h3>
                                </div>
                                <!--end::Card title-->
                                <!--begin::Card toolbar-->
                                <div class="card-toolbar">
                                    <div class="d-flex align-items-center position-relative me-4">
                                        <span class="svg-icon svg-icon-1 position-absolute ms-4">
                                            <i class="fas fa-search"></i>
                                        </span>
                                        <input type="text" class="form-control form-control-solid w-250px ps-12"
                                               placeholder="{{ __('workshops.management.search_students') }}"
                                               id="workshop-students-search"/>
                                    </div>
                                    <!-- Export buttons will be inserted here by DataTables -->
                                </div>
                                <!--end::Card toolbar-->
                            </div>
                            <!--end::Card header-->

                            <!--begin::Card body-->
                            <div class="card-body pt-0">
                                <!--begin::Table-->
                                <div class="table-responsive">
                                    <table class="table table-striped table-row-bordered gy-5 gs-7" id="workshop-students-table">                                        <thead>
                                        <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                            <th class="min-w-200px">{{ __('workshops.management.student_name') }}</th>
                                            <th class="min-w-150px">{{ __('workshops.management.school') }}</th>
                                            <th class="min-w-100px">{{ __('workshops.management.attendance') }}</th>
                                            <th class="min-w-100px">{{ __('workshops.management.evaluation') }}</th>
{{--                                            <th class="min-w-100px">{{ __('Certificate') }}</th>--}}
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($students as $student)
                                            @php
                                                $attendance = $student->tripAttendances->first();
                                                $evaluation = $student->tripEvaluations->first();
                                            @endphp
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="symbol symbol-50px me-3">
                                                            <div class="symbol-label bg-light-primary">
                                                                <i class="fa-solid fa-user text-primary fs-2"></i>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex flex-column">
                                                            <span class="text-gray-800 fw-bold">{{ $student->user->name }}</span>
                                                            <span class="text-gray-600 fw-semibold">{{ $student->user->email }}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="text-gray-800 fw-semibold">{{ $student->school->user->name ?? 'N/A' }}</span>
                                                </td>
                                                <td>
                                                    @if($attendance)
                                                        @if($attendance->status == 'attended')
                                                            <span class="badge badge-light-success">
                                                                    <i class="fa-solid fa-check me-1"></i>{{ __('workshops.management.attended') }}
                                                                </span>
                                                        @else
                                                            <span class="badge badge-light-danger">
                                                                    <i class="fa-solid fa-times me-1"></i>{{ __('workshops.management.absent') }}
                                                                </span>
                                                        @endif
                                                    @else
                                                        <span class="badge badge-light-secondary">
                                                                <i class="fa-solid fa-clock me-1"></i>{{ __('workshops.management.pending') }}
                                                            </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($evaluation)
                                                        <span class="badge badge-light-success">
                                                                <i class="fa-solid fa-star me-1"></i>{{ __('workshops.management.completed') }}
                                                            </span>
                                                        <div class="text-muted fs-7 mt-1">
                                                            {{ __('workshops.management.rating') }}: {{ $evaluation->rating }}/5
                                                        </div>
                                                    @else
                                                        <span class="badge badge-light-warning">
                                                                <i class="fa-solid fa-hourglass-half me-1"></i>{{ __('workshops.management.pending') }}
                                                            </span>
                                                    @endif
                                                </td>
{{--                                                <td>--}}
{{--                                                    @if($attendance && $attendance->status == 'attended' && $evaluation)--}}
{{--                                                        <span class="badge badge-light-info">--}}
{{--                                                            <i class="fa-solid fa-certificate me-1"></i>{{ __('Available') }}--}}
{{--                                                        </span>--}}
{{--                                                    @else--}}
{{--                                                        <span class="badge badge-light-secondary">--}}
{{--                                                            <i class="fa-solid fa-lock me-1"></i>{{ __('Locked') }}--}}
{{--                                                        </span>--}}
{{--                                                    @endif--}}
{{--                                                </td>--}}
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!--end::Table-->

                                @if($students->isEmpty())
                                    <div class="d-flex flex-column flex-center py-10">
                                        <div class="symbol symbol-100px mb-5">
                                            <div class="symbol-label bg-light-info">
                                                <i class="fa-solid fa-users text-info fs-1"></i>
                                            </div>
                                        </div>
                                        <div class="fs-1 fw-bolder text-gray-400 mb-5">{{ __('workshops.management.no_students_found') }}</div>
                                        <div class="fs-6 text-gray-600 text-center">
                                            {{ __('workshops.management.no_students_enrolled') }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Students List Card-->
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Row-->
            </div>
            <!--end::Content container-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Content wrapper-->
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize DataTable with export buttons
            const table = $('#workshop-students-table').DataTable({
                dom: '<"top-row d-flex justify-content-between"lB>rt<"bottom-row d-flex justify-content-between"ip>',
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],
                buttons: [
                    {
                        extend: 'csv',
                        text: '<i class="fa-solid fa-file-csv"></i> CSV',
                        className: 'btn btn-light-info btn-sm me-2',
                        exportOptions: {
                            columns: ':visible',
                            format: {
                                body: function (data, row, column, node) {
                                    // Clean HTML from data
                                    return data
                                        .replace(/<[^>]*>/g, '')
                                        .replace(/\s+/g, ' ')
                                        .trim();
                                }
                            }
                        },
                        filename: 'workshop-students-report-' + '{{ $event->event_name }}'
                    },
                    {
                        extend: 'excel',
                        text: '<i class="fa-solid fa-file-excel"></i> Excel',
                        className: 'btn btn-light-success btn-sm me-2',
                        exportOptions: {
                            columns: ':visible',
                            format: {
                                body: function (data, row, column, node) {
                                    return data
                                        .replace(/<[^>]*>/g, '')
                                        .replace(/\s+/g, ' ')
                                        .trim();
                                }
                            }
                        },
                        filename: 'workshop-students-report-' + '{{ $event->event_name }}'
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="fa-solid fa-file-pdf"></i> PDF',
                        className: 'btn btn-light-primary btn-sm',
                        orientation: 'landscape',
                        pageSize: 'A4',
                        exportOptions: {
                            columns: ':visible',
                            format: {
                                body: function (data, row, column, node) {
                                    return data
                                        .replace(/<[^>]*>/g, '')
                                        .replace(/\s+/g, ' ')
                                        .trim();
                                }
                            }
                        },
                        filename: 'workshop-students-report-' + '{{ $event->event_name }}',
                        customize: function(doc) {
                            doc.pageMargins = [20, 60, 20, 60];
                            doc.defaultStyle.fontSize = 10;
                            doc.styles.tableHeader.fontSize = 12;

                            // Set column widths
                            doc.content[1].table.widths = ['*', '20%', '15%', '15%'];

                            // Style the table
                            doc.styles.tableHeader = {
                                fillColor: '#f8f9fa',
                                color: '#212529',
                                bold: true,
                                alignment: 'center'
                            };

                            // Add title
                            doc.content.splice(0, 0, {
                                text: 'Workshop Students Report - ' + '{{ $event->event_name }}',
                                fontSize: 14,
                                bold: true,
                                alignment: 'center',
                                margin: [0, 0, 0, 20]
                            });

                            // Add footer
                            var now = new Date();
                            var formattedDate = now.toLocaleDateString() + ' ' + now.toLocaleTimeString();

                            doc.footer = function(currentPage, pageCount) {
                                return {
                                    columns: [
                                        {
                                            text: 'Generated on: ' + formattedDate,
                                            alignment: 'left',
                                            fontSize: 8,
                                            margin: [20, 0]
                                        },
                                        {
                                            text: 'Page ' + currentPage.toString() + ' of ' + pageCount,
                                            alignment: 'right',
                                            fontSize: 8,
                                            margin: [0, 0, 20, 0]
                                        }
                                    ]
                                };
                            };
                        }
                    }
                ],
                initComplete: function() {
                    // Move buttons to the toolbar
                    this.api().buttons().container()
                        .addClass('d-inline-block ms-3')
                        .appendTo($('.dataTables_length').parent());
                }
            });

            // Search functionality
            $('#workshop-students-search').keyup(function() {
                table.search(this.value).draw();
            });
        });
    </script>
@endpush
