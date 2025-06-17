<div class="modal fade" id="kt_modal_add_consultation" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header" id="kt_modal_add_consultation_header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">{{ __('consultations.modal.add_consultation') }}</h2>
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
                <form id="kt_modal_add_consultation_form" class="form" action="{{ route('admin.consultations.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!--begin::Scroll-->
                    <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_consultation_scroll"
                         data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                         data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_consultation_header"
                         data-kt-scroll-wrappers="#kt_modal_add_consultation_scroll" data-kt-scroll-offset="300px">
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">{{ __('consultations.modal.consultant') }}</label>
                            <!--end::Label-->
                            <!--begin::Select-->
                            <select name="consultant_id" class="form-select form-control-solid">
                                <option value="">{{ __('consultations.modal.select_consultant') }}</option>
                                @foreach($consultants as $consultant)
                                    <option value="{{ $school->id }}">{{ $school->user->name }}</option>
                                @endforeach
                            </select>
                            <!--end::Select-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">{{ __('consultations.modal.school') }}</label>
                            <!--end::Label-->
                            <!--begin::Select-->
                            <select name="school_id" class="form-select form-control-solid">
                                <option value="">{{ __('consultations.modal.select_school') }}</option>
                                @foreach($schools as $school)
                                    <option value="{{ $school->id }}">{{ $school->user->name }}</option>
                                @endforeach
                            </select>
                            <!--end::Select-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">{{ __('consultations.modal.email') }}</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="email" name="email" class="form-control form-control-solid mb-3 mb-lg-0"
                                   placeholder="{{ __('consultations.modal.enter_email') }}" required/>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">{{ __('consultations.modal.bio') }}</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="bio" class="form-control form-control-solid mb-3 mb-lg-0"
                                   placeholder="{{ __('consultations.modal.enter_bio') }}" required/>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">{{ __('consultations.modal.phone_number') }}</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="phone_number"
                                   class="form-control form-control-solid mb-3 mb-lg-0" placeholder="{{ __('consultations.modal.enter_phone') }}" required/>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">{{ __('consultations.modal.password') }}</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="password" name="password"
                                   class="form-control form-control-solid mb-3 mb-lg-0"/>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">{{ __('consultations.modal.confirm_password') }}</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="password" name="password_confirmation"
                                   class="form-control form-control-solid mb-3 mb-lg-0"/>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                    </div>
                    <!--end::Scroll-->
                    <!--begin::Actions-->
                    <div class="text-center pt-15">
                        <button type="reset" class="btn btn-light me-3" data-kt-users-modal-action="cancel">{{ __('consultations.modal.discard') }}</button>
                        <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                            <span class="indicator-label">{{ __('consultations.modal.submit') }}</span>
                            <span class="indicator-progress">
                                {{ __('consultations.modal.please_wait') }}
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
