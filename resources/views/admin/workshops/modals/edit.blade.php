<!--begin::Modal - Update Workshop-->
<div class="modal fade" id="kt_modal_update_workshop" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-750px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Form-->
            <form class="form" id="kt_modal_update_workshop_form" method="POST" enctype="multipart/form-data" novalidate="novalidate">
                @csrf
                @method('PUT')

                <!--begin::Modal header-->
                <div class="modal-header" id="kt_modal_update_workshop_header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold">{{ __('workshops.modal.update_workshop') }}</h2>
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
                    <div class="scroll-y me-n7 pe-7" id="kt_modal_update_workshop_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_update_workshop_header" data-kt-scroll-wrappers="#kt_modal_update_workshop_scroll" data-kt-scroll-offset="300px">
                        <!--begin::Input group-->
                        <div class="row g-9 mb-7">
                            <!--begin::Col-->
                            <div class="col-md-6 fv-row">
                                <label class="required fs-6 fw-semibold mb-2">{{ __('workshops.modal.workshop_name') }}</label>
                                <input type="text" class="form-control form-control-lg form-control-solid" name="event_name" placeholder="{{ __('workshops.modal.enter_workshop_name') }}" required />
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                            </div>
                            <!--end::Col-->

                            <!--begin::Col-->
                            <div class="col-md-6 fv-row">
                                <label class="required fs-6 fw-semibold mb-2">{{ __('workshops.modal.company_name') }}</label>
                                <input type="text" class="form-control form-control-lg form-control-solid" name="company_name" placeholder="{{ __('workshops.modal.enter_company_name') }}" required />
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <div class="fv-row mb-7">
                            <label class="required fw-semibold fs-6 mb-2">{{ __('workshops.modal.location') }}</label>
                            <input type="text" name="location" class="form-control form-control-solid" placeholder="{{ __('workshops.modal.enter_location') }}" required/>
                        </div>

                        <!--begin::Input group-->
                        <div class="row g-9 mb-7">
                            <div class="col-md-6 fv-row mb-7">
                                <label class="required fw-semibold fs-6 mb-2">{{__('workshops.modal.event_start_date')}}</label>
                                <input type="text" name="start_date" placeholder="{{__('workshops.modal.select_start_date')}}" class="form-control form-control-solid flatpickr-input" required/>
                            </div>
                            <div class="col-md-6 fv-row mb-7">
                                <label class="required fw-semibold fs-6 mb-2">{{__('workshops.modal.event_end_date')}}</label>
                                <input type="text" name="end_date" placeholder="{{__('workshops.modal.select_end_date')}}" class="form-control form-control-solid flatpickr-input" required/>
                            </div>
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row g-9 mb-7">
                            <!--begin::Col-->
                            <div class="col-12 fv-row">
                                <label class="fs-6 fw-semibold mb-2">{{ __('workshops.modal.description') }}</label>
                                <textarea class="form-control form-control-lg form-control-solid" name="description" rows="3" placeholder="{{ __('workshops.modal.enter_description') }}"></textarea>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row g-9 mb-7">
                            <!--begin::Col-->
                            <div class="col-md-6 fv-row">
                                <label class="fs-6 fw-semibold mb-2">
                                    <span>{{ __('workshops.modal.media') }}</span>
                                    <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="{{ __('workshops.modal.allowed_media') }}"></i>
                                </label>
                                <div class="position-relative">
                                    <input type="file" id="edit_media" name="media" class="form-control form-control-lg form-control-solid" accept="image/*,video/*" />
                                    <input type="hidden" id="current_media_path" name="current_media_path" value="">
                                </div>
                                <div class="d-flex align-items-center mt-2">
                                    <button type="button" id="edit_media_preview_btn" class="btn btn-icon btn-sm btn-light-primary me-2 d-none preview-trigger" data-content="">
                                        <i class="bi bi-eye fs-4"></i>
                                    </button>
                                    <button type="button" id="remove_media_btn" class="btn btn-icon btn-sm btn-light-danger me-2 d-none">
                                        <i class="bi bi-trash fs-4"></i>
                                    </button>
                                    <span id="current_media_name" class="text-muted fs-7"></span>
                                </div>
                            </div>
                            <!--end::Col-->

                            <!--begin::Col-->
                            <div class="col-md-6 fv-row">
                                <label class="fs-6 fw-semibold mb-2">
                                    <span>{{ __('workshops.modal.document') }}</span>
                                    <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="{{ __('workshops.modal.allowed_documents') }}"></i>
                                </label>
                                <div class="position-relative">
                                    <input type="file" id="edit_document" name="document" class="form-control form-control-lg form-control-solid" accept=".pdf,.doc,.docx,.txt" />
                                    <input type="hidden" id="current_document_path" name="current_document_path" value="">
                                </div>
                                <div class="d-flex align-items-center mt-2">
                                    <button type="button" id="edit_document_preview_btn" class="btn btn-icon btn-sm btn-light-primary me-2 d-none preview-trigger" data-content="">
                                        <i class="bi bi-eye fs-4"></i>
                                    </button>
                                    <button type="button" id="remove_document_btn" class="btn btn-icon btn-sm btn-light-danger me-2 d-none">
                                        <i class="bi bi-trash fs-4"></i>
                                    </button>
                                    <span id="current_document_name" class="text-muted fs-7"></span>
                                </div>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row g-9 mb-7">
                            <!--begin::Col-->
                            <div class="col-12 fv-row">
                                <label class="fs-6 fw-semibold mb-2">{{ __('workshops.modal.programs') }}</label>
                                <select name="program_ids[]" id="edit_program_ids" class="form-select form-select-solid" data-control="select2" data-close-on-select="false" data-placeholder="{{ __('workshops.modal.select_programs') }}" multiple="multiple" required>
                                    @foreach(\App\Models\Program::all() as $program)
                                        <option value="{{ $program->id }}">{{app()->getLocale() == 'ar' ? $program->title_ar : $program->title_en }}</option>
                                    @endforeach
                                </select>
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->
                    </div>
                    <!--end::Scroll-->
                </div>
                <!--end::Modal body-->

                <!--begin::Modal footer-->
                <div class="modal-footer flex-center">
                    <!--begin::Button-->
                    <button type="reset" class="btn btn-light me-3" data-kt-users-modal-action="cancel">
                        {{ __('workshops.modal.discard') }}
                    </button>
                    <!--end::Button-->

                    <!--begin::Button-->
                    <button type="submit" id="kt_modal_update_workshop_submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                        <span class="indicator-label">{{ __('workshops.modal.submit') }}</span>
                        <span class="indicator-progress">
                            {{ __('workshops.modal.please_wait') }}
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
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
<!--end::Modal - Update Workshop-->

@push('scripts')

@endpush
