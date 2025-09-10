@extends('template/layout/master')
@section('body')
    <div class="container contact-container" style="padding-top: 80px;">
        <div class="d-flex align-items-center justify-content-center">
            <div class="contact-form-card w-100">
                <div class="mb-4" style="font-size: 2rem; font-weight: 600;">
                    {{ __('template.school_request.title') }}
                </div>

                {{-- Show success message --}}
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form action="{{ route('request-school.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                               placeholder="{{ __('template.school_request.name') }}" value="{{ old('name') }}" required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}" placeholder="{{ __('template.school_request.email') }}" required>
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="input-group">
                            <select name="country_code" class="form-control @error('country_code') is-invalid @enderror" style="max-width: 120px;">
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
                            <input type="text" name="phone_number" value="{{ old('phone_number') }}"
                                   class="form-control @error('phone_number') is-invalid @enderror"
                                   placeholder="{{ __('template.school_request.phone') }}" required>
                        </div>
                        @error('phone_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @error('country_code')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                    <textarea class="form-control @error('address') is-invalid @enderror" name="address" rows="3"
                              placeholder="{{ __('template.school_request.address') }}" required>{{ old('address') }}</textarea>
                        @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- New Entity Type Field -->
                    <div class="mb-3">
                        <select name="entity_type" class="form-control @error('entity_type') is-invalid @enderror" required>
                            <option value="">{{ __('template.school_request.select_entity_type') }}</option>
                            <option value="school" {{ old('entity_type') == 'school' ? 'selected' : '' }}>{{ __('template.school_request.entity_type_school') }}</option>
                            <option value="company" {{ old('entity_type') == 'company' ? 'selected' : '' }}>{{ __('template.school_request.entity_type_company') }}</option>
                            <option value="educational_institution" {{ old('entity_type') == 'educational_institution' ? 'selected' : '' }}>{{ __('template.school_request.entity_type_educational') }}</option>
                            <option value="consulting_firm" {{ old('entity_type') == 'consulting_firm' ? 'selected' : '' }}>{{ __('template.school_request.entity_type_consulting') }}</option>
                            <option value="other" {{ old('entity_type') == 'other' ? 'selected' : '' }}>{{ __('template.school_request.entity_type_other') }}</option>
                        </select>
                        @error('entity_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <input type="file" name="logo" class="form-control @error('logo') is-invalid @enderror"
                               placeholder="{{ __('template.school_request.logo') }}">
                        @error('logo')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="position-relative">
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="{{ __('template.school_request.password') }}" required>
                            <!-- <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" 
                                data-kt-password-toggle="visibility" style="cursor: pointer;">
                                <i class="bi bi-eye-slash fs-2"></i>
                                <i class="bi bi-eye fs-2 d-none"></i>
                            </span> -->
                        </div>
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="position-relative">
                            <input type="password" name="password_confirmation" class="form-control"
                                placeholder="{{ __('template.school_request.password_confirmation') }}" required>
                            <!-- <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" 
                                data-kt-password-toggle="visibility" style="cursor: pointer;">
                                <i class="bi bi-eye-slash fs-2"></i>
                                <i class="bi bi-eye fs-2 d-none"></i>
                            </span> -->
                        </div>
                    </div>

                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="privacyCheck" required>
                        <label class="form-check-label" for="privacyCheck">
                            {!! __('template.school_request.agreement') !!}
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        {{ __('template.school_request.send') }}
                    </button>
                </form>
            </div>
        </div>
    </div>


@endsection
