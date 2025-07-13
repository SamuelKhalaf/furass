@extends('admin.layouts.master')
@section('title', __('Students Needing Consultation'))

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
                        {{ __('Students Needing Consultation') }}
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
                        <li class="breadcrumb-item text-muted">{{ __('Consultations') }}</li>
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
            <div id="kt_app_content_container" class="app-container container-fluid">
                <!--begin::Card-->
                <div class="card">
                    <!--begin::Card header-->
                    <div class="card-header border-0 pt-6">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <!--begin::Search-->
                            <div class="d-flex align-items-center position-relative my-1">
                                <i class="fa-solid fa-search fs-3 position-absolute ms-5"></i>
                                <input type="text" data-kt-students-table-filter="search" class="form-control form-control-solid w-250px ps-13" placeholder="{{ __('Search students') }}"/>
                            </div>
                            <!--end::Search-->
                        </div>
                        <!--end::Card title-->
                    </div>
                    <!--end::Card header-->

                    <!--begin::Card body-->
                    <div class="card-body py-4">
                        @if($students->count() > 0)
                            <!--begin::Table-->
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_students_table">
                                <!--begin::Table head-->
                                <thead>
                                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                    <th class="min-w-125px">{{ __('Student') }}</th>
                                    <th class="min-w-125px">{{ __('School') }}</th>
                                    <th class="min-w-125px">{{ __('Program') }}</th>
                                    <th class="min-w-125px">{{ __('Path Point') }}</th>
                                    <th class="min-w-125px">{{ __('Status') }}</th>
                                    <th class="min-w-100px">{{ __('Actions') }}</th>
                                </tr>
                                </thead>
                                <!--end::Table head-->

                                <!--begin::Table body-->
                                <tbody class="text-gray-600 fw-semibold">
                                @foreach($students as $student)
                                    @foreach($student->studentPathProgress as $progress)
                                        <tr>
                                            <!--begin::Student-->
                                            <td class="d-flex align-items-center">
                                                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                                    <div class="symbol-label bg-light-primary">
                                                        <i class="fa-solid fa-user text-primary fs-2"></i>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <span class="text-gray-800 fw-bold text-hover-primary mb-1">{{ $student->user->name }}</span>
                                                    <span class="text-muted fw-semibold text-muted d-block fs-7">{{ $student->user->email }}</span>
                                                </div>
                                            </td>
                                            <!--end::Student-->

                                            <!--begin::School-->
                                            <td>
                                                <span class="text-gray-800 fw-bold d-block fs-6">{{ $student->school->user->name }}</span>
                                            </td>
                                            <!--end::School-->

                                            <!--begin::Program-->
                                            <td>
                                                <span class="text-gray-800 fw-bold d-block fs-6">{{ $progress->program->{app()->getLocale() == 'ar' ? 'title_ar' : 'title_en'} }}</span>
                                            </td>
                                            <!--end::Program-->

                                            <!--begin::Path Point-->
                                            <td>
                                                <span class="text-gray-800 fw-bold d-block fs-6">{{ $progress->pathPoint->{app()->getLocale() == 'ar' ? 'title_ar' : 'title_en'} }}</span>
                                            </td>
                                            <!--end::Path Point-->

                                            <!--begin::Status-->
                                            <td>
                                                @php
                                                    $consultation = \App\Models\Consultation::where('student_id', $student->id)
                                                        ->whereHas('consultant.assignedSchools', function($query) use ($student) {
                                                            $query->where('school_id', $student->school_id);
                                                        })
                                                        ->where('updated_at', '>=', $progress->updated_at)
                                                        ->latest()
                                                        ->first();
                                                @endphp

                                                @if($consultation)
                                                    @if($consultation->status === 'pending')
                                                        <span class="text-center badge badge-light-info fs-7 fw-bold">
                                                            <i class="fa-solid fa-calendar-check me-1"></i>
                                                            {{ __('Scheduled') }}
                                                        </span>
                                                        <span class="badge badge-light-info fs-7 fw-bold">
                                                            {{ \Carbon\Carbon::parse($consultation->scheduled_at)->format('M d, Y h:i A') }}
                                                        </span>
                                                    @elseif($consultation->status === 'done')
                                                        <span class="badge badge-light-success fs-7 fw-bold">
                                                            <i class="fa-solid fa-check-circle me-1"></i>{{ __('Completed') }}
                                                        </span>
                                                    @else
                                                        <span class="badge badge-light-warning fs-7 fw-bold">
                                                            <i class="fa-solid fa-clock me-1"></i>{{ __('Waiting for Schedule') }}
                                                        </span>
                                                    @endif
                                                @else
                                                    <span class="badge badge-light-warning fs-7 fw-bold">
                                                        <i class="fa-solid fa-clock me-1"></i>{{ __('Waiting for Schedule') }}
                                                    </span>
                                                @endif
                                            </td>
                                            <!--end::Status-->

                                            <!--begin::Actions-->
                                            <td class="text-end">
                                                @if($consultation)
                                                    @if($consultation->status === 'pending')
                                                        <div class="d-flex justify-content-end gap-2">
                                                            <a href="{{ route('admin.consultant.consultation.start', $consultation->id) }}"
                                                               class="btn btn-sm btn-success" target="_blank">
                                                                <i class="fa-solid fa-video me-1"></i>{{ __('Start Meeting') }}
                                                            </a>
                                                            <a href="{{ route('admin.consultant.consultation.notes.form', $consultation->id) }}"
                                                               class="btn btn-sm btn-primary">
                                                                <i class="fa-solid fa-file-text me-1"></i>{{ __('Add Notes') }}
                                                            </a>
                                                            <form method="POST" action="{{ route('admin.consultant.consultation.cancel', $consultation->id) }}"
                                                                  class="d-inline" onsubmit="return confirm('{{ __('Are you sure you want to cancel this consultation?') }}')">
                                                                @csrf
                                                                <button type="submit" class="btn btn-sm btn-danger">
                                                                    <i class="fa-solid fa-times me-1"></i>{{ __('Cancel') }}
                                                                </button>
                                                            </form>
                                                        </div>
                                                    @elseif($consultation->status === 'done')
                                                        <a href="{{ route('admin.consultant.consultation.notes.form', $consultation->id) }}"
                                                           class="btn btn-sm btn-info">
                                                            <i class="fa-solid fa-eye me-1"></i>{{ __('View Notes') }}
                                                        </a>
                                                    @else
                                                        <a href="{{ route('admin.consultant.consultation.schedule.form', ['student' => $student->id, 'program' => $progress->program_id, 'pathPoint' => $progress->path_point_id]) }}"
                                                           class="btn btn-sm btn-primary">
                                                            <i class="fa-solid fa-calendar-plus me-1"></i>{{ __('Schedule Consultation') }}
                                                        </a>
                                                    @endif
                                                @else
                                                    <a href="{{ route('admin.consultant.consultation.schedule.form', ['student' => $student->id, 'program' => $progress->program_id, 'pathPoint' => $progress->path_point_id]) }}"
                                                       class="btn btn-sm btn-primary">
                                                        <i class="fa-solid fa-calendar-plus me-1"></i>{{ __('Schedule Consultation') }}
                                                    </a>
                                                @endif
                                            </td>
                                            <!--end::Actions-->
                                        </tr>
                                    @endforeach
                                @endforeach
                                </tbody>
                                <!--end::Table body-->
                            </table>
                            <!--end::Table-->
                        @else
                            <!--begin::Empty state-->
                            <div class="d-flex flex-column flex-center">
                                <div class="symbol symbol-100px mb-5">
                                    <div class="symbol-label bg-light-primary">
                                        <i class="fa-solid fa-users text-primary fs-1"></i>
                                    </div>
                                </div>
                                <div class="fs-1 fw-bolder text-gray-400 mb-5">{{ __('No Students Found') }}</div>
                                <div class="fs-6 text-gray-600 text-center mb-8">
                                    {{ __('There are no students currently waiting for consultation scheduling.') }}
                                </div>
                            </div>
                            <!--end::Empty state-->
                        @endif
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Content container-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Content wrapper-->
@endsection

@section('scripts')
    <script>
        // Initialize DataTable
        $('#kt_students_table').DataTable({
            responsive: true,
            {{--language: {--}}
            {{--    url: "{{ app()->getLocale() == 'ar' ? '//cdn.datatables.net/plug-ins/1.10.25/i18n/Arabic.json' : '' }}"--}}
            {{--}--}}
        });

        // Search functionality
        const searchInput = document.querySelector('[data-kt-students-table-filter="search"]');
        if (searchInput) {
            searchInput.addEventListener('keyup', function (e) {
                $('#kt_students_table').DataTable().search(e.target.value).draw();
            });
        }
    </script>
@endsection
