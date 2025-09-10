@extends('admin.layouts.master')

@section('content')
    <!--begin::Content wrapper-->
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                        {{ __('admin.profile.edit_title') }}
                    </h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">
                                {{ __('admin.dashboard.title') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.profile.show') }}" class="text-muted text-hover-primary">
                                {{ __('admin.profile.title') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">{{ __('admin.profile.edit') }}</li>
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
            </div>
            <!--end::Toolbar container-->
        </div>
        <!--end::Toolbar-->

        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-xxl">
                <!--begin::Card-->
                <div class="card">
                    <!--begin::Card header-->
                    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
                        <!--begin::Card title-->
                        <div class="card-title m-0">
                            <h3 class="fw-bold m-0">{{ __('admin.profile.edit_title') }}</h3>
                        </div>
                        <!--end::Card title-->
                    </div>
                    <!--begin::Card header-->

                    <!--begin::Content-->
                    <div id="kt_account_profile_details" class="collapse show">
                        <!--begin::Form-->
                        <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data" class="form">
                            @csrf
                            @method('PUT')

                            <!--begin::Card body-->
                            <div class="card-body border-top p-9">
                                @if($profileData['has_avatar'])
                                    <!--begin::Input group-->
                                    <div class="row mb-6">
                                        <!--begin::Label-->
                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                            {{ $profileData['type'] === 'school' ? __('admin.profile.logo') : __('admin.profile.avatar') }}
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Col-->
                                        <div class="col-lg-8">
                                            <!--begin::Image input wrapper-->
                                            <div class="mt-1">
                                                <!--begin::Image placeholder-->
                                                <style>
                                                    .image-input-placeholder {
                                                        background-image: url('{{ asset('assets/media/svg/files/blank-image.svg') }}');
                                                    }
                                                    [data-bs-theme="dark"] .image-input-placeholder {
                                                        background-image: url('{{ asset('assets/media/svg/files/blank-image-dark.svg') }}');
                                                    }
                                                    
                                                    /* Custom styling for image wrapper */
                                                    .image-input-wrapper {
                                                        min-width: 200px;
                                                        min-height: 200px;
                                                        border: 1px solid #e4e6ef;
                                                        border-radius: 0.475rem;
                                                        background: #f8f9fa;
                                                        display: flex;
                                                        align-items: center;
                                                        justify-content: center;
                                                        position: relative;
                                                        padding: 10px;
                                                    }
                                                    
                                                    .image-input-wrapper img {
                                                        max-width: 200px;
                                                        max-height: 200px;
                                                        width: auto;
                                                        height: auto;
                                                        border-radius: 8px;
                                                        display: block;
                                                    }
                                                </style>
                                                <!--end::Image placeholder-->
                                                <!--begin::Image input-->
                                                <div class="image-input image-input-outline image-input-placeholder" data-kt-image-input="true">
                                                    <!--begin::Preview existing image-->
                                                    <div class="image-input-wrapper">
                                                        @if($profileData['avatar_path'])
                                                            <img src="{{ Storage::url($profileData['avatar_path']) }}" 
                                                                alt="Preview" />
                                                        @endif
                                                    </div>
                                                    <!--end::Preview existing image-->
                                                    <!--begin::Label-->
                                                    <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="{{ __('admin.profile.change_image') }}">
                                                        <i class="fa-solid fa-pen fs-7"></i>
                                                        <!--begin::Inputs-->
                                                        <input type="file" name="{{ $profileData['type'] === 'school' ? 'logo' : 'avatar' }}" accept=".png, .jpg, .jpeg" />
                                                        <input type="hidden" name="{{ $profileData['type'] === 'school' ? 'logo' : 'avatar' }}_remove" />
                                                        <!--end::Inputs-->
                                                    </label>
                                                    <!--end::Label-->
                                                    <!--begin::Cancel-->
                                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="{{ __('admin.profile.cancel_image') }}">
                                                        <i class="fa-solid fa-xmark fs-2"></i>
                                                    </span>
                                                    <!--end::Cancel-->
                                                    <!--begin::Remove-->
                                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="{{ __('admin.profile.remove_image') }}">
                                                        <i class="fa-solid fa-xmark fs-2"></i>
                                                    </span>
                                                    <!--end::Remove-->
                                                </div>
                                                <!--end::Image input-->
                                                <!--begin::Hint-->
                                                <div class="form-text">{{ __('admin.profile.image_formats') }}</div>
                                                <!--end::Hint-->
                                                @error($profileData['type'] === 'school' ? 'logo' : 'avatar')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <!--end::Image input wrapper-->
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Input group-->
                                @endif

                                <!--begin::Input group - Name-->
                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{ __('admin.profile.name') }}</label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8 fv-row">
                                        <input type="text" name="name" class="form-control form-control-lg form-control-solid @error('name') is-invalid @enderror"
                                               placeholder="{{ __('admin.profile.name') }}" value="{{ old('name', $user->name) }}" />
                                        @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Input group-->

                                <!--begin::Input group - Email-->
                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{ __('admin.profile.email') }}</label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8 fv-row">
                                        <input type="email" name="email" class="form-control form-control-lg form-control-solid @error('email') is-invalid @enderror"
                                               placeholder="{{ __('admin.profile.email') }}" value="{{ old('email', $user->email) }}" />
                                        @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Input group-->

                                <!--begin::Input group - Phone-->
                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{ __('admin.profile.phone') }}</label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8 fv-row">
                                        <div class="input-group">
                                            <select name="country_code" class="form-select form-control-lg form-control-solid @error('country_code') is-invalid @enderror" style="max-width: 120px;">
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
                                            <input type="text" name="phone_number" class="form-control form-control-lg form-control-solid @error('phone_number') is-invalid @enderror"
                                                   placeholder="{{ __('admin.profile.phone') }}" value="{{ old('phone_number', $user->phone_number) }}" />
                                        </div>
                                        @error('phone_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        @error('country_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Input group-->

                                @if($profileData['type'] === 'consultant')
                                    <!--begin::Input group - Bio-->
                                    <div class="row mb-6">
                                        <!--begin::Label-->
                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">{{ __('admin.profile.bio') }}</label>
                                        <!--end::Label-->
                                        <!--begin::Col-->
                                        <div class="col-lg-8 fv-row">
                                    <textarea name="bio" class="form-control form-control-lg form-control-solid @error('bio') is-invalid @enderror"
                                              rows="3" placeholder="{{ __('admin.profile.bio') }}">{{ old('bio', $profileData['additional_data']->bio ?? '') }}</textarea>
                                            @error('bio')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Input group-->
                                @endif

                                @if($profileData['type'] === 'school')
                                    <!--begin::Input group - Address-->
                                    <div class="row mb-6">
                                        <!--begin::Label-->
                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">{{ __('admin.profile.address') }}</label>
                                        <!--end::Label-->
                                        <!--begin::Col-->
                                        <div class="col-lg-8 fv-row">
                                    <textarea name="address" class="form-control form-control-lg form-control-solid @error('address') is-invalid @enderror"
                                              rows="3" placeholder="{{ __('admin.profile.address') }}">{{ old('address', $profileData['additional_data']->address ?? '') }}</textarea>
                                            @error('address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Input group-->
                                @endif

                                @if($profileData['type'] === 'student')
                                    <!--begin::Input group - Grade-->
                                    <div class="row mb-6">
                                        <!--begin::Label-->
                                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{ __('admin.profile.grade') }}</label>
                                        <!--end::Label-->
                                        <!--begin::Col-->
                                        <div class="col-lg-8 fv-row">
                                            <select name="grade" class="form-select form-select-solid form-select-lg @error('grade') is-invalid @enderror">
                                                <option value="">{{ __('admin.profile.select_grade') }}</option>
                                                <option value="10" {{ old('grade', $profileData['additional_data']->grade ?? '') == '10' ? 'selected' : '' }}>{{ __('admin.profile.grade_10') }}</option>
                                                <option value="11" {{ old('grade', $profileData['additional_data']->grade ?? '') == '11' ? 'selected' : '' }}>{{ __('admin.profile.grade_11') }}</option>
                                                <option value="12" {{ old('grade', $profileData['additional_data']->grade ?? '') == '12' ? 'selected' : '' }}>{{ __('admin.profile.grade_12') }}</option>
                                            </select>
                                            @error('grade')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Input group-->

                                    <!--begin::Input group - Gender-->
                                    <div class="row mb-6">
                                        <!--begin::Label-->
                                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{ __('admin.profile.gender') }}</label>
                                        <!--end::Label-->
                                        <!--begin::Col-->
                                        <div class="col-lg-8 fv-row">
                                            <div class="d-flex align-items-center mt-3">
                                                <label class="form-check form-check-custom form-check-inline form-check-solid me-5">
                                                    <input class="form-check-input" name="gender" type="radio" value="male"
                                                        {{ old('gender', $profileData['additional_data']->gender ?? '') == 'male' ? 'checked' : '' }} />
                                                    <span class="fw-semibold ps-2 fs-6">{{ __('admin.profile.male') }}</span>
                                                </label>
                                                <label class="form-check form-check-custom form-check-inline form-check-solid">
                                                    <input class="form-check-input" name="gender" type="radio" value="female"
                                                        {{ old('gender', $profileData['additional_data']->gender ?? '') == 'female' ? 'checked' : '' }} />
                                                    <span class="fw-semibold ps-2 fs-6">{{ __('admin.profile.female') }}</span>
                                                </label>
                                            </div>
                                            @error('gender')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Input group-->

                                    <!--begin::Input group - Birth Date-->
                                    <div class="row mb-6">
                                        <!--begin::Label-->
                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">{{ __('admin.profile.birth_date') }}</label>
                                        <!--end::Label-->
                                        <!--begin::Col-->
                                        <div class="col-lg-8 fv-row">
                                            <input type="date" name="birth_date" class="form-control form-control-lg form-control-solid @error('birth_date') is-invalid @enderror"
                                                   value="{{ old('birth_date', $profileData['additional_data']->birth_date ?? '') }}" />
                                            @error('birth_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Input group-->
                                @endif
                            </div>
                            <!--end::Card body-->

                            <!--begin::Actions-->
                            <div class="card-footer d-flex justify-content-end py-6 px-9">
                                <a href="{{ route('admin.profile.show') }}" class="btn btn-light btn-active-light-primary me-2">
                                    {{ __('admin.profile.cancel') }}
                                </a>
                                <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">
                                    {{ __('admin.profile.save_changes') }}
                                </button>
                            </div>
                            <!--end::Actions-->
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Content container-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Content wrapper-->
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const imageInputs = document.querySelectorAll('[data-kt-image-input="true"]');
            
            imageInputs.forEach(function(imageInput) {
                const imageInputWrapper = imageInput.querySelector('.image-input-wrapper');
                const imageInputAction = imageInput.querySelector('[data-kt-image-input-action="change"]');
                const imageInputActionCancel = imageInput.querySelector('[data-kt-image-input-action="cancel"]');
                const imageInputActionRemove = imageInput.querySelector('[data-kt-image-input-action="remove"]');
                const imageInputTarget = imageInput.querySelector('input[type="file"]');
                const imageInputHiddenInput = imageInput.querySelector('input[type="hidden"]');
                
                let originalImageSrc = null;
                
                // Store original image source if exists
                const existingImg = imageInputWrapper.querySelector('img');
                if (existingImg) {
                    originalImageSrc = existingImg.src;
                }

                // Handle file selection
                if (imageInputTarget) {
                    imageInputTarget.addEventListener('change', function(e) {
                        const file = e.target.files[0];
                        
                        if (file) {
                            const reader = new FileReader();
                            
                            reader.onload = function(e) {
                                // Remove existing content completely
                                imageInputWrapper.innerHTML = '';
                                
                                // Wait a moment to ensure DOM is updated
                                setTimeout(function() {
                                    // Create and add new image
                                    const img = document.createElement('img');
                                    img.src = e.target.result;
                                    img.alt = 'Preview';
                                    img.style.cssText = 'max-width: 200px; max-height: 200px; width: auto; height: auto; border-radius: 8px; display: block;';
                                    
                                    // Clear any existing images first
                                    const existingImages = imageInputWrapper.querySelectorAll('img');
                                    existingImages.forEach(function(existingImg) {
                                        existingImg.remove();
                                    });
                                    
                                    // Add the new image
                                    imageInputWrapper.appendChild(img);
                                }, 10);
                                
                                // Show cancel and remove buttons, hide change button
                                if (imageInputAction) imageInputAction.style.display = 'none';
                                if (imageInputActionCancel) imageInputActionCancel.style.display = 'inline-flex';
                                if (imageInputActionRemove) imageInputActionRemove.style.display = 'inline-flex';
                                
                                // Clear the remove hidden input
                                if (imageInputHiddenInput) {
                                    imageInputHiddenInput.value = '';
                                }
                            };
                            
                            reader.readAsDataURL(file);
                        }
                    });
                }

                // Handle cancel action
                if (imageInputActionCancel) {
                    imageInputActionCancel.addEventListener('click', function() {
                        // Clear file input
                        if (imageInputTarget) {
                            imageInputTarget.value = '';
                        }
                        
                        // Restore original image or placeholder
                        imageInputWrapper.innerHTML = '';
                        
                        if (originalImageSrc) {
                            // Clear any existing images first
                            imageInputWrapper.innerHTML = '';
                            
                            const img = document.createElement('img');
                            img.src = originalImageSrc;
                            img.alt = 'Preview';
                            img.style.cssText = 'max-width: 200px; max-height: 200px; width: auto; height: auto; border-radius: 8px; display: block;';
                            imageInputWrapper.appendChild(img);
                        } else {
                            // Show placeholder or initial state
                            imageInputWrapper.innerHTML = '';
                        }
                        
                        // Show change button, hide cancel and remove buttons
                        if (imageInputAction) imageInputAction.style.display = 'inline-flex';
                        if (imageInputActionCancel) imageInputActionCancel.style.display = 'none';
                        if (imageInputActionRemove) imageInputActionRemove.style.display = originalImageSrc ? 'inline-flex' : 'none';
                        
                        // Clear the remove hidden input
                        if (imageInputHiddenInput) {
                            imageInputHiddenInput.value = '';
                        }
                    });
                }

                // Handle remove action
                if (imageInputActionRemove) {
                    imageInputActionRemove.addEventListener('click', function() {
                        // Clear file input
                        if (imageInputTarget) {
                            imageInputTarget.value = '';
                        }
                        
                        // Remove image and show placeholder
                        imageInputWrapper.innerHTML = '';
                        
                        // Show change button, hide cancel and remove buttons
                        if (imageInputAction) imageInputAction.style.display = 'inline-flex';
                        if (imageInputActionCancel) imageInputActionCancel.style.display = 'none';
                        if (imageInputActionRemove) imageInputActionRemove.style.display = 'none';
                        
                        // Set the remove hidden input to indicate removal
                        if (imageInputHiddenInput) {
                            imageInputHiddenInput.value = '1';
                        }
                    });
                }

                // Initialize button states based on existing image
                if (originalImageSrc) {
                    if (imageInputAction) imageInputAction.style.display = 'inline-flex';
                    if (imageInputActionCancel) imageInputActionCancel.style.display = 'none';
                    if (imageInputActionRemove) imageInputActionRemove.style.display = 'inline-flex';
                } else {
                    if (imageInputAction) imageInputAction.style.display = 'inline-flex';
                    if (imageInputActionCancel) imageInputActionCancel.style.display = 'none';
                    if (imageInputActionRemove) imageInputActionRemove.style.display = 'none';
                }
            });
        });
    </script>
@endsection
