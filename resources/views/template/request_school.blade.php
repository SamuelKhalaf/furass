@extends('template/layout/master')
@section('body')
    <div class="container contact-container">
        <div class=" d-flex align-items-center justify-content-center">
            <div class="contact-form-card w-100">
                <div class="mb-4" style="font-size: 2rem; font-weight: 600;">Request a School Partnership</div>
                <form action="{{ route('admin.schools.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <input type="text" name="name" class="form-control" placeholder="Name" value="{{ old('name') }}" required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <input type="email" name="email" class="form-control" value="{{ old('name') }}" placeholder="E-mail" required>
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <input type="text" name="phone" value="{{ old('phone') }}" class="form-control" placeholder="Phone">
                        @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <textarea class="form-control" name="address" rows="3"  placeholder="your address" required></textarea>
                        @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <input type="file" name="logo" class="form-control" placeholder="logo">
                    </div>
                    <div class="mb-3">
                        <input type="password" name="password" class="form-control" placeholder="password" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" placeholder="confirm password" required>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="privacyCheck" required>
                        <label class="form-check-label" for="privacyCheck">
                            By submitting this form, I agree to WiziQ's <a href="#" class="privacy-link">Privacy Policy</a> and <a href="#" class="privacy-link">User Agreement</a>.
                        </label>
                    </div>
                    <button type="submit" class="btn">Send Request</button>
                </form>
            </div>
        </div>
    </div>

@endsection
