@extends('template/layout/master')
@section('body')


    @php
        $setting =new \App\Models\Setting;
    @endphp
    <div class="container contact-container" style="padding-top: 80px;">
        <div class="row w-100">
            <div class="col-lg-7 contact-left d-flex flex-column justify-content-center">
                <div class="contact-title">{{ __('template.contact.title') }}</div>
                <div class="row">
                    <!-- <div class="col-md-6 contact-info">
                        <div class="contact-section-title">{{ __('template.contact.office_title') }}</div>
                        <div><strong>{{$setting->where('key' ,'head_office')->first()->value ?? '#'}}</strong></div>
                        <div>{{ __('template.contact.telephone') }} : {{$setting->where('key' ,'telephone')->first()->value ?? '#'}}</div>
                        <div><a href="{{$setting->where('key' ,'email')->first()->value ?? '#'}}">{{$setting->where('key' ,'email')->first()->value ?? '#'}}</a></div>
                    </div> -->
                    <div class="col-md-6 contact-info">
                        <!-- <div class="contact-section-title">{{ __('template.contact.support_title') }}</div> -->
                        <!-- <div><strong>{{$setting->where('key' ,'support')->first()->value ?? '#'}}</strong></div> -->
                        <div>{{ __('template.contact.telephone') }} : {{$setting->where('key' ,'telephone')->first()->value ?? '#'}}</div>
                        <div><a href="mailto:{{$setting->where('key' ,'email')->first()->value ?? '#'}}">{{$setting->where('key' ,'email')->first()->value ?? '#'}}</a></div>
                    </div>
                </div>
                <div class="furass-logo">
                    <img src="{{asset('assets/imgs/template/furass-logo.png')}}" alt="Furass Logo" style="height:38px; margin-right:12px;">
                    <div>
                        <div class="furass-desc">{{ __('template.contact.slogan') }}</div>
                    </div>
                </div>
                <div class="social-icons">
                    <a href="{{$setting->where('key' ,'facebook')->first()->value ?? '#'}}" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="{{$setting->where('key' ,'linkedin')->first()->value ?? '#'}}" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    <a href="{{$setting->where('key' ,'instagram')->first()->value ?? '#'}}" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
            <div class="col-lg-5 d-flex align-items-center justify-content-center">
                <div class="contact-form-card w-100">
                    <div class="mb-4" style="font-size: 2rem; font-weight: 600;">{{ __('template.contact.form_title') }}</div>
                    
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('template.contact.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                   placeholder="{{ __('template.contact.name') }}" 
                                   value="{{ old('name') }}" required>
                        </div>
                        <div class="mb-3">
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                   placeholder="{{ __('template.contact.email') }}" 
                                   value="{{ old('email') }}" required>
                        </div>
                        <div class="mb-3">
                            <div class="input-group">
                                <select name="country_code" class="form-control" style="max-width: 120px;">
                                    <option value="+966" {{ old('country_code') == '+966' ? 'selected' : '' }}>+966</option>
                                    <option value="+971" {{ old('country_code') == '+971' ? 'selected' : '' }}>+971</option>
                                    <option value="+965" {{ old('country_code') == '+965' ? 'selected' : '' }}>+965</option>
                                    <option value="+973" {{ old('country_code') == '+973' ? 'selected' : '' }}>+973</option>
                                    <option value="+974" {{ old('country_code') == '+974' ? 'selected' : '' }}>+974</option>
                                    <option value="+20" {{ old('country_code') == '+20' ? 'selected' : '' }}>+20</option>
                                    <option value="+1" {{ old('country_code') == '+1' ? 'selected' : '' }}>+1</option>
                                    <option value="+44" {{ old('country_code') == '+44' ? 'selected' : '' }}>+44</option>
                                    <option value="+33" {{ old('country_code') == '+33' ? 'selected' : '' }}>+33</option>
                                    <option value="+49" {{ old('country_code') == '+49' ? 'selected' : '' }}>+49</option>
                                </select>
                                <input type="tel" name="phone" class="form-control" 
                                       placeholder="{{ __('template.contact.phone') }}" 
                                       value="{{ old('phone') }}">
                            </div>
                        </div>
                        <div class="mb-3">
                            <textarea name="message" class="form-control @error('message') is-invalid @enderror" 
                                      rows="3" placeholder="{{ __('template.contact.message') }}" required>{{ old('message') }}</textarea>
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
