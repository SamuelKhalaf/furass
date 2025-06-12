<div class="modal fade" id="kt_modal_update_details" tabindex="-1" aria-hidden="true">
<!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Form-->
            <form class="form" action="#" id="kt_modal_update_user_form" data-user-id="">
                <!--begin::Modal header-->
                <div class="modal-header" id="kt_modal_update_user_header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold">{{ __('students.modal.update_student') }}</h2>
                    <!--end::Modal title-->

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close">
                        <span class="svg-icon svg-icon-1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                            </svg>
                        </span>
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->

                <!--begin::Modal body-->
                <div class="modal-body py-10 px-lg-17">
                    <!--begin::Scroll-->
                    <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_update_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_update_user_header" data-kt-scroll-wrappers="#kt_modal_update_user_scroll" data-kt-scroll-offset="300px" style="max-height: 121px;">

                        <!--begin::User form-->
                        <div id="kt_modal_update_user_user_info" class="collapse show">
                            @csrf
                            @method('PUT')
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">{{ __('students.modal.student_name') }}</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="name" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="{{ __('students.modal.enter_student_name') }}" />
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">{{ __('students.modal.email') }}</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="email" name="email" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="{{ __('students.modal.enter_email') }}" />
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">{{ __('students.modal.phone_number') }}</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="phone_number" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="{{ __('students.modal.enter_phone') }}" />
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">{{ __('students.modal.school') }}</label>
                                <!--end::Label-->
                                <!--begin::Select-->
                                <select name="school_id" class="form-select form-control-solid">
                                    <option value="">{{ __('students.modal.select_school') }}</option>
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
                                <label class="required fw-semibold fs-6 mb-2">{{ __('students.modal.grade') }}</label>
                                <!--end::Label-->
                                <!--begin::Select-->
                                <select name="grade" class="form-select form-control-solid">
                                    <option value="">{{ __('students.modal.select_grade') }}</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                </select>
                                <!--end::Select-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">{{ __('students.modal.birth_date') }}</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="date" name="birth_date" id="student_birth_date_edit" class="form-control form-control-solid mb-3 mb-lg-0"/>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">{{ __('students.modal.gender') }}</label>
                                <!--end::Label-->
                                <!--begin::Select-->
                                <select name="gender" class="form-select form-control-solid">
                                    <option value="">{{ __('students.modal.select_gender') }}</option>
                                    <option value="male">{{ __('students.modal.male') }}</option>
                                    <option value="female">{{ __('students.modal.female') }}</option>
                                </select>
                                <!--end::Select-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fw-semibold fs-6 mb-2">{{ __('students.modal.avatar') }}</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="file" name="avatar" class="form-control form-control-solid mb-3 mb-lg-0"
                                       accept="image/*"/>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::User form-->
                    </div>
                    <!--end::Scroll-->
                </div>
                <!--end::Modal body-->

                <!--begin::Modal footer-->
                <div class="modal-footer flex-center">
                    <!--begin::Button-->
                    <button type="reset" class="btn btn-light me-3" data-kt-users-modal-action="cancel">
                        {{ __('students.modal.discard') }}
                    </button>
                    <!--end::Button-->

                    <!--begin::Button-->
                    <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                        <span class="indicator-label">
                            {{ __('students.modal.submit') }}
                        </span>
                        <span class="indicator-progress">
                            {{ __('students.modal.please_wait') }} <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                    <!--end::Button-->
                </div>
                <!--end::Modal footer-->
            </form>
            <!--end::Form-->
        </div>
    </div>
</div>
