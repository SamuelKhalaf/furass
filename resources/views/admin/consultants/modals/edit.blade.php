<div class="modal fade" id="kt_modal_update_consultant" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Form-->
            <form class="form" action="#" id="kt_modal_update_consultant_form" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <!--begin::Modal header-->
                <div class="modal-header" id="kt_modal_update_consultant_header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold">{{ __('consultants.modal.update_consultant') }}</h2>
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
                    <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_update_consultant_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_update_consultant_header" data-kt-scroll-wrappers="#kt_modal_update_consultant_scroll" data-kt-scroll-offset="300px">
                        <!--begin::consultant form-->
                        <div id="kt_modal_update_consultant_consultant_info" class="collapse show">
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">{{ __('consultants.modal.consultant_name') }}</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="name" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="{{ __('consultants.modal.enter_consultant_name') }}" required />
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">{{ __('consultants.modal.email') }}</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="email" name="email" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="{{ __('consultants.modal.enter_email') }}" required />
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">{{ __('consultants.modal.bio') }}</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="bio" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="{{ __('consultants.modal.enter_bio') }}" required />
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">{{ __('consultants.modal.phone_number') }}</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="phone_number" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="{{ __('consultants.modal.enter_phone') }}" required />
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-7 fv-plugins-icon-container">
                                <!--begin::Wrapper-->
                                <div class="d-flex flex-stack">
                                    <!--begin::Label-->
                                    <div class="me-5">
                                        <label class="fs-6 fw-semibold">{{ __('users.modal.is_active') }}</label>
                                        <div class="fs-7 fw-semibold text-muted">{{ __('users.modal.is_active_help') }}</div>
                                    </div>
                                    <!--end::Label-->

                                    <!--begin::Switch-->
                                    <label class="form-check form-switch form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value="0" name="is_active">
                                        <span class="form-check-label fw-semibold text-muted">
                                        {{ __('users.modal.inactive') }}
                                    </span>
                                    </label>
                                    <!--end::Switch-->
                                </div>
                                <!--end::Wrapper-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fw-semibold fs-6 mb-2">Assign Schools</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select name="school_ids[]" id="edit_school_ids" class="form-select form-control form-control-solid mb-3 mb-lg-0" data-control="select2" multiple>
                                    <!-- Options will be populated by JS -->
                                </select>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::consultant form-->
                    </div>
                    <!--end::Scroll-->
                </div>
                <!--end::Modal body-->

                <!--begin::Modal footer-->
                <div class="modal-footer flex-center">
                    <!--begin::Button-->
                    <button type="reset" class="btn btn-light me-3" data-kt-users-modal-action="cancel">
                        {{ __('consultants.modal.discard') }}
                    </button>
                    <!--end::Button-->

                    <!--begin::Button-->
                    <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                        <span class="indicator-label">
                            {{ __('consultants.modal.submit') }}
                        </span>
                        <span class="indicator-progress">
                            {{ __('consultants.modal.please_wait') }} <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
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
@push('scripts')
    <script>
        // this part for change the user active text muted word
        $(document).ready(function () {
            $('input[name="is_active"]').on('change', function () {
                if ($(this).is(':checked')) {
                    $(this).val(1);
                    $(this).closest('.form-check').find('.form-check-label').text('{{ __('users.modal.active') }}');
                } else {
                    $(this).val(0);
                    $(this).closest('.form-check').find('.form-check-label').text('{{ __('users.modal.inactive') }}');
                }
            });
        });
    </script>
@endpush
