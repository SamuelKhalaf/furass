@extends('admin.layouts.master')
@section('title', __('dashboard.inactive_students'))
@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar py-4 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-dark fw-bold fs-2x flex-column justify-content-center my-0">
                        {{ __('dashboard.inactive_students') }}
                    </h1>
                    <span class="text-gray-500 mt-1 fw-semibold fs-6">
                    {{ __('dashboard.students_with_no_activity_past_days', ['days' => $inactiveDaysThreshold]) }}
                </span>
                </div>
            </div>
        </div>

        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-fluid">
                <div class="card card-flush">
                    <div class="card-body pt-6">
                        <div class="table-responsive">
                            <table class="table align-middle table-row-dashed fs-6 gy-5">
                                <thead>
                                <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                    <th class="min-w-125px">{{ __('dashboard.student_name') }}</th>
                                    <th class="min-w-125px">{{ __('dashboard.grade') }}</th>
                                    <th class="min-w-125px">{{ __('dashboard.last_activity') }}</th>
                                    <th class="min-w-125px">{{ __('dashboard.active_enrollments') }}</th>
                                    <th class="min-w-125px">{{ __('dashboard.average_progress') }}</th>
                                </tr>
                                </thead>
                                <tbody class="fw-semibold text-gray-600">
                                @forelse($inactiveStudents as $student)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="symbol symbol-45px me-5">
                                                <span class="symbol-label bg-light-danger">
                                                    <i class="fas fa-user text-danger fs-4"></i>
                                                </span>
                                                </div>
                                                <div class="d-flex justify-content-start flex-column">
                                                    <span class="text-gray-800 fw-bold">{{ $student->user->name }}</span>
                                                    <span class="text-gray-500 fs-7">{{ $student->user->email }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $student->grade }}</td>
                                        <td>
                                            @if($student->studentPathProgress->first())
                                                {{ $student->studentPathProgress->first()->updated_at->diffForHumans() }}
                                            @else
                                                {{ __('dashboard.no_activity_recorded') }}
                                            @endif
                                        </td>
                                        <td>{{ $student->enrollments->count() }}</td>
                                        <td>
                                            <div class="progress h-6px w-100 bg-light-warning">
                                                <div class="progress-bar bg-warning" style="width: {{ $student->enrollments->avg('progress') ?? 0 }}%"></div>
                                            </div>
                                            <span class="text-gray-800 fw-bold fs-7">{{ $student->enrollments->avg('progress') ?? 0 }}%</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-10">
                                            <span class="text-muted fs-6">{{ __('dashboard.no_inactive_students') }}</span>
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{ $inactiveStudents->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
