<div class="modal fade" id="kt_modal_add_school" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header" id="kt_modal_add_school_header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">{{ __('valueQuestion.modal.add_school') }}</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close">
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                    <span class="svg-icon svg-icon-1">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                  transform="rotate(-45 6 17.3137)" fill="currentColor"/>
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)"
                                  fill="currentColor"/>
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </div>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <!--begin::Form-->
                <form id="kt_modal_add_school_form" class="form" action="{{ route('admin.questionValue.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!--begin::Scroll-->
                    <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_school_scroll"
                         data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                         data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_school_header"
                         data-kt-scroll-wrappers="#kt_modal_add_school_scroll" data-kt-scroll-offset="300px">
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">{{ __('valueQuestion.modal.enter_value_name_ar') }}</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="name_ar" class="form-control form-control-solid mb-3 mb-lg-0"
                                   placeholder="{{ __('valueQuestion.modal.enter_value_name_ar') }}" required/>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">{{ __('valueQuestion.modal.value_name') }}</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="name_en" class="form-control form-control-solid mb-3 mb-lg-0"
                                   placeholder="{{ __('valueQuestion.modal.enter_value_name_en') }}" required/>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">{{ __('valueQuestion.modal.question_bank') }}</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <select id="question-bank-list" name="question_bank_type_id" class="form-select" required>
                                <option>Select a question bank</option>
                                <!-- Options will be populated here -->
                            </select>

                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class=" fw-semibold fs-6 mb-2">{{ __('valueQuestion.modal.value_name') }}</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <select id="value-question-list" name="parent_id" class="form-select">
                                <option value="">Select a value Question</option>
                                <!-- Options will be populated here -->
                            </select>

                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                    </div>
                    <!--end::Scroll-->
                    <!--begin::Actions-->
                    <div class="text-center pt-15">
                        <button type="reset" class="btn btn-light me-3" data-kt-users-modal-action="cancel">{{ __('schools.modal.discard') }}</button>
                        <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                            <span class="indicator-label">{{ __('schools.modal.submit') }}</span>
                            <span class="indicator-progress">
                                {{ __('schools.modal.please_wait') }}
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                    <!--end::Actions-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
