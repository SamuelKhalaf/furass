<div class="modal fade" id="kt_modal_add_notification" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-750px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Form-->
            <form class="form" action="#" id="kt_modal_add_notification_form" enctype="multipart/form-data">
                @csrf
                <!--begin::Modal header-->
                <div class="modal-header" id="kt_modal_add_notification_header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold">Send New Notification</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div id="kt_modal_add_notification_close" class="btn btn-icon btn-sm btn-active-icon-primary">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body py-10 px-lg-17">
                    <!--begin::Scroll-->
                    <div class="scroll-y me-n7 pe-7" id="kt_modal_add_notification_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_notification_header" data-kt-scroll-wrappers="#kt_modal_add_notification_scroll" data-kt-scroll-offset="300px">
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fs-6 fw-semibold mb-2">Title</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid" placeholder="Enter notification title" name="title" maxlength="255" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fs-6 fw-semibold mb-2">Message Body</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <textarea class="form-control form-control-solid" rows="4" placeholder="Enter your notification message..." name="body"></textarea>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fs-6 fw-semibold mb-2">Link (Optional)</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="url" class="form-control form-control-solid" placeholder="https://example.com" name="link" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fs-6 fw-semibold mb-2">File Attachments (PDF/DOCX only)</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="file" class="form-control form-control-solid" name="attachments[]" multiple accept=".pdf,.docx" />
                            <!--end::Input-->
                            <div class="text-muted fs-7 mt-2">You can select multiple PDF or DOCX files</div>
                        </div>
                        <!--end::Input group-->
                        <!--begin::Recipients toggle-->
                        <div class="fw-bold fs-3 rotate collapsible mb-7" data-bs-toggle="collapse" href="#kt_modal_add_notification_recipients" role="button" aria-expanded="true" aria-controls="kt_modal_add_notification_recipients">Recipients Information
                            <span class="ms-2 rotate-180">
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                <span class="svg-icon svg-icon-3">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </span>
                        </div>
                        <!--end::Recipients toggle-->
                        <!--begin::Recipients form-->
                        <div id="kt_modal_add_notification_recipients" class="collapse show">
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold mb-2">Recipient Groups</label>
                                <!--end::Label-->
                                <!--begin::Checkboxes-->
                                <div class="d-flex flex-wrap">
                                    <div class="form-check form-check-custom form-check-solid me-5 mb-3">
                                        <input class="form-check-input" type="checkbox" value="admins" name="recipient_groups[]" id="group_admins">
                                        <label class="form-check-label" for="group_admins">
                                            Admins
                                        </label>
                                    </div>
                                    <div class="form-check form-check-custom form-check-solid me-5 mb-3">
                                        <input class="form-check-input" type="checkbox" value="sub_admins" name="recipient_groups[]" id="group_sub_admins">
                                        <label class="form-check-label" for="group_sub_admins">
                                            Sub Admins
                                        </label>
                                    </div>
                                    <div class="form-check form-check-custom form-check-solid me-5 mb-3">
                                        <input class="form-check-input" type="checkbox" value="students" name="recipient_groups[]" id="group_students">
                                        <label class="form-check-label" for="group_students">
                                            Students
                                        </label>
                                    </div>
                                    <div class="form-check form-check-custom form-check-solid me-5 mb-3">
                                        <input class="form-check-input" type="checkbox" value="consultants" name="recipient_groups[]" id="group_consultants">
                                        <label class="form-check-label" for="group_consultants">
                                            Consultants
                                        </label>
                                    </div>
                                    <div class="form-check form-check-custom form-check-solid me-5 mb-3">
                                        <input class="form-check-input" type="checkbox" value="schools" name="recipient_groups[]" id="group_schools">
                                        <label class="form-check-label" for="group_schools">
                                            Schools
                                        </label>
                                    </div>
                                </div>
                                <!--end::Checkboxes-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold mb-2">Specific Users</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select name="specific_users[]" multiple aria-label="Select Users" data-control="select2" data-placeholder="Search and select specific users..." data-dropdown-parent="#kt_modal_add_notification" class="form-select form-select-solid fw-bold" id="users_select">
                                    <!-- Users will be loaded via AJAX -->
                                </select>
                                <!--end::Input-->
                                <div class="text-muted fs-7 mt-2">Search and select specific users to notify</div>
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Recipients form-->
                    </div>
                    <!--end::Scroll-->
                </div>
                <!--end::Modal body-->
                <!--begin::Modal footer-->
                <div class="modal-footer flex-center">
                    <!--begin::Button-->
                    <button type="reset" id="kt_modal_add_notification_cancel" class="btn btn-light me-3">
                        Cancel
                    </button>
                    <!--end::Button-->
                    <!--begin::Button-->
                    <button type="submit" id="kt_modal_add_notification_submit" class="btn btn-primary">
                        <span class="indicator-label">Send Notification</span>
                        <span class="indicator-progress">
                            Please wait...
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
