@extends('admin.layouts.master')
@section('title' , 'Assessments Result')
@push('styles')
    <style>
        .card-custom {
            transition: all 0.3s ease;
            border: 1px solid #e4e6ef;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
        }

        .card-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 20px 0 rgba(0, 0, 0, 0.12);
            border-color: #009ef7;
        }

        .symbol-50px {
            width: 50px;
            height: 50px;
        }

        .symbol-65px {
            width: 65px;
            height: 65px;
        }

        .progress {
            border-radius: 0.475rem;
        }

        .progress-bar {
            border-radius: 0.475rem;
        }

        .h-8px {
            height: 8px;
        }

        .w-250px {
            width: 250px;
        }

        .form-select-solid {
            background-color: #f5f8fa;
            border-color: #e4e6ef;
        }

        .form-select-solid:focus {
            background-color: #ffffff;
            border-color: #009ef7;
        }

        .ps-14 {
            padding-left: 3.5rem !important;
        }

        .card-stretch {
            height: 100%;
        }

        .btn-light-primary {
            color: #009ef7;
            background-color: rgba(0, 158, 247, 0.1);
            border-color: transparent;
        }

        .btn-light-primary:hover {
            color: #ffffff;
            background-color: #009ef7;
            border-color: #009ef7;
        }

        .btn-light-secondary {
            color: #7e8299;
            background-color: rgba(126, 130, 153, 0.1);
            border-color: transparent;
        }

        .pagination .page-link {
            color: #5e6278;
            background-color: #f5f8fa;
            border-color: #e4e6ef;
        }

        .pagination .page-link:hover {
            color: #009ef7;
            background-color: #e1f0ff;
            border-color: #009ef7;
        }

        .pagination .page-item.active .page-link {
            color: #ffffff;
            background-color: #009ef7;
            border-color: #009ef7;
        }
    </style>
@endpush
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
                        {{ __('My Students') }}
                    </h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">
                                {{ __('Dashboard') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">{{ __('Students Assessments') }}</li>
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

                <!--begin::Filter Section-->
                <div class="card mb-5 mb-xl-10">
                    <div class="card-header border-0 pt-5">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold fs-3 mb-1">Filter Students</span>
                            <span class="text-muted mt-1 fw-semibold fs-7">Filter by school to find specific students</span>
                        </h3>
                    </div>
                    <div class="card-body py-3">
                        <form method="GET" action="{{ route('admin.students.evaluation.result') }}" class="d-flex align-items-center">
                            <div class="d-flex align-items-center position-relative my-1 me-5">
                                <i class="fa-solid fa-school fs-3 position-absolute ms-4 text-muted"></i>
                                <select name="school_id" class="form-select form-select-solid w-250px ps-14" onchange="this.form.submit()">
                                    <option value="">All Schools</option>
                                    @foreach($schools as $school)
                                        <option value="{{ $school->id }}" {{ request('school_id') == $school->id ? 'selected' : '' }}>
                                            {{ $school->user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @if(request('school_id'))
                                <a href="{{ route('admin.students.evaluation.result') }}" class="btn btn-sm btn-light-primary">
                                    <i class="fa-solid fa-times me-1"></i>
                                    Clear Filter
                                </a>
                            @endif
                        </form>
                    </div>
                </div>
                <!--end::Filter Section-->
                <!--begin::Row-->
                <div class="row g-6 g-xl-9">
                    @forelse($students as $student)
                        <!--begin::Col-->
                        <div class="col-md-6 col-lg-6 col-xl-4">
                            <!--begin::Card-->
                            <div class="card card-custom card-stretch">
                                <!--begin::Card header-->
                                <div class="card-header border-0 pt-6">
                                    <!--begin::Card title-->
                                    <div class="card-title flex-column w-100">
                                        <!--begin::Student Info-->
                                        <div class="d-flex align-items-center mb-4">
                                            <!--begin::Avatar-->
                                            <div class="symbol symbol-50px symbol-circle me-3">
                                                @if($student->avatar)
                                                    <div class="symbol-label">
                                                        <img src="{{ asset('storage/' . $student->avatar) }}" alt="{{ $student->user->name }}" class="w-100"/>
                                                    </div>
                                                @else
                                                    <div class="symbol-label fs-2 fw-bold text-primary bg-light-primary">
                                                        {{ substr($student->user->name, 0, 1) }}
                                                    </div>
                                                @endif
                                            </div>
                                            <!--end::Avatar-->
                                            <!--begin::User details-->
                                            <div class="flex-grow-1">
                                                <a href="#" class="text-gray-900 text-hover-primary mb-1 fs-6 fw-bold d-block">
                                                    {{ $student->user->name }}
                                                </a>
                                                <span class="text-muted fs-7 d-block">Grade {{ $student->grade }}</span>
                                            </div>
                                            <!--end::User details-->
                                        </div>
                                        <!--end::Student Info-->

                                        <!--begin::School Badge-->
                                        <div class="bg-light-info rounded p-3 mb-4">
                                            <div class="d-flex align-items-center">
                                                <i class="fa-solid fa-school fs-4 text-info me-2"></i>
                                                <div class="flex-grow-1">
                                                    <div class="text-gray-800 fw-semibold fs-7">{{ $student->school->user->name }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::School Badge-->
                                    </div>
                                    <!--end::Card title-->
                                </div>
                                <!--end::Card header-->

                                <!--begin::Card body-->
                                <div class="card-body p-6">
                                    <!--begin::Evaluations header-->
                                    <div class="d-flex flex-column mb-6">
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <h4 class="text-gray-900 fw-bold fs-4">
                                                <i class="fa-solid fa-clipboard-check text-primary me-2"></i>
                                                Assessments
                                            </h4>
                                            <span class="badge badge-light-primary px-3 py-2 fs-7 fw-semibold">
                                                <i class="fa-solid fa-chart-bar me-2"></i>
                                                {{ $student->total_tests }} Test(s)
                                            </span>
                                        </div>
                                        <p class="text-muted fs-7 mb-0">Latest assessments and results summary</p>
                                    </div>
                                    <!--end::Evaluations header-->

                                    @if($student->has_any_tests)
                                        <!--begin::Tests container-->
                                        <div class="scroll-y pe-0" style="max-height: 300px;">
                                            @foreach($student->grouped_evaluation_tests as $bankId => $testData)
                                                <!--begin::Test item-->
                                                <a href="{{ route('admin.evaluation.result', ['bank_id' => $bankId, 'student_id' => $student->id]) }}"
                                                   class="card border-0 transition-all transition-ease bg-hover-light-primary text-decoration-none">
                                                    <div class="card-body py-1 px-4">
                                                        <div class="d-flex align-items-center">
                                                            <!--begin::Icon-->
                                                            <div class="symbol symbol-45px me-5 transition-all">
                                                                <span class="symbol-label bg-primary bg-opacity-10 transition-all">
                                                                    <i class="fa-solid fa-brain fs-2 text-primary transition-all"></i>
                                                                </span>
                                                            </div>
                                                            <!--end::Icon-->

                                                            <!--begin::Content-->
                                                            <div>
                                                                <h5 class="text-dark fw-bold mb-1 fs-6 transition-all text-truncate" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100%;">
                                                                    {{ \App\Models\QuestionBankType::find($bankId)?->getTranslation('name', app()->getLocale()) }}
                                                                </h5>

                                                                <!--begin::Meta-->
                                                                <div class="d-flex flex-column text-muted fs-7 mb-2 transition-all">
                                                                    <span class="d-flex align-items-center mb-1">
                                                                        <i class="fa-solid fa-repeat me-1"></i> Attempt: {{ $testData['latest_attempt'] }}
                                                                    </span>
                                                                    <span class="d-flex align-items-center">
                                                                        <i class="fa-solid fa-calendar-day me-1"></i> {{ $testData['last_updated']->format('M d, Y') }}
                                                                    </span>
                                                                </div>
                                                                <!--end::Meta-->
                                                            </div>
                                                            <!--end::Content-->
                                                        </div>
                                                    </div>
                                                </a>
                                                <!--end::Test item-->
                                            @endforeach
                                        </div>
                                        <!--end::Tests container-->
                                    @else
                                        <!--begin::Empty state-->
                                        <div class="text-center py-8">
                                            <div class="symbol symbol-60px mb-4">
                                                <span class="symbol-label bg-light-primary">
                                                    <i class="fa-solid fa-clipboard-question fs-2x text-primary"></i>
                                                </span>
                                            </div>
                                            <h5 class="text-gray-800 fw-bold mb-2">No Assessments Yet</h5>
                                            <p class="text-muted fs-7 mb-0">No assessments assigned yet. Please check back later.</p>
                                        </div>
                                        <!--end::Empty state-->
                                    @endif
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--end::Card-->
                        </div>
                        <!--end::Col-->
                    @empty
                        <!--begin::Empty State-->
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body text-center py-20">
                                    <i class="fa-solid fa-users fs-3x text-muted mb-5"></i>
                                    <h2 class="text-dark fw-bold mb-3">No Students Found</h2>
                                    <p class="text-muted fs-5 mb-0">
                                        @if(request('school_id'))
                                            No students found for the selected school.
                                        @else
                                            You don't have any students assigned to your schools yet.
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!--end::Empty State-->
                    @endforelse
                </div>
                <!--end::Row-->

                <!--begin::Pagination-->
                @if($students->hasPages())
                    <div class="d-flex flex-stack flex-wrap pt-10">
                        <div class="fs-6 fw-semibold text-gray-700">
                            Showing {{ $students->firstItem() }} to {{ $students->lastItem() }} of {{ $students->total() }} results
                        </div>
                        <div class="d-flex justify-content-center">
                            {{ $students->appends(request()->query())->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                @endif
                <!--end::Pagination-->
            </div>
            <!--end::Content container-->
        </div>
        <!--end::Content-->
    </div>

@endsection
