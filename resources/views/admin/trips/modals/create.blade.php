<div class="modal fade" id="kt_modal_add_trip" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-750px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header" id="kt_modal_add_trip_header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">{{ __('trips.modal.add_trip') }}</h2>
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
                <form id="kt_modal_add_trip_form" class="form" action="{{ route('admin.trips.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!--begin::Scroll-->
                    <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_trip_scroll"
                         data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                         data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_trip_header"
                         data-kt-scroll-wrappers="#kt_modal_add_trip_scroll" data-kt-scroll-offset="300px">
                        <!--begin::Input group-->
                        <div class="row g-5 mb-7">
                            <div class="col-md-6 fv-row">
                                <label class="required fw-semibold fs-6 mb-2">{{ __('trips.modal.trip_name') }}</label>
                                <input type="text" name="event_name" class="form-control form-control-solid" placeholder="{{ __('trips.modal.enter_trip_name') }}" required/>
                            </div>
                            <div class="col-md-6 fv-row">
                                <label class="required fw-semibold fs-6 mb-2">{{ __('trips.modal.company_name') }}</label>
                                <input type="text" name="company_name" class="form-control form-control-solid" placeholder="{{ __('trips.modal.enter_company_name') }}" required/>
                            </div>
                        </div>

                        <div class="fv-row mb-7">
                            <label class="required fw-semibold fs-6 mb-2">{{ __('trips.modal.location') }}</label>
                            <input type="text" name="location" class="form-control form-control-solid" placeholder="{{ __('trips.modal.enter_location') }}" required/>
                        </div>

                        <div class="row g-5 mb-7">
                            <div class="col-md-6 fv-row mb-7">
                                <label class="required fw-semibold fs-6 mb-2">{{__('trips.modal.event_start_date')}}</label>
                                <input type="text" name="start_date" placeholder="{{__('trips.modal.select_start_date')}}" class="form-control form-control-solid flatpickr-input" required/>
                            </div>
                            <div class="col-md-6 fv-row mb-7">
                                <label class="required fw-semibold fs-6 mb-2">{{__('trips.modal.event_end_date')}}</label>
                                <input type="text" name="end_date" placeholder="{{__('trips.modal.select_end_date')}}" class="form-control form-control-solid flatpickr-input" required/>
                            </div>
                        </div>

                        <div class="row g-5 mb-7">
                            <div class="col-md-6 fv-row">
                                <label class="fs-6 fw-semibold mb-2">
                                    <span>{{ __('trips.modal.media') }}</span>
                                    <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="{{ __('trips.modal.allowed_media') }}"></i>
                                </label>
                                <input type="file" id="media" name="media" class="form-control form-control-solid" accept="image/*,video/*,application/pdf" />
                            </div>
                            <div class="col-md-6 fv-row">
                                <label class="fs-6 fw-semibold mb-2">
                                    <span>{{ __('trips.modal.document') }}</span>
                                    <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="{{ __('trips.modal.allowed_documents') }}"></i>
                                </label>
                                <input type="file" id="document" name="document" class="form-control form-control-solid" accept=".pdf,.doc,.docx,.xls,.xlsx,.txt" />
                            </div>
                        </div>

                        <div class="fv-row mb-7">
                            <label class="fw-semibold fs-6 mb-2">{{ __('trips.modal.description') }}</label>
                            <textarea name="description" class="form-control form-control-solid" rows="3" placeholder="{{ __('trips.modal.enter_description') }}"></textarea>
                        </div>

                        <div class="fv-row mb-7">
                            <label class="fw-semibold fs-6 mb-2">{{ __('trips.modal.programs') }}</label>
                            <select name="program_ids[]" class="form-select form-select-solid" data-control="select2" data-close-on-select="false" data-placeholder="{{ __('trips.modal.select_programs') }}" multiple="multiple" required>
                                @foreach(\App\Models\Program::all() as $program)
                                    <option value="{{ $program->id }}">{{app()->getLocale() == 'ar' ? $program->title_ar : $program->title_en }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!--end::Scroll-->
                    <!--begin::Actions-->
                    <div class="text-center pt-15">
                        <button type="reset" class="btn btn-light me-3" data-kt-users-modal-action="cancel">
                            {{ __('trips.modal.discard') }}
                        </button>

                        <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                            <span class="indicator-label">{{ __('trips.modal.submit') }}</span>
                            <span class="indicator-progress">
                                {{ __('trips.modal.please_wait') }}
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
