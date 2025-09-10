@extends('admin.layouts.master')

@section('content')
    <!--begin::Content wrapper-->
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                        {{ __('Assign Programs to Students') }}
                    </h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">
                                {{ __('admin.dashboard.title') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">{{ __('Programs') }}</li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">{{ __('Assign to Students') }}</li>
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
            <div id="kt_app_content_container" class="app-container container-xxl">
                <!--begin::Card-->
                <div class="card">
                    <!--begin::Card header-->
                    <div class="card-header border-0 pt-6">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <div class="d-flex align-items-center position-relative my-1">
                                <h3 class="fw-bold m-0">{{ __('Assign Programs to Students') }}</h3>
                            </div>
                        </div>
                        <!--end::Card title-->
                        <!--begin::Card toolbar-->
                        <div class="card-toolbar">
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="bulkActionsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ __('Bulk Actions') }}
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="bulkActionsDropdown">
                                    <li><a class="dropdown-item bulk-grade-btn" data-grade="10" href="#">{{ __('Assign to All Grade 10') }}</a></li>
                                    <li><a class="dropdown-item bulk-grade-btn" data-grade="11" href="#">{{ __('Assign to All Grade 11') }}</a></li>
                                    <li><a class="dropdown-item bulk-grade-btn" data-grade="12" href="#">{{ __('Assign to All Grade 12') }}</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="#" id="bulkSelectBtn">{{ __('Select Multiple Students') }}</a></li>
                                </ul>
                            </div>
                        </div>
                        <!--end::Card toolbar-->
                    </div>
                    <!--end::Card header-->

                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <form id="assignmentForm" method="POST" action="{{ route('admin.programs.enroll.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="programSelect" class="form-label">{{ __('Select Programs') }}</label>
                                <select class="form-select select2" id="programSelect" name="programs[]" multiple="multiple">
                                    @foreach($programs as $program)
                                        <option value="{{ $program->id }}">{{ app()->getLocale() == 'ar' ? $program->title_ar : $program->title_en }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th width="40" class="bulk-select-col d-none">
                                            <input type="checkbox" id="selectAllStudents">
                                        </th>
                                        <th>{{ __('Student') }}</th>
                                        <th>{{ __('Grade') }}</th>
                                        <th>{{ __('Current Programs') }}</th>
                                        <th>{{ __('Assign') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($students as $student)
                                        <tr>
                                            <td class="bulk-select-col d-none">
                                                <input type="checkbox" name="bulk_students[]" value="{{ $student->id }}" class="student-checkbox">
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($student->avatar)
                                                        <img src="{{ asset('storage/' . $student->avatar) }}" alt="{{ $student->user->name }}" class="rounded-circle me-3" width="40" height="40">
                                                    @else
                                                        <div class="avatar-placeholder rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: #eee;">
                                                            <i class="fas fa-user text-muted"></i>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <strong>{{ $student->user->name }}</strong>
                                                        <div class="text-muted small">{{ $student->user->email }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>Grade {{ $student->grade }}</td>
                                            <td>
                                                @php
                                                    $enrolledPrograms = $student->enrollments->pluck('program_id')->toArray();
                                                    $colorMap = [
                                                        'Self Campus' => 'bg-success',
                                                        'Explore Your Career' => 'bg-warning',
                                                        'Ready for The Future' => 'bg-primary',
                                                        'بوصلة الذات' => 'bg-success',
                                                        'اكتشف مهنتك' => 'bg-warning',
                                                        'مستعدون للمستقبل' => 'bg-primary',
                                                    ];
                                                @endphp
                                                @foreach($student->enrollments as $enrollment)
                                                    @php
                                                        $programTitle = app()->getLocale() == 'ar' ? $enrollment->program->title_ar : $enrollment->program->title_en;
                                                        $badgeClass = $colorMap[$programTitle] ?? 'bg-secondary';
                                                    @endphp
                                                    <span class="badge {{ $badgeClass }} me-1 mb-1 py-2 px-3">
                                                        {{ $programTitle }}
{{--                                                        <span class="badge bg-white text-dark ms-1">{{ $enrollment->status }}</span>--}}
                                                    </span>
                                                @endforeach

                                            </td>
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input student-assign-checkbox" type="checkbox"
                                                           name="students[{{ $student->id }}]"
                                                           id="student_{{ $student->id }}"
                                                           data-enrolled="{{ json_encode($enrolledPrograms) }}">
                                                    <label class="form-check-label" for="student_{{ $student->id }}"></label>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-flex justify-content-end mt-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i> {{ __('Save Assignments') }}
                                </button>
                            </div>
                        </form>
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

    <!-- Confirmation Modal -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">{{ __('Confirm Assignment') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="confirmationModalBody">
                    <!-- Dynamic content will be inserted here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="button" class="btn btn-primary" id="confirmAssignmentBtn">{{ __('Confirm') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .avatar-placeholder {
            background-color: #f8f9fa;
            color: #6c757d;
        }
        .bulk-select-col {
            width: 40px;
        }
        .card-header {
            background-color: #f8f9fa;
        }
    </style>
@endpush

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "{{ __('Select programs') }}",
                allowClear: true,
                width: '100%'
            });

            // Toggle bulk select column
            $('#bulkSelectBtn').click(function(e) {
                e.preventDefault();
                $('.bulk-select-col').toggleClass('d-none');
            });

            // Select all students checkbox
            $('#selectAllStudents').change(function() {
                $('.student-checkbox').prop('checked', this.checked);
                $('.student-assign-checkbox').prop('checked', this.checked);
            });

            // Bulk assign by grade
            $('.bulk-grade-btn').click(function(e) {
                e.preventDefault();
                const grade = $(this).data('grade');

                // Uncheck all first
                $('.student-assign-checkbox').prop('checked', false);

                // Check students in selected grade
                $(`tr:contains("Grade ${grade}") .student-assign-checkbox`).prop('checked', true);

                // Show confirmation
                const count = $(`tr:contains("Grade ${grade}")`).length;
                Swal.fire({
                    title: '{{ __("Confirm Assignment") }}',
                    html: `<p>{{ __("You are about to assign selected programs to all") }} ${count} {{ __("students in grade") }} ${grade}.</p>
                      <p class="text-danger">{{ __("This will overwrite any existing assignments for these students.") }}</p>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '{{ __("Confirm") }}',
                    cancelButtonText: '{{ __("Cancel") }}'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#assignmentForm').submit();
                    }
                });
            });

            // Form submission with confirmation
            $('#assignmentForm').submit(function(e) {
                const selectedStudents = $('.student-assign-checkbox:checked').length;
                const selectedPrograms = $('#programSelect').val() || [];

                if (selectedStudents === 0 || selectedPrograms.length === 0) {
                    e.preventDefault();
                    Swal.fire({
                        title: '{{ __("Selection Required") }}',
                        text: '{{ __("Please select at least one student and one program to assign.") }}',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return false;
                }

                return true;
            });

            // Confirm assignment button
            $('#confirmAssignmentBtn').click(function() {
                $('#assignmentForm').submit();
            });

            @if (session('success'))
            Swal.fire({
                title: '{{ __("Success") }}',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'OK'
            });
            @endif

            @if (session('error'))
            Swal.fire({
                title: '{{ __("Error") }}',
                text: '{{ session('error') }}',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            @endif
        });
    </script>
@endsection
