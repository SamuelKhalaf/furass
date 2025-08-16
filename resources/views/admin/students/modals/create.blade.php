<div class="modal fade" id="kt_modal_add_user" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header" id="kt_modal_add_user_header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">{{ __('students.modal.add_student') }}</h2>
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
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <!--begin::Form-->
                <form id="kt_modal_add_user_form" class="form" action="#">
                    <!--begin::Scroll-->
                    <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_user_scroll"
                         data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                         data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header"
                         data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">
                        @csrf
                        <!--begin::Row-->
                        <div class="row g-5 mb-7">
                            <!--begin::Col-->
                            <div class="col-md-6">
                                <!--begin::Input group-->
                                <div class="fv-row mb-7">
                                    <label class="required fw-semibold fs-6 mb-2">{{ __('students.modal.student_name') }}</label>
                                    <input type="text" name="name" class="form-control form-control-solid mb-3 mb-lg-0"
                                           placeholder="{{ __('students.modal.enter_student_name') }}"/>
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--end::Col-->

                            <!--begin::Col-->
                            <div class="col-md-6">
                                <!--begin::Input group-->
                                <div class="fv-row mb-7">
                                    <label class="required fw-semibold fs-6 mb-2">{{ __('students.modal.email') }}</label>
                                    <input type="email" name="email" class="form-control form-control-solid mb-3 mb-lg-0"
                                           placeholder="{{ __('students.modal.enter_email') }}"/>
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->

                        <!--begin::Row-->
                        <div class="row g-5 mb-7">
                            <!--begin::Col-->
                            <div class="col-md-6">
                                <!--begin::Input group-->
                                <div class="fv-row mb-7">
                                    <label class="required fw-semibold fs-6 mb-2">{{ __('students.modal.phone_number') }}</label>
                                    <input type="number" name="phone_number"
                                           class="form-control form-control-solid mb-3 mb-lg-0" placeholder="{{ __('students.modal.enter_phone') }}"/>
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--end::Col-->

                            <!--begin::Col-->
                            <div class="col-md-6">
                                <!--begin::Input group-->
                                <div class="fv-row mb-7">
                                    <label class="required fw-semibold fs-6 mb-2">{{ __('students.modal.student_id_number') }}</label>
                                    <input type="text" name="student_id_number" class="form-control form-control-solid mb-3 mb-lg-0"
                                           placeholder="{{ __('students.modal.enter_student_id') }}"/>
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->

                        <!--begin::Row-->
                        <div class="row g-5 mb-7">
                            <!--begin::Col-->
                            <div class="col-md-6">
                                <!--begin::Input group-->
                                <div class="fv-row mb-7">
                                    <label class="required fw-semibold fs-6 mb-2">{{ __('students.modal.school') }}</label>
                                    <select name="school_id" class="form-select form-control-solid">
                                        <option value="">{{ __('students.modal.select_school') }}</option>
                                        @foreach($schools as $school)
                                            <option value="{{ $school->id }}">{{ $school->user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--end::Col-->

                            <!--begin::Col-->
                            <div class="col-md-6">
                                <!--begin::Input group-->
                                <div class="fv-row mb-7">
                                    <label class="required fw-semibold fs-6 mb-2">{{ __('students.modal.grade') }}</label>
                                    <select name="grade" class="form-select form-control-solid">
                                        <option value="">{{ __('students.modal.select_grade') }}</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                    </select>
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->

                        <!--begin::Row-->
                        <div class="row g-5 mb-7">
                            <!--begin::Col-->
                            <div class="col-md-6">
                                <!--begin::Input group-->
                                <div class="fv-row mb-7">
                                    <label class="required fw-semibold fs-6 mb-2">{{ __('students.modal.birth_date') }}</label>
                                    <input type="date" name="birth_date" id="student_birth_date" class="form-control form-control-solid mb-3 mb-lg-0"/>
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--end::Col-->

                            <!--begin::Col-->
                            <div class="col-md-6">
                                <!--begin::Input group-->
                                <div class="fv-row mb-7">
                                    <label class="required fw-semibold fs-6 mb-2">{{ __('students.modal.gender') }}</label>
                                    <select name="gender" class="form-select form-control-solid">
                                        <option value="">{{ __('students.modal.select_gender') }}</option>
                                        <option value="male">{{ __('students.modal.male') }}</option>
                                        <option value="female">{{ __('students.modal.female') }}</option>
                                    </select>
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->

                        <!--begin::Row-->
                        <div class="row g-5 mb-7">
                            <!--begin::Col-->
                            <div class="col-md-6">
                                <!--begin::Input group-->
                                <div class="fv-row mb-7">
                                    <label class="required fw-semibold fs-6 mb-2">{{ __('students.modal.password') }}</label>
                                    <input type="password" name="password"
                                           class="form-control form-control-solid mb-3 mb-lg-0"/>
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--end::Col-->

                            <!--begin::Col-->
                            <div class="col-md-6">
                                <!--begin::Input group-->
                                <div class="fv-row mb-7">
                                    <label class="required fw-semibold fs-6 mb-2">{{ __('students.modal.confirm_password') }}</label>
                                    <input type="password" name="password_confirmation"
                                           class="form-control form-control-solid mb-3 mb-lg-0"/>
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->

                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <label class="fw-semibold fs-6 mb-2">{{ __('students.modal.avatar') }}</label>
                            <input type="file" name="avatar" class="form-control form-control-solid mb-3 mb-lg-0"
                                   accept="image/*"/>
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="fv-row mb-7 fv-plugins-icon-container">
                            <div class="d-flex flex-stack">
                                <div class="me-5">
                                    <label class="fs-6 fw-semibold">{{ __('users.modal.is_active') }}</label>
                                    <div class="fs-7 fw-semibold text-muted">{{ __('users.modal.is_active_help') }}</div>
                                </div>
                                <label class="form-check form-switch form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="0" name="is_active">
                                    <span class="form-check-label fw-semibold text-muted">
                                        {{ __('users.modal.inactive') }}
                                    </span>
                                </label>
                            </div>
                        </div>
                        <!--end::Input group-->

                        <!-- Parent Information Section -->
                        <div class="separator separator-dashed my-5"></div>
                        <h5 class="mb-5">{{ __('students.modal.parent_information') }}</h5>

                        <!--begin::Row-->
                        <div class="row g-5 mb-7">
                            <!--begin::Col-->
                            <div class="col-md-6">
                                <!--begin::Input group-->
                                <div class="fv-row mb-7">
                                    <label class="fw-semibold fs-6 mb-2">{{ __('students.modal.parent_name') }}</label>
                                    <input type="text" name="parent_name" class="form-control form-control-solid mb-3 mb-lg-0"
                                           placeholder="{{ __('students.modal.enter_parent_name') }}"/>
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--end::Col-->

                            <!--begin::Col-->
                            <div class="col-md-6">
                                <!--begin::Input group-->
                                <div class="fv-row mb-7">
                                    <label class="fw-semibold fs-6 mb-2">{{ __('students.modal.parent_phone') }}</label>
                                    <input type="text" name="parent_phone" class="form-control form-control-solid mb-3 mb-lg-0"
                                           placeholder="{{ __('students.modal.enter_parent_phone') }}"/>
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->

                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <label class="fw-semibold fs-6 mb-2">{{ __('students.modal.parent_relationship') }}</label>
                            <select name="parent_relationship" class="form-select form-control-solid">
                                <option value="">{{ __('students.modal.select_relationship') }}</option>
                                @foreach(App\Models\Student::relationshipOptions() as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!--end::Input group-->
                    </div>
                    <!--end::Scroll-->
                    <!--begin::Actions-->
                    <div class="text-center pt-15">
                        <button type="reset" class="btn btn-light me-3" data-kt-users-modal-action="cancel">{{ __('students.modal.discard') }}</button>
                        <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                            <span class="indicator-label">{{ __('students.modal.submit') }}</span>
                            <span class="indicator-progress">
                                {{ __('students.modal.please_wait') }}
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
