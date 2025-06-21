@extends('template/layout/master')
@section('body')
    <div class="container contact-container">
        <div class=" d-flex align-items-center justify-content-center">
            <div class="contact-form-card w-100">
                <div class="mb-4" style="font-size: 2rem; font-weight: 600;">Request a School Partnership</div>
                <form action="{{ route('request-school.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                               placeholder="Name" value="{{ old('name') }}" required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}" placeholder="E-mail" required>
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <input type="text" name="phone_number" value="{{ old('phone_number') }}"
                               class="form-control @error('phone_number') is-invalid @enderror" placeholder="Phone" required>
                        @error('phone_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <textarea class="form-control @error('address') is-invalid @enderror" name="address" rows="3"
                                  placeholder="Your address" required>{{ old('address') }}</textarea>
                        @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <input type="file" name="logo" class="form-control @error('logo') is-invalid @enderror" placeholder="Logo">
                        @error('logo')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <input type="password" name="password"
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="Password" required>
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <input type="password" name="password_confirmation" class="form-control"
                               placeholder="Confirm Password" required>
                    </div>

                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="privacyCheck" required>
                        <label class="form-check-label" for="privacyCheck">
                            By submitting this form, I agree to WiziQ's <a href="#" class="privacy-link">Privacy Policy</a> and
                            <a href="#" class="privacy-link">User Agreement</a>.
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary">Send Request</button>
                </form>
            </div>
        </div>
    </div>

@endsection
