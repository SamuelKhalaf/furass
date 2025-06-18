<!--begin::Modal - Update Trip-->
<div class="modal fade" id="kt_modal_update_trip" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-750px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Form-->
            <form class="form" id="kt_modal_update_trip_form" method="POST" enctype="multipart/form-data" novalidate="novalidate">
                @csrf
                @method('PUT')

                <!--begin::Modal header-->
                <div class="modal-header" id="kt_modal_update_trip_header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold">{{ __('trips.modal.update_trip') }}</h2>
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
                    <div class="scroll-y me-n7 pe-7" id="kt_modal_update_trip_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_update_trip_header" data-kt-scroll-wrappers="#kt_modal_update_trip_scroll" data-kt-scroll-offset="300px">
                        <!--begin::Input group-->
                        <div class="row g-9 mb-7">
                            <!--begin::Col-->
                            <div class="col-md-6 fv-row">
                                <label class="required fs-6 fw-semibold mb-2">{{ __('trips.modal.trip_name') }}</label>
                                <input type="text" class="form-control form-control-lg form-control-solid" name="event_name" placeholder="{{ __('trips.modal.enter_trip_name') }}" required />
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                            </div>
                            <!--end::Col-->

                            <!--begin::Col-->
                            <div class="col-md-6 fv-row">
                                <label class="required fs-6 fw-semibold mb-2">{{ __('trips.modal.company_name') }}</label>
                                <input type="text" class="form-control form-control-lg form-control-solid" name="company_name" placeholder="{{ __('trips.modal.enter_company_name') }}" required />
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row g-9 mb-7">
                            <!--begin::Col-->
                            <div class="col-md-6 fv-row">
                                <label class="required fs-6 fw-semibold mb-2">{{ __('trips.modal.location') }}</label>
                                <input type="text" class="form-control form-control-lg form-control-solid" name="location" placeholder="{{ __('trips.modal.enter_location') }}" required />
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                            </div>
                            <!--end::Col-->

                            <!--begin::Col-->
                            <div class="col-md-6 fv-row">
                                <label class="required fs-6 fw-semibold mb-2">{{ __('trips.modal.event_date_time') }}</label>
                                <input type="text" placeholder="Select Date & Time " class="form-control form-control-lg form-control-solid flatpickr-input" name="event_time" required />
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row g-9 mb-7">
                            <!--begin::Col-->
                            <div class="col-12 fv-row">
                                <label class="fs-6 fw-semibold mb-2">{{ __('trips.modal.description') }}</label>
                                <textarea class="form-control form-control-lg form-control-solid" name="description" rows="3" placeholder="{{ __('trips.modal.enter_description') }}"></textarea>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row g-9 mb-7">
                            <!--begin::Col-->
                            <div class="col-md-6 fv-row">
                                <label class="fs-6 fw-semibold mb-2">
                                    <span>{{ __('trips.modal.media') }}</span>
                                    <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="{{ __('trips.modal.allowed_media') }}"></i>
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
                                    <span>{{ __('trips.modal.document') }}</span>
                                    <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="{{ __('trips.modal.allowed_documents') }}"></i>
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
                                <label class="fs-6 fw-semibold mb-2">{{ __('trips.modal.programs') }}</label>
                                <select name="program_ids[]" id="edit_program_ids" class="form-select form-select-solid" data-control="select2" data-close-on-select="false" data-placeholder="{{ __('trips.modal.select_programs') }}" multiple="multiple" required>
                                    @foreach(\App\Models\Program::all() as $program)
                                        <option value="{{ $program->id }}">{{ $program->title }}</option>
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
                        {{ __('trips.modal.discard') }}
                    </button>
                    <!--end::Button-->

                    <!--begin::Button-->
                    <button type="submit" id="kt_modal_update_trip_submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                        <span class="indicator-label">{{ __('trips.modal.submit') }}</span>
                        <span class="indicator-progress">
                            {{ __('trips.modal.please_wait') }}
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
<!--end::Modal - Update Trip-->

@push('scripts')

@endpush
