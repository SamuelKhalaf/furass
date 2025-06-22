@extends('template/layout/master')
@section('body')
    <div class="container contact-container" style="padding-top: 80px;">
        <div class="row w-100">
            <div class="col-lg-7 contact-left d-flex flex-column justify-content-center">
                <div class="contact-title">Contact us</div>
                <div class="row">
                    <div class="col-md-6 contact-info">
                        <div class="contact-section-title">Head Office</div>
                        <div><strong>638 star Aveno , Jeddah</strong></div>
                        <div>Telephone : 00000000</div>
                        <div><a href="mailto:furasshead@furass.com">furasshead@furass.com</a></div>
                    </div>
                    <div class="col-md-6 contact-info">
                        <div class="contact-section-title">Support</div>
                        <div><strong>support hours: Sat -Thu 9:00 am to 5:00 pm</strong></div>
                        <div>Telephone : 00000000</div>
                        <div><a href="mailto:support@furass.com">support@furass.com</a></div>
                    </div>
                </div>
                <div class="furass-logo">
                    <div class="d-flex" style="margin-right: 60px">
                        <div class="d-flex flex-column lh-1">
                            <span class="fw-bold" style="font-size:1.3rem; color:#4B3FA7; letter-spacing:1px;">فرص</span>
                            <span class="fw-bold" style="font-size:1.1rem; color:#4B3FA7; letter-spacing:1px;">Furass</span>
                        </div>
                        <img src="{{asset('assets/imgs/favicon.png')}}" alt="Furass Logo" style="height:38px; margin-right:12px;">
                    </div>
                    <div>
                        <div class="furass-desc">We connect education and careers to help students succeed in school and life.</div>
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
                    <div class="mb-4" style="font-size: 2rem; font-weight: 600;">Send Us a message</div>
                    <form>
                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="Name" required>
                        </div>
                        <div class="mb-3">
                            <input type="email" class="form-control" placeholder="E-mail" required>
                        </div>
                        <div class="mb-3">
                            <input type="tel" class="form-control" placeholder="Phone">
                        </div>
                        <div class="mb-3">
                            <textarea class="form-control" rows="3" placeholder="Type your Message here" required></textarea>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="privacyCheck" required>
                            <label class="form-check-label" for="privacyCheck">
                                By submitting this form, I agree to WiziQ's <a href="#" class="privacy-link">Privacy Policy</a> and <a href="#" class="privacy-link">User Agreement</a>.
                            </label>
                        </div>
                        <button type="submit" class="btn">Send message</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
