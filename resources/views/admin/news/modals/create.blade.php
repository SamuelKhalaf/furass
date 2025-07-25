@php use App\Enums\RoleEnum;use App\Models\User; @endphp
<div class="modal fade" id="kt_modal_add_news" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-750px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header" id="kt_modal_add_news_header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">{{ __('news.modal.add_news') }}</h2>
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
            <div class="modal-body py-10 px-lg-17">
                <!--begin::Form-->
                <form id="kt_modal_add_news_form" class="form" action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data" novalidate="novalidate">
                    @csrf
                    <!--begin::Scroll-->
                    <div class="scroll-y me-n7 pe-7" id="kt_modal_add_news_scroll"
                         data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                         data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_news_header"
                         data-kt-scroll-wrappers="#kt_modal_add_news_scroll" data-kt-scroll-offset="300px">

                        <!--begin::Input group-->
                        <div class="row g-9 mb-7">
                            <!--begin::Col-->
                            <div class="col-md-6 fv-row">
                                <label class="required fs-6 fw-semibold mb-2">{{ __('news.modal.news_title') }}</label>
                                <input type="text" class="form-control form-control-lg form-control-solid" name="title"
                                       placeholder="{{ __('news.modal.enter_news_title') }}" required/>
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                            </div>
                            <!--end::Col-->

                            <!--begin::Col-->
                            <div class="col-md-6 fv-row">
                                <label class="required fs-6 fw-semibold mb-2">{{ __('news.modal.slug') }}</label>
                                <input type="text" class="form-control form-control-lg form-control-solid" name="slug"
                                       placeholder="{{ __('news.modal.enter_slug') }}" required/>
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <div class="fv-row mb-7">
                            <label class="required fw-semibold fs-6 mb-2">{{ __('news.modal.content') }}</label>
                            <textarea name="content" class="form-control form-control-solid" rows="4"
                                      placeholder="{{ __('news.modal.enter_content') }}" required></textarea>
                        </div>

                        <!--begin::Input group-->
                        <div class="row g-5 mb-7">
                            <div class="col-md-6 fv-row mb-7">
                                <label class="fw-semibold fs-6 mb-2">{{__('news.modal.published_at')}}</label>
                                <input type="text" name="published_at" id="add_published_at"
                                       placeholder="{{__('news.modal.select_published_at')}}"
                                       class="form-control form-control-solid flatpickr-input" required/>
                            </div>
                            <div class="col-md-6 fv-row">
                                <label class="required fs-6 fw-semibold mb-2">{{ __('news.modal.status') }}</label>
                                <select name="status" id="add_status" class="form-select form-select-solid"
                                        data-control="select2" data-close-on-select="true"
                                        data-hide-search="true"
                                        data-placeholder="{{ __('news.modal.select_status') }}"
                                        required>
                                    <option value="0">{{ __('news.modal.draft') }}</option>
                                    <option value="1">{{ __('news.modal.published') }}</option>
                                </select>
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                            </div>
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row g-9 mb-7">
                            <!--begin::Col-->
                            <div class="col-12 fv-row">
                                <label class="fs-6 fw-semibold mb-2">
                                    <span>{{ __('news.modal.media') }}</span>
                                    <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip"
                                       title="{{ __('news.modal.allowed_media') }}"></i>
                                </label>
                                <div class="position-relative">
                                    <input type="file" id="add_media" name="media"
                                           class="form-control form-control-lg form-control-solid"
                                           accept="image/*,video/*"/>
                                </div>
                                <div class="d-flex align-items-center mt-2">
                                    <button type="button" id="add_media_preview_btn"
                                            class="btn btn-icon btn-sm btn-light-primary me-2 d-none preview-trigger"
                                            data-content="">
                                        <i class="bi bi-eye fs-4"></i>
                                    </button>
                                    <span id="add_media_name" class="text-muted fs-7"></span>
                                </div>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                    </div>
                    <!--end::Scroll-->

                    <!--begin::Modal footer-->
                    <div class="modal-footer flex-center">
                        <!--begin::Button-->
                        <button type="reset" class="btn btn-light me-3" data-kt-users-modal-action="cancel">
                            {{ __('news.modal.discard') }}
                        </button>
                        <!--end::Button-->

                        <!--begin::Button-->
                        <button type="submit" id="kt_modal_add_news_submit" class="btn btn-primary"
                                data-kt-users-modal-action="submit">
                            <span class="indicator-label">{{ __('news.modal.submit') }}</span>
                            <span class="indicator-progress">
                                {{ __('news.modal.please_wait') }}
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                        <!--end::Button-->
                    </div>
                    <!--end::Modal footer-->
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
        // Add any specific JavaScript for the create modal here
    </script>
@endpush
