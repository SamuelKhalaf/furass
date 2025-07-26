<div class="modal fade" id="kt_modal_add_workshop" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-750px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header" id="kt_modal_add_workshop_header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">{{ __('workshops.modal.add_workshop') }}</h2>
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
                <form id="kt_modal_add_workshop_form" class="form" action="{{ route('admin.workshops.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!--begin::Scroll-->
                    <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_workshop_scroll"
                         data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                         data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_workshop_header"
                         data-kt-scroll-wrappers="#kt_modal_add_workshop_scroll" data-kt-scroll-offset="300px">
                        <!--begin::Input group-->
                        <div class="row g-5 mb-7">
                            <div class="col-md-6 fv-row">
                                <label class="required fw-semibold fs-6 mb-2">{{ __('workshops.modal.workshop_name') }}</label>
                                <input type="text" name="event_name" class="form-control form-control-solid" placeholder="{{ __('workshops.modal.enter_workshop_name') }}" required/>
                            </div>
                            <div class="col-md-6 fv-row">
                                <label class="required fw-semibold fs-6 mb-2">{{ __('workshops.modal.company_name') }}</label>
                                <input type="text" name="company_name" class="form-control form-control-solid" placeholder="{{ __('workshops.modal.enter_company_name') }}" required/>
                            </div>
                        </div>

                        <div class="fv-row mb-7">
                            <label class="required fw-semibold fs-6 mb-2">{{ __('workshops.modal.location') }}</label>
                            <input type="text" name="location" class="form-control form-control-solid" placeholder="{{ __('workshops.modal.enter_location') }}" required/>
                        </div>

                        <div class="row g-5 mb-7">
                            <div class="col-md-6 fv-row mb-7">
                                <label class="required fw-semibold fs-6 mb-2">{{__('workshops.modal.event_start_date')}}</label>
                                <input type="text" name="start_date" placeholder="{{__('workshops.modal.select_start_date')}}" class="form-control form-control-solid flatpickr-input" required/>
                            </div>
                            <div class="col-md-6 fv-row mb-7">
                                <label class="required fw-semibold fs-6 mb-2">{{__('workshops.modal.event_end_date')}}</label>
                                <input type="text" name="end_date" placeholder="{{__('workshops.modal.select_end_date')}}" class="form-control form-control-solid flatpickr-input" required/>
                            </div>
                        </div>

                        <div class="row g-5 mb-7">
                            <div class="col-md-6 fv-row">
                                <label class="fs-6 fw-semibold mb-2">
                                    <span>{{ __('workshops.modal.media') }}</span>
                                    <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="{{ __('workshops.modal.allowed_media') }}"></i>
                                </label>
                                <input type="file" id="media" name="media" class="form-control form-control-solid" accept="image/*,video/*,application/pdf" />
                            </div>
                            <div class="col-md-6 fv-row">
                                <label class="fs-6 fw-semibold mb-2">
                                    <span>{{ __('workshops.modal.document') }}</span>
                                    <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="{{ __('workshops.modal.allowed_documents') }}"></i>
                                </label>
                                <input type="file" id="document" name="document" class="form-control form-control-solid" accept=".pdf,.doc,.docx,.xls,.xlsx,.txt" />
                            </div>
                        </div>

                        <div class="fv-row mb-7">
                            <label class="fw-semibold fs-6 mb-2">{{ __('workshops.modal.description') }}</label>
                            <textarea name="description" class="form-control form-control-solid" rows="3" placeholder="{{ __('workshops.modal.enter_description') }}"></textarea>
                        </div>
                    </div>
                    <!--end::Scroll-->
                    <!--begin::Actions-->
                    <div class="text-center pt-15">
                        <button type="reset" class="btn btn-light me-3" data-kt-users-modal-action="cancel">
                            {{ __('workshops.modal.discard') }}
                        </button>

                        <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                            <span class="indicator-label">{{ __('workshops.modal.submit') }}</span>
                            <span class="indicator-progress">
                                {{ __('workshops.modal.please_wait') }}
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

@push('scripts')
    <script>

    </script>
@endpush
