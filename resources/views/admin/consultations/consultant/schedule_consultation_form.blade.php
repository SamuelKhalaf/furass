@extends('admin.layouts.master')
@section('title', __('Schedule Consultation'))

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
                        {{ __('Schedule Consultation') }}
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
                        <li class="breadcrumb-item text-muted">{{ __('Schedule Consultation') }}</li>
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
                        <!--begin::Student Details Card-->
                        <div class="card card-flush h-md-100">
                            <!--begin::Card header-->
                            <div class="card-header">
                                <!--begin::Card title-->
                                <div class="card-title">
                                    <h3 class="fw-bold text-dark">{{ __('Student Details') }}</h3>
                                </div>
                                <!--end::Card title-->
                            </div>
                            <!--end::Card header-->

                            <!--begin::Card body-->
                            <div class="card-body pt-0">
                                <!--begin::Student Info-->
                                <div class="d-flex align-items-center mb-5">
                                    <div class="symbol symbol-60px me-3">
                                        <div class="symbol-label bg-light-primary">
                                            <i class="fa-solid fa-user text-primary fs-2"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <span class="text-gray-800 fw-bold fs-5 d-block">{{ $student->user->name }}</span>
                                        <span class="text-muted fw-semibold fs-7">{{ $student->user->email }}</span>
                                    </div>
                                </div>
                                <!--end::Student Info-->

                                <!--begin::School-->
                                <div class="d-flex flex-stack mb-5">
                                    <span class="text-gray-700 fw-bold fs-6">{{ __('School') }}</span>
                                    <span class="text-gray-800 fw-bolder fs-6">{{ $student->school->user->name }}</span>
                                </div>
                                <!--end::School-->

                                <!--begin::Program-->
                                <div class="d-flex flex-stack mb-5">
                                    <span class="text-gray-700 fw-bold fs-6">{{ __('Program') }}</span>
                                    <span class="text-gray-800 fw-bolder fs-6">{{ $program->{app()->getLocale() == 'ar' ? 'title_ar' : 'title_en'} }}</span>
                                </div>
                                <!--end::Program-->

                                <!--begin::Path Point-->
                                <div class="d-flex flex-stack mb-5">
                                    <span class="text-gray-700 fw-bold fs-6">{{ __('Path Point') }}</span>
                                    <span class="text-gray-800 fw-bolder fs-6">{{ $pathPoint->{app()->getLocale() == 'ar' ? 'title_ar' : 'title_en'} }}</span>
                                </div>
                                <!--end::Path Point-->

                                <!--begin::Status-->
                                <div class="d-flex flex-stack mb-5">
                                    <span class="text-gray-700 fw-bold fs-6">{{ __('Status') }}</span>
                                    <span class="badge badge-light-warning fs-7 fw-bold">
                                        <i class="fa-solid fa-play me-1"></i>{{ __('Active') }}
                                    </span>
                                </div>
                                <!--end::Status-->

                                <!--begin::Description-->
                                @if($pathPoint->{app()->getLocale() == 'ar' ? 'description_ar' : 'description_en'})
                                    <div class="separator separator-dashed my-5"></div>
                                    <div class="text-gray-800 fw-semibold fs-6">
                                        {{ $pathPoint->{app()->getLocale() == 'ar' ? 'description_ar' : 'description_en'} }}
                                    </div>
                                @endif
                                <!--end::Description-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Student Details Card-->
                    </div>
                    <!--end::Col-->

                    <!--begin::Col-->
                    <div class="col-xl-8">
                        <!--begin::Schedule Form Card-->
                        <div class="card card-flush h-md-100">
                            <!--begin::Card header-->
                            <div class="card-header">
                                <!--begin::Card title-->
                                <div class="card-title">
                                    <h3 class="fw-bold text-dark">
                                        <i class="fa-solid fa-calendar-plus text-primary me-2"></i>{{ __('Schedule Consultation') }}
                                    </h3>
                                </div>
                                <!--end::Card title-->
                            </div>
                            <!--end::Card header-->

                            <!--begin::Card body-->
                            <div class="card-body pt-0">
                                @if($existingConsultation)
                                    <!--begin::Existing consultation alert-->
                                    <div class="alert
                                        @if($existingConsultation->status === 'done') alert-success
                                        @else alert-info
                                        @endif
                                        d-flex align-items-center p-5 mb-8">

                                        <div class="d-flex flex-column">
                                            <h4 class="mb-1 text-dark">
                                                @if($existingConsultation->status === 'done')
                                                    {{ __('Consultation Completed') }}
                                                @elseif($existingConsultation->status === 'cancelled')
                                                    {{ __('Consultation Cancelled') }}
                                                @else
                                                    {{ __('Consultation Already Scheduled') }}
                                                @endif
                                            </h4>
                                            <span>
                                                @if($existingConsultation->status === 'done')
                                                    {{ __('The consultation was completed on') }}
                                                    {{ \Carbon\Carbon::parse($existingConsultation->scheduled_at)->format('M d, Y h:i A') }}.
                                                @elseif($existingConsultation->status === 'cancelled')
                                                    {{ __('This consultation was cancelled on') }}
                                                    {{ \Carbon\Carbon::parse($existingConsultation->scheduled_at)->format('M d, Y h:i A') }}.
                                                    {{ __('However, you can reactivate or reschedule it at any time if needed.') }}
                                                @else
                                                    {{ __('A consultation is already scheduled for this student on') }}
                                                    {{ \Carbon\Carbon::parse($existingConsultation->scheduled_at)->format('M d, Y h:i A') }}.
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                    <!--end::Existing consultation alert-->
                                @endif

                                <!--begin::Form-->
                                <form action="{{ route('admin.consultant.consultation.schedule', ['student' => $student->id, 'program' => $program->id, 'pathPoint' => $pathPoint->id]) }}" method="POST" id="kt_schedule_consultation_form">
                                    @csrf

                                    <!--begin::Date and Time-->
                                    <div class="row mb-8">
                                        <div class="col-xl-3">
                                            <div class="fs-6 fw-bold mt-2 mb-3">{{ __('Date & Time') }}</div>
                                        </div>
                                        <div class="col-xl-9">
                                            <div class="row g-3">
                                                <div class="col-md-6 fv-row">
                                                    <input type="datetime-local" name="scheduled_at" id="scheduled_at" class="form-control form-control-solid"
                                                           value="{{ $existingConsultation ? \Carbon\Carbon::parse($existingConsultation->scheduled_at)->format('Y-m-d\TH:i') : '' }}"
                                                           min="{{ \Carbon\Carbon::now()->format('Y-m-d\TH:i') }}" required/>
                                                    @error('scheduled_at')
                                                    <div class="fv-plugins-message-container">
                                                        <div class="fv-help-block">{{ $message }}</div>
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Date and Time-->

                                    <!--begin::Zoom Meeting Details-->
                                    <div class="row mb-8">
                                        <div class="col-xl-3">
                                            <div class="fs-6 fw-bold mt-2 mb-3">{{ __('Zoom Meeting Details') }}</div>
                                        </div>
                                        <div class="col-xl-9">
                                            <div class="row g-3">
                                                <div class="col-md-6 fv-row">
                                                    <label class="form-label">{{ __('Meeting ID') }}</label>
                                                    <input type="text" name="zoom_meeting_id" class="form-control form-control-solid"
                                                           value="{{ $existingConsultation ? $existingConsultation->zoom_meeting_id : '' }}"
                                                           placeholder="{{ __('Enter Zoom Meeting ID') }}" required/>
                                                    @error('zoom_meeting_id')
                                                    <div class="fv-plugins-message-container">
                                                        <div class="fv-help-block">{{ $message }}</div>
                                                    </div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 fv-row">
                                                    <label class="form-label">{{ __('Meeting Password') }}</label>
                                                    <input type="text" name="zoom_password" class="form-control form-control-solid"
                                                           value="{{ $existingConsultation ? $existingConsultation->zoom_password : '' }}"
                                                           placeholder="{{ __('Enter Meeting Password (Optional)') }}"/>
                                                    @error('zoom_password')
                                                    <div class="fv-plugins-message-container">
                                                        <div class="fv-help-block">{{ $message }}</div>
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Zoom Meeting Details-->

                                    <!--begin::Zoom URLs-->
                                    <div class="row mb-8">
                                        <div class="col-xl-3">
                                            <div class="fs-6 fw-bold mt-2 mb-3">{{ __('Zoom URLs') }}</div>
                                        </div>
                                        <div class="col-xl-9">
                                            <div class="row g-3">
                                                <div class="col-md-12 fv-row">
                                                    <label class="form-label">{{ __('Join URL (for Student)') }}</label>
                                                    <input type="url" name="zoom_join_url" class="form-control form-control-solid"
                                                           value="{{ $existingConsultation ? $existingConsultation->zoom_join_url : '' }}"
                                                           placeholder="{{ __('Enter Zoom Join URL') }}" required/>
                                                    @error('zoom_join_url')
                                                    <div class="fv-plugins-message-container">
                                                        <div class="fv-help-block">{{ $message }}</div>
                                                    </div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-12 fv-row">
                                                    <label class="form-label">{{ __('Start URL (for Host)') }}</label>
                                                    <input type="url" name="zoom_start_url" class="form-control form-control-solid"
                                                           value="{{ $existingConsultation ? $existingConsultation->zoom_start_url : '' }}"
                                                           placeholder="{{ __('Enter Zoom Start URL') }}" required/>
                                                    @error('zoom_start_url')
                                                    <div class="fv-plugins-message-container">
                                                        <div class="fv-help-block">{{ $message }}</div>
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Zoom URLs-->

                                    <!--begin::Instructions-->
                                    <div class="card bg-light-info p-5 mb-8">
                                        <h5 class="text-gray-800 fw-bold mb-3">{{ __('Instructions') }}</h5>
                                        <ul class="text-gray-600 fw-semibold fs-6 mb-0">
                                            <li class="mb-2">{{ __('Create a Zoom meeting and copy the meeting details') }}</li>
                                            <li class="mb-2">{{ __('Set the meeting date and time appropriately') }}</li>
                                            <li class="mb-2">{{ __('The student will receive a notification once scheduled') }}</li>
                                            <li class="mb-2">{{ __('The student can join 15 minutes before the meeting') }}</li>
                                            <li>{{ __('Don\'t forget to add consultation notes after the meeting') }}</li>
                                        </ul>
                                    </div>
                                    <!--end::Instructions-->

                                    <!--begin::Actions-->
                                    <div class="text-center">
                                        <button type="submit" onclick="history.back()" class="btn btn-light me-3">{{ __('Cancel') }}</button>
                                        <button type="submit" class="btn btn-primary">
                                            <span class="indicator-label">
                                                <i class="fa-solid fa-calendar-check me-2"></i>{{ $existingConsultation ? __('Update Consultation') : __('Schedule Consultation') }}
                                            </span>
                                            <span class="indicator-progress">
                                                {{ __('Please wait...') }}
                                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                            </span>
                                        </button>
                                    </div>
                                    <!--end::Actions-->
                                </form>
                                <!--end::Form-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Schedule Form Card-->
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

@section('scripts')
    <script>
        // Form validation
        const form = document.getElementById('kt_schedule_consultation_form');
        const validator = FormValidation.formValidation(form, {
            fields: {
                scheduled_at: {
                    validators: {
                        notEmpty: {
                            message: '{{ __("Date and time is required") }}'
                        }
                    }
                },
                zoom_meeting_id: {
                    validators: {
                        notEmpty: {
                            message: '{{ __("Meeting ID is required") }}'
                        }
                    }
                },
                zoom_join_url: {
                    validators: {
                        notEmpty: {
                            message: '{{ __("Join URL is required") }}'
                        },
                        uri: {
                            message: '{{ __("Please enter a valid URL") }}'
                        }
                    }
                },
                zoom_start_url: {
                    validators: {
                        notEmpty: {
                            message: '{{ __("Start URL is required") }}'
                        },
                        uri: {
                            message: '{{ __("Please enter a valid URL") }}'
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
        });

        // Handle form submission
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            validator.validate().then(function (status) {
                if (status == 'Valid') {
                    const submitButton = form.querySelector('[type="submit"]');
                    submitButton.setAttribute('data-kt-indicator', 'on');
                    submitButton.disabled = true;

                    setTimeout(function () {
                        form.submit();
                    }, 500);
                }
            });
        });
    </script>
@endsection
