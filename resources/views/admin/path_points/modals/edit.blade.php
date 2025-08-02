<div class="modal fade" id="kt_modal_update_path_point" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Form-->
            <form class="form" action="#" id="kt_modal_update_path_point_form" data-path-point-id="">
                <!--begin::Modal header-->
                <div class="modal-header" id="kt_modal_update_path_point_header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold">Update Path Point</h2>
                    <!--end::Modal title-->

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-path-points-modal-action="close">
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
                    <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_update_path_point_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_update_path_point_header" data-kt-scroll-wrappers="#kt_modal_update_path_point_scroll" data-kt-scroll-offset="300px" style="max-height: 121px;">

                        <!--begin::Path Point form-->
                        <div id="kt_modal_update_path_point_info" class="collapse show">
                            @csrf
                            @method('PUT')
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Arabic Title</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="title_ar" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Enter Arabic title" />
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">English Title</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="title_en" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Enter English title" />
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Point Type</label>
                                <!--end::Label-->
                                <!--begin::Select-->
                                <select name="table_name" class="form-select form-control-solid">
                                    <option value="">Select Point Type</option>
                                    <option value="evaluation_tests">Evaluation Tests</option>
                                    <option value="consultations">Consultations</option>
                                    <option value="events">Events</option>
                                </select>
                                <!--end::Select-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fw-semibold fs-6 mb-2">Grade</label>
                                <!--end::Label-->
                                <!--begin::Select-->
                                <select name="grade" class="form-select form-control-solid">
                                    <option value="">Select Grade</option>
                                    <option value="10">Grade 10</option>
                                    <option value="11">Grade 11</option>
                                    <option value="12">Grade 12</option>
                                </select>
                                <!--end::Select-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group - Event (conditional)-->
                            <div class="fv-row mb-7" id="event_group_edit" style="display: none;">
                                <!--begin::Label-->
                                <label class="fw-semibold fs-6 mb-2">Event</label>
                                <!--end::Label-->
                                <!--begin::Select-->
                                <select name="event_id" class="form-select form-control-solid">
                                    <option value="">Select Event</option>
                                    @foreach($events as $event)
                                        <option value="{{ $event->id }}">{{ $event->event_name }}</option>
                                    @endforeach
                                </select>
                                <!--end::Select-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group - Question Bank Type (conditional)-->
                            <div class="fv-row mb-7" id="question_bank_group_edit" style="display: none;">
                                <!--begin::Label-->
                                <label class="fw-semibold fs-6 mb-2">Question Bank Type</label>
                                <!--end::Label-->
                                <!--begin::Select-->
                                <select name="question_bank_type_id" class="form-select form-control-solid">
                                    <option value="">Select Question Bank Type</option>
                                    @foreach($questionBankTypes as $questionBankType)
                                        <option value="{{ $questionBankType->id }}">{{ $questionBankType->name }}</option>
                                    @endforeach
                                </select>
                                <!--end::Select-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Path Point form-->
                    </div>
                    <!--end::Scroll-->
                </div>
                <!--end::Modal body-->

                <!--begin::Modal footer-->
                <div class="modal-footer flex-center">
                    <!--begin::Button-->
                    <button type="reset" class="btn btn-light me-3" data-kt-path-points-modal-action="cancel">
                        Discard
                    </button>
                    <!--end::Button-->

                    <!--begin::Button-->
                    <button type="submit" class="btn btn-primary" data-kt-path-points-modal-action="submit">
                        <span class="indicator-label">
                            Submit
                        </span>
                        <span class="indicator-progress">
                            Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
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
