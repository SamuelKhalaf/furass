@extends('admin.layouts.master')
@section('title', __('Consultation Notes'))

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
                        {{ __('Consultation Notes') }}
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
                            <a href="{{ route('admin.consultant.students.index') }}" class="text-muted text-hover-primary">{{ __('Students') }}</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">{{ __('Consultation Notes') }}</li>
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
                <!--begin::Actions-->
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <a href="{{ route('admin.consultant.students.index') }}" class="btn btn-sm btn-secondary">
                        <i class="fa-solid fa-arrow-left me-1"></i>{{ __('Back to Students') }}
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
                        <!--begin::Student Info Card-->
                        <div class="card card-flush h-md-100">
                            <!--begin::Card header-->
                            <div class="card-header">
                                <!--begin::Card title-->
                                <div class="card-title">
                                    <h3 class="fw-bold text-dark">{{ __('Student Information') }}</h3>
                                </div>
                                <!--end::Card title-->
                            </div>
                            <!--end::Card header-->

                            <!--begin::Card body-->
                            <div class="card-body pt-0">
                                <!--begin::Student Details-->
                                <div class="d-flex flex-column">
                                    <!--begin::Student Name-->
                                    <div class="d-flex align-items-center mb-4">
                                        <div class="symbol symbol-50px me-3">
                                            <div class="symbol-label bg-light-primary">
                                                <i class="fa-solid fa-user text-primary fs-2"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <span class="text-gray-700 fw-semibold fs-7">{{ __('Student Name') }}</span>
                                            <div class="text-gray-800 fw-bold fs-6">{{ $consultation->student->user->name }}</div>
                                        </div>
                                    </div>
                                    <!--end::Student Name-->

                                    <!--begin::School-->
                                    <div class="d-flex flex-stack mb-4">
                                        <span class="text-gray-700 fw-bold fs-6">{{ __('School') }}</span>
                                        <span class="text-gray-800 fw-bolder fs-6">{{ $consultation->student->school->user->name }}</span>
                                    </div>
                                    <!--end::School-->

                                    <!--begin::Email-->
                                    <div class="d-flex flex-stack mb-4">
                                        <span class="text-gray-700 fw-bold fs-6">{{ __('Email') }}</span>
                                        <span class="text-gray-800 fw-bolder fs-6">{{ $consultation->student->user->email }}</span>
                                    </div>
                                    <!--end::Email-->

                                    <!--begin::Session Date-->
                                    <div class="d-flex flex-stack mb-4">
                                        <span class="text-gray-700 fw-bold fs-6">{{ __('Session Date') }}</span>
                                        <span class="text-gray-800 fw-bolder fs-6">{{ \Carbon\Carbon::parse($consultation->scheduled_at)->format('M d, Y h:i A') }}</span>
                                    </div>
                                    <!--end::Session Date-->

                                    <!--begin::Status-->
                                    <div class="d-flex flex-stack mb-4">
                                        <span class="text-gray-700 fw-bold fs-6">{{ __('Status') }}</span>
                                        @if($consultation->status === 'done')
                                            <span class="badge badge-light-success fs-7 fw-bold">
                                                <i class="fa-solid fa-check-circle me-1"></i>{{ __('Completed') }}
                                            </span>
                                        @elseif($consultation->status === 'pending')
                                            <span class="badge badge-light-warning fs-7 fw-bold">
                                                <i class="fa-solid fa-clock me-1"></i>{{ __('Pending Notes') }}
                                            </span>
                                        @else
                                            <span class="badge badge-light-info fs-7 fw-bold">
                                                <i class="fa-solid fa-calendar-check me-1"></i>{{ __('Scheduled') }}
                                            </span>
                                        @endif
                                    </div>
                                    <!--end::Status-->
                                </div>
                                <!--end::Student Details-->

                                <!--begin::Separator-->
                                <div class="separator separator-dashed my-5"></div>
                                <!--end::Separator-->

                                <!--begin::Instructions-->
                                <div class="alert alert-info d-flex align-items-center p-5">
                                    <div class="d-flex flex-column">
                                        <h5 class="mb-1 text-dark">{{ __('Instructions') }}</h5>
                                        <span class="fs-7">{{ __('Please provide detailed notes about the consultation session to help the student understand the guidance provided.') }}</span>
                                    </div>
                                </div>
                                <!--end::Instructions-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Student Info Card-->
                    </div>
                    <!--end::Col-->

                    <!--begin::Col-->
                    <div class="col-xl-8">
                        <!--begin::Notes Form Card-->
                        <div class="card card-flush h-md-100">
                            <!--begin::Card header-->
                            <div class="card-header">
                                <!--begin::Card title-->
                                <div class="card-title">
                                    <h3 class="fw-bold text-dark">
                                        <i class="fa-solid fa-file-text text-primary me-2"></i>{{ __('Consultation Notes') }}
                                    </h3>
                                </div>
                                <!--end::Card title-->
                            </div>
                            <!--end::Card header-->

                            <!--begin::Card body-->
                            <div class="card-body pt-0">
                                <!--begin::Form-->
                                <form method="POST" action="{{ route('admin.consultant.consultation.notes.save', $consultation->id) }}">
                                    @csrf

                                    <!--begin::Notes Input-->
                                    <div class="mb-8">
                                        <label for="notes" class="form-label fw-semibold fs-6 mb-2">{{ __('Consultation Notes') }}</label>
                                        <textarea
                                            class="form-control form-control-solid @error('notes') is-invalid @enderror"
                                            id="notes"
                                            name="notes"
                                            rows="15"
                                            placeholder="{{ __('Please provide detailed notes about the consultation session, including recommendations, next steps, and any important insights discussed...') }}"
                                        >{{ old('notes', $existingNotes->notes ?? '') }}</textarea>

                                        @error('notes')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror

                                        <div class="form-text">{{ __('Minimum 10 characters required') }}</div>
                                    </div>
                                    <!--end::Notes Input-->

                                    <!--begin::Guidelines-->
                                    <div class="alert alert-primary d-flex align-items-center p-5 mb-8">
                                        <div class="d-flex flex-column">
                                            <h5 class="mb-2 text-dark">{{ __('Guidelines for Consultation Notes') }}</h5>
                                            <ul class="text-gray-700 fw-semibold fs-7 mb-0">
                                                <li class="mb-1">{{ __('Summarize the key points discussed during the consultation') }}</li>
                                                <li class="mb-1">{{ __('Include specific recommendations for the student') }}</li>
                                                <li class="mb-1">{{ __('Mention any action items or next steps') }}</li>
                                                <li class="mb-1">{{ __('Highlight strengths and areas for improvement') }}</li>
                                                <li>{{ __('Keep the tone professional and encouraging') }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <!--end::Guidelines-->

                                    <!--begin::Action Buttons-->
                                    <div class="d-flex flex-stack">
                                        <div class="d-flex align-items-center">
                                            <button type="button" class="btn btn-light-danger me-3" onclick="history.back()">
                                                <i class="fa-solid fa-times me-1"></i>{{ __('Cancel') }}
                                            </button>
                                        </div>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa-solid fa-save me-1"></i>{{ __('Save Notes & Complete Consultation') }}
                                        </button>
                                    </div>
                                    <!--end::Action Buttons-->
                                </form>
                                <!--end::Form-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Notes Form Card-->
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
