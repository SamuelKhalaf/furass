@extends('template/layout/master')

@push('css')
<style>
/* Fix password toggle button styling in contact form */
.contact-form-card .btn-icon {
    background: transparent !important;
    border: none !important;
    padding: 0 !important;
    width: auto !important;
    height: auto !important;
    min-width: auto !important;
    color: #fff !important;
    font-size: 1.2rem !important;
    z-index: 10 !important;
}

.contact-form-card .btn-icon:hover {
    background: transparent !important;
    color: #e0d7f7 !important;
}

.contact-form-card .btn-icon:focus {
    background: transparent !important;
    box-shadow: none !important;
}

.contact-form-card .btn-icon i {
    color: inherit !important;
}
</style>
@endpush

@section('body')
    <div class="container contact-container" style="padding-top: 80px;">
        <div class="d-flex align-items-center justify-content-center">
            <div class="contact-form-card w-100">
                <div class="mb-4" style="font-size: 2rem; font-weight: 600;">
                    {{ __('template.school_request.title') }}
                </div>

                <form id="schoolRequestForm" action="{{ route('request-school.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <input type="text" name="name" class="form-control"
                               placeholder="{{ __('template.school_request.name') }}" required>
                    </div>

                    <div class="mb-3">
                        <input type="email" name="email" class="form-control"
                               placeholder="{{ __('template.school_request.email') }}" required>
                    </div>

                    <div class="mb-3">
                        <div class="input-group">
                            <select name="country_code" class="form-control" style="max-width: 120px;">
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
                            <input type="text" name="phone_number" class="form-control"
                                   placeholder="{{ __('template.school_request.phone') }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <textarea class="form-control" name="address" rows="3"
                                  placeholder="{{ __('template.school_request.address') }}" required></textarea>
                    </div>

                    <!-- New Entity Type Field -->
                    <div class="mb-3">
                        <select name="entity_type" class="form-control" required>
                            <option value="">{{ __('template.school_request.select_entity_type') }}</option>
                            <option value="school">{{ __('template.school_request.entity_type_school') }}</option>
                            <option value="company">{{ __('template.school_request.entity_type_company') }}</option>
                            <option value="educational_institution">{{ __('template.school_request.entity_type_educational') }}</option>
                            <option value="consulting_firm">{{ __('template.school_request.entity_type_consulting') }}</option>
                            <option value="other">{{ __('template.school_request.entity_type_other') }}</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <input type="file" name="logo" class="form-control"
                               placeholder="{{ __('template.school_request.logo') }}">
                    </div>

                    <div class="mb-3">
                        <div class="position-relative">
                            <input type="password" name="password" id="password"
                                class="form-control"
                                placeholder="{{ __('template.school_request.password') }}" required>
                            <span class="btn btn-sm btn-icon position-absolute" style="top:0; right:2%; color: #00b6b6 !important; margin-top: 0 !important;" 
                                  data-kt-password-toggle="visibility">
                                <i class="bi bi-eye-slash" style="font-size: 1.5rem !important;"></i>
                                <i class="bi bi-eye d-none" style="font-size: 1.5rem !important;"></i>
                            </span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="position-relative">
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                                placeholder="{{ __('template.school_request.password_confirmation') }}" required>
                            <span class="btn btn-sm btn-icon position-absolute" style="top:0; right:2%; color: #00b6b6 !important; margin-top: 0 !important;" 
                                  data-kt-password-toggle="visibility">
                                <i class="bi bi-eye-slash" style="font-size: 1.5rem !important;"></i>
                                <i class="bi bi-eye d-none" style="font-size: 1.5rem !important;"></i>
                            </span>
                        </div>
                    </div>

                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="privacyCheck" required>
                        <label class="form-check-label" for="privacyCheck">
                            {!! __('template.school_request.agreement') !!}
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        <span class="btn-text">{{ __('template.school_request.send') }}</span>
                        <span class="btn-loading d-none">
                            <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                            Sending...
                        </span>
                    </button>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('schoolRequestForm');
    const submitBtn = document.getElementById('submitBtn');
    const btnText = submitBtn.querySelector('.btn-text');
    const btnLoading = submitBtn.querySelector('.btn-loading');

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Show loading state
        submitBtn.disabled = true;
        btnText.classList.add('d-none');
        btnLoading.classList.remove('d-none');

        // Create FormData
        const formData = new FormData(form);

        // Submit form via AJAX
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                               document.querySelector('input[name="_token"]').value
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                // Show success message
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    html: data.message,
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#00b6b6'
                }).then(() => {
                    // Reset form
                    form.reset();
                });
            } else {
                // Show error message
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    html: data.message,
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#dc3545'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'An unexpected error occurred. Please try again.',
                confirmButtonText: 'OK',
                confirmButtonColor: '#dc3545'
            });
        })
        .finally(() => {
            // Reset button state
            submitBtn.disabled = false;
            btnText.classList.remove('d-none');
            btnLoading.classList.add('d-none');
        });
    });
});
</script>
@endsection
