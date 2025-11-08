@php
    $modalId = $modalId ?? 'kt_modal_add_school';
    $formId = $formId ?? 'kt_modal_add_school_form';
    $entityType = $entityType ?? 'school';
    $routeName = $routeName ?? 'admin.schools.store';
    $title = $title ?? __('schools.modal.add_school');
    
    // Map entity types to route names
    $routeMap = [
        'school' => 'admin.schools.store',
        'company' => 'admin.companies.store',
        'educational_institution' => 'admin.educational-institutions.store',
        'consulting_firm' => 'admin.consulting-firms.store',
        'other' => 'admin.other-entities.store',
    ];
    
    if (isset($routeMap[$entityType])) {
        $routeName = $routeMap[$entityType];
    }
@endphp
<div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header" id="{{ $modalId }}_header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">{{ $title }}</h2>
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
                <form id="{{ $formId }}" class="form" action="{{ route($routeName) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="entity_type" value="{{ $entityType }}">
                    <!--begin::Scroll-->
                    <div class="d-flex flex-column scroll-y me-n7 pe-7" id="{{ $modalId }}_scroll"
                         data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                         data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#{{ $modalId }}_header"
                         data-kt-scroll-wrappers="#{{ $modalId }}_scroll" data-kt-scroll-offset="300px">
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">{{ __('schools.modal.school_name') }}</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="name" class="form-control form-control-solid mb-3 mb-lg-0"
                                   placeholder="{{ __('schools.modal.enter_school_name') }}" required/>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">{{ __('schools.modal.email') }}</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="email" name="email" class="form-control form-control-solid mb-3 mb-lg-0"
                                   placeholder="{{ __('schools.modal.enter_email') }}" required/>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">{{ __('schools.modal.phone_number') }}</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div class="input-group">
                                <select name="country_code" class="form-select form-control-solid" style="max-width: 120px;">
                                    <option value="+966">+966</option>
                                    <option value="+971">+971</option>
                                    <option value="+965">+965</option>
                                    <option value="+973">+973</option>
                                    <option value="+974">+974</option>
                                    <option value="+20">+20</option>
                                    <option value="+1">+1</option>
                                    <option value="+44">+44</option>
                                    <option value="+33">+33</option>
                                    <option value="+49">+49</option>
                                </select>
                                <input type="text" name="phone_number"
                                       class="form-control form-control-solid" placeholder="{{ __('schools.modal.enter_phone') }}" required/>
                            </div>
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
                            <label class="required fw-semibold fs-6 mb-2">{{ __('schools.modal.address') }}</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <textarea name="address" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="{{ __('schools.modal.enter_address') }}" required></textarea>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fw-semibold fs-6 mb-2">{{ __('schools.modal.logo') }}</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="file" name="logo" class="form-control form-control-solid mb-3 mb-lg-0"
                                   accept="image/*"/>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        @if($entityType === 'school')
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fw-semibold fs-6 mb-2">{{ __('schools.modal.max_students') }}</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="number" name="max_students" min="1" max="9999" class="form-control form-control-solid mb-3 mb-lg-0"
                                   placeholder="{{ __('schools.modal.enter_max_students') }}"/>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        @endif
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">{{ __('schools.modal.password') }}</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div class="position-relative">
                                <input type="password" name="password"
                                       class="form-control form-control-solid mb-3 mb-lg-0"/>
                                <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-toggle="visibility">
                                    <i class="bi bi-eye-slash fs-2"></i>
                                    <i class="bi bi-eye fs-2 d-none"></i>
                                </span>
                            </div>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">{{ __('schools.modal.confirm_password') }}</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div class="position-relative">
                                <input type="password" name="password_confirmation"
                                       class="form-control form-control-solid mb-3 mb-lg-0"/>
                                <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-toggle="visibility">
                                    <i class="bi bi-eye-slash fs-2"></i>
                                    <i class="bi bi-eye fs-2 d-none"></i>
                                </span>
                            </div>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                    </div>
                    <!--end::Scroll-->
                    <!--begin::Actions-->
                    <div class="text-center pt-15">
                        <button type="reset" class="btn btn-light me-3" data-kt-users-modal-action="cancel">{{ __('schools.modal.discard') }}</button>
                        <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                            <span class="indicator-label">{{ __('schools.modal.submit') }}</span>
                            <span class="indicator-progress">
                                {{ __('schools.modal.please_wait') }}
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
