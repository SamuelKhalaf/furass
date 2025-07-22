@php
    $hasSessionMessages = session('success') || session('error') || $errors->any();
    $isRTL = app()->getLocale() === 'ar'; // or use a helper if you have one
@endphp

@if ($hasSessionMessages)
    <!--begin::Session / Validation Alert Stack-->
    <div id="kt_session_alerts"
         class="position-fixed {{ $isRTL ? 'start-0 ms-5' : 'end-0 me-5' }} mt-5 px-4 w-100 w-md-auto z-index-3"
         style="max-width:400px; top: 58px;">

        {{-- Success --}}
        @if (session('success'))
            <div class="alert alert-dismissible d-flex align-items-start bg-light-success border border-success border-dashed p-5 mb-3 fade show"
                 role="alert" data-kt-alert="success">
                <span class="me-4">
                    <i class="fa-solid fa-circle-check text-success fs-2"></i>
                </span>
                <div class="flex-grow-1 text-success">
                    <span class="fw-bold fs-6">{{ session('success') }}</span>
                </div>
                <button type="button"
                        class="btn btn-icon btn-sm btn-light-success ms-2"
                        data-bs-dismiss="alert" aria-label="{{ __('Close') }}">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        {{-- Error --}}
        @if (session('error'))
            <div class="alert alert-dismissible d-flex align-items-start bg-light-danger border border-danger border-dashed p-5 mb-3 fade show"
                 role="alert" data-kt-alert="error">
                <span class="me-4">
                    <i class="fa-solid fa-circle-xmark text-danger fs-2"></i>
                </span>
                <div class="flex-grow-1 text-danger">
                    <span class="fw-bold fs-6">{{ session('error') }}</span>
                </div>
                <button type="button"
                        class="btn btn-icon btn-sm btn-light-danger ms-2"
                        data-bs-dismiss="alert" aria-label="{{ __('Close') }}">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="alert alert-dismissible d-flex align-items-start bg-light-warning border border-warning border-dashed p-5 mb-3 fade show"
                 role="alert" data-kt-alert="validation">
                <span class="me-4">
                    <i class="fa-solid fa-triangle-exclamation text-warning fs-2"></i>
                </span>
                <div class="flex-grow-1 text-warning">
                    <span class="fw-bold fs-6 mb-2 d-block">{{ __('Please fix the following errors:') }}</span>
                    <ul class="mb-0 ps-4 fs-7">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button type="button"
                        class="btn btn-icon btn-sm btn-light-warning ms-2"
                        data-bs-dismiss="alert" aria-label="{{ __('Close') }}">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

    </div>
    <!--end::Session / Validation Alert Stack-->
@endif

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const AUTO_CLOSE_MS = 5000;
            const alerts = document.querySelectorAll('#kt_session_alerts .alert');
            alerts.forEach(function (el) {
                setTimeout(function () {
                    if (typeof bootstrap !== 'undefined' && bootstrap.Alert) {
                        const instance = bootstrap.Alert.getOrCreateInstance(el);
                        instance.close();
                    } else {
                        el.classList.remove('show');
                        el.addEventListener('transitionend', () => el.remove());
                    }
                }, AUTO_CLOSE_MS);
            });
        });
    </script>
@endpush
