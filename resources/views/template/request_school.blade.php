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
                        <input type="text" name="phone_number" value="{{ old('phone_number') }}"
                               class="form-control @error('phone_number') is-invalid @enderror"
                               placeholder="{{ __('template.school_request.phone') }}" required>
                        @error('phone_number')
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

                    <div class="mb-3">
                        <input type="file" name="logo" class="form-control @error('logo') is-invalid @enderror"
                               placeholder="{{ __('template.school_request.logo') }}">
                        @error('logo')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <input type="password" name="password"
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="{{ __('template.school_request.password') }}" required>
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <input type="password" name="password_confirmation" class="form-control"
                               placeholder="{{ __('template.school_request.password_confirmation') }}" required>
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
