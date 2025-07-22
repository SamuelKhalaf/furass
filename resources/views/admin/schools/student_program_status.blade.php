@extends('admin.layouts.master')
@section('title', __('schools.student_program_status'))
@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-4 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-dark fw-bold fs-2x flex-column justify-content-center my-0">
                        {{ __('schools.student_program_status') }}
                    </h1>
                    <span class="text-gray-500 mt-1 fw-semibold fs-6">
                    {{ __('schools.student_program_status_description') }}
                </span>
                </div>
            </div>
        </div>
        <!--end::Toolbar-->

        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-fluid">
                <!-- Students Table -->
                <div class="card card-flush">
                    <div class="card-header pt-7">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold text-gray-800">{{ __('schools.all_students_status') }}</span>
                        </h3>
                        <div class="card-toolbar">
                            <div class="d-flex align-items-center position-relative me-4">
                            <span class="svg-icon svg-icon-1 position-absolute ms-4">
                                <i class="fas fa-search"></i>
                            </span>
                                <input type="text" class="form-control form-control-solid w-250px ps-12"
                                       placeholder="{{ __('schools.search_students') }}"
                                       id="students-search"/>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-6">
                        <div class="table-responsive">
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="students-table">
                                <thead>
                                <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                    <th class="min-w-150px">{{ __('schools.student_name') }}</th>
                                    <th class="min-w-100px">{{ __('schools.grade') }}</th>
                                    <th class="min-w-150px">{{ __('schools.program') }}</th>
                                    <th class="min-w-100px">{{ __('schools.status') }}</th>
                                    <th class="min-w-100px">{{ __('schools.progress') }}</th>
                                    <th class="min-w-100px">{{ __('schools.last_activity') }}</th>
                                </tr>
                                </thead>
                                <tbody class="fw-semibold text-gray-600">
                                @foreach($students as $student)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="symbol symbol-45px me-5">
                                                    @if($student->avatar)
                                                        <img src="{{ asset($student->avatar) }}" alt="{{ $student->user->name }}"/>
                                                    @else
                                                        <span class="symbol-label bg-light-primary">
                                                    <i class="fas fa-user text-primary fs-4"></i>
                                                </span>
                                                    @endif
                                                </div>
                                                <div class="d-flex justify-content-start flex-column">
                                                    <span class="text-gray-800 fw-bold">{{ $student->user->name }}</span>
                                                    <span class="text-gray-500 fs-7">{{ $student->user->email }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $student->grade }}</td>
                                        <td>
                                            @forelse($student->enrollments as $enrollment)
                                                {{ app()->getLocale() == 'ar' ? $enrollment->program->title_ar : $enrollment->program->title_en }}
                                                @if(!$loop->last)<br> @endif
                                            @empty
                                                <span class="text-muted fs-7">{{ __('schools.not_enrolled') }}</span>
                                            @endforelse
                                        </td>
                                        <td>
                                            @forelse($student->enrollments as $enrollment)
                                                <span class="badge badge-light-{{ getStatusColor($enrollment->status) }} me-2">
                                                    {{ __('schools.'.$enrollment->status) }}
                                                </span>
                                                @if(!$loop->last)<br>@endif
                                            @empty
                                                <span class="text-muted fs-7">-</span>
                                            @endforelse
                                        </td>
                                        <td>
                                            @forelse($student->enrollments as $enrollment)
                                                <div class="progress h-6px w-100 bg-light-{{ getStatusColor($enrollment->status) }}">
                                                    <div class="progress-bar bg-{{ getStatusColor($enrollment->status) }}"
                                                         style="width: {{ $enrollment->progress }}%"></div>
                                                </div>
                                                <span class="text-gray-800 fw-bold fs-7 mt-1 d-block">
                                                {{ $enrollment->progress }}%
                                            </span>
                                                @if(!$loop->last)<br>@endif
                                            @empty
                                                <span class="text-muted fs-7">0%</span>
                                            @endforelse
                                        </td>
                                        <td>
                                            @if($student->studentPathProgress->isNotEmpty())
                                                {{ $student->studentPathProgress->first()->updated_at->diffForHumans() }}
                                            @else
                                                <span class="text-muted fs-7">{{ __('schools.no_activity') }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{ $students->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize student search functionality
            const searchInput = document.getElementById('students-search');
            const studentsTable = document.getElementById('students-table');

            searchInput.addEventListener('keyup', function() {
                const filter = this.value.toLowerCase();
                const rows = studentsTable.getElementsByTagName('tr');

                for (let i = 1; i < rows.length; i++) {
                    const nameColumn = rows[i].getElementsByTagName('td')[0];
                    if (nameColumn) {
                        const txtValue = nameColumn.textContent || nameColumn.innerText;
                        if (txtValue.toLowerCase().indexOf(filter) > -1) {
                            rows[i].style.display = "";
                        } else {
                            rows[i].style.display = "none";
                        }
                    }
                }
            });
        });
    </script>
@endpush
