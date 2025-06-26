@extends('template/layout/master')
@section('body')
    <div class="container contact-container" style="padding-top: 80px;">
        <div class="row w-100">
            <div class="col-lg-7 contact-left d-flex flex-column justify-content-center">
                <div class="contact-title">{{ __('template.contact.title') }}</div>
                <div class="row">
                    <div class="col-md-6 contact-info">
                        <div class="contact-section-title">{{ __('template.contact.office_title') }}</div>
                        <div><strong>{{ __('template.contact.office_address') }}</strong></div>
                        <div>{{ __('template.contact.telephone') }} : 00000000</div>
                        <div><a href="mailto:furasshead@furass.com">furasshead@furass.com</a></div>
                    </div>
                    <div class="col-md-6 contact-info">
                        <div class="contact-section-title">{{ __('template.contact.support_title') }}</div>
                        <div><strong>{{ __('template.contact.support_hours') }}</strong></div>
                        <div>{{ __('template.contact.telephone') }} : 00000000</div>
                        <div><a href="mailto:support@furass.com">support@furass.com</a></div>
                    </div>
                </div>
                <div class="furass-logo">
                    <img src="{{asset('assets/imgs/template/furass-logo.png')}}" alt="Furass Logo" style="height:38px; margin-right:12px;">
                    <div>
                        <div class="furass-desc">{{ __('template.contact.slogan') }}</div>
                    </div>
                </div>
                <div class="social-icons">
                    <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
            <div class="col-lg-5 d-flex align-items-center justify-content-center">
                <div class="contact-form-card w-100">
                    <div class="mb-4" style="font-size: 2rem; font-weight: 600;">{{ __('template.contact.form_title') }}</div>
                    <form>
                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="{{ __('template.contact.name') }}" required>
                        </div>
                        <div class="mb-3">
                            <input type="email" class="form-control" placeholder="{{ __('template.contact.email') }}" required>
                        </div>
                        <div class="mb-3">
                            <input type="tel" class="form-control" placeholder="{{ __('template.contact.phone') }}">
                        </div>
                        <div class="mb-3">
                            <textarea class="form-control" rows="3" placeholder="{{ __('template.contact.message') }}" required></textarea>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="privacyCheck" required>
                            <label class="form-check-label" for="privacyCheck">
                                {!! __('template.contact.privacy') !!}
                            </label>
                        </div>
                        <button type="submit" class="btn">{{ __('template.contact.send') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection
