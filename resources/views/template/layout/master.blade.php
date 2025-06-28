<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Furass Hero Section</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
    @if(app()->getLocale() == 'ar')
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    @else
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @endif

    <link rel="stylesheet" href="{{asset('assets/css/template.css')}}">
</head>
<body class="d-flex flex-column min-vh-100">
<!-- nav bar -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <div class="container">
        <a class="navbar-brand" href="{{route('template.home')}}">
            <img src="{{asset('assets/imgs/template/furass-logo.png')}}" alt="Furass Logo" style="height:38px; margin-right:12px;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse w-100 " id="navbarSupportedContent">
            <ul class="navbar-nav m-auto mb-2 mb-lg-0 w-100 d-flex justify-content-evenly text-center">

                 <li class="nav-item nav-button">
                    <a class="nav-link {{ Request::routeIs('template.home') ? 'active' : '' }}"  href="{{route('template.home')}}">
                        {{ __('template.master.nav.home') }}
                    </a>
                </li>
                <li class="nav-item nav-button">
                    <a class="nav-link {{ Request::routeIs('template.programs') ? 'active' : '' }}"  href="{{route('template.programs')}}">
                        {{ __('template.master.nav.programs') }}
                    </a>
                </li>

                <li class="nav-item nav-button">
                    <a class="nav-link {{ Request::routeIs('template.news') ? 'active' : '' }}"  href="{{route('template.news')}}">
                        {{ __('template.master.nav.news') }}
                    </a>
                </li>

                <li class="nav-item nav-button">
                    <a class="nav-link {{ Request::routeIs('template.about') ? 'active' : '' }}" aria-current="page" href="{{route('template.about')}}">
                        {{ __('template.master.nav.about') }}
                    </a>
                </li>
                <li class="nav-item nav-button">
                    <a class="nav-link {{ Request::routeIs('template.contact') ? 'active' : '' }}" aria-current="page" href="{{route('template.contact')}}">
                        {{ __('template.master.nav.contact') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('login')}}" class="nav-link fw-semibold text-dark">
                        <i class="fas fa-arrow-right-to-bracket" style="font-size: 20px;"></i>
                        {{ __('template.master.nav.login') }}</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle fw-semibold text-dark" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-globe" style="font-size: 18px;"></i>
                        {{ app()->getLocale() == 'ar' ? 'العربية' : 'EN' }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ route('language.switch', 'en') }}">English</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('language.switch', 'ar') }}">العربية</a>
                        </li>
                    </ul>
                </li>
            </ul>

            <a href="#" class="fw-bold request-demo-btn" >
                {{ __('template.master.nav.request') }}
            </a>
        </div>

    </div>
</nav>
@yield('body')

{{--foorer--}}
<footer class="footer-main">
    <div class="container">
        <div class="row gy-4 align-items-start justify-content-between">
            <div class="col-12 col-md-6 col-lg-4 d-flex flex-column justify-content-start">
                <a class="navbar-brand mb-3" href="{{route('template.home')}}">
                    <img src="{{asset('assets/imgs/template/furass-logo.png')}}" alt="Furass Logo" style="height:38px; margin-right:12px;">
                </a>
                <div class="footer-desc">{{ __('template.master.footer.desc') }}</div>
                <div class="footer-social mb-2">
                    <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
            <div class="col-6 col-md-3 col-lg-2 d-flex flex-column justify-content-start">
                <div class="footer-title">{{ __('template.master.footer.links') }}</div>
                <ul class="footer-links">
                    <li><a href="{{route('template.home')}}">{{ __('template.master.nav.home') }}</a></li>
                    <li><a href="{{route('template.programs')}}">{{ __('template.master.nav.programs') }}</a></li>
                    <li><a href="{{route('template.news')}}">{{ __('template.master.nav.news') }}</a></li>
                    <li><a href="{{route('template.about')}}">{{ __('template.master.nav.about') }}</a></li>
                    <li><a href="{{route('template.contact')}}">{{ __('template.master.nav.contact') }}</a></li>
                    <li><a href="{{route('template.questions')}}">{{ __('template.master.footer.questions') }}</a></li>
                </ul>
            </div>
            <div class="col-6 col-md-3 col-lg-2 d-flex flex-column justify-content-start">
                <div class="footer-title">{{ __('template.master.footer.programs') }}</div>
                <ul class="footer-programs">
                    <li><a href="{{ route('template.programs') }}#self-compass">{{ __('template.master.footer.self_compass') }}</a></li>
                    <li><a href="{{ route('template.programs') }}#explore-career">{{ __('template.master.footer.explore_career') }}</a></li>
                    <li><a href="{{ route('template.programs') }}#ready-future">{{ __('template.master.footer.ready_future') }}</a></li>
                </ul>
            </div>
            <div class="col-12 col-md-12 col-lg-4 d-flex flex-column justify-content-start align-items-start">
                <div class="footer-title">{{ __('template.master.footer.contacts') }}</div>
                <div class="footer-contact mb-1">
                    {{ __('template.master.footer.tel') }}:
                    <a href="tel:+123456789"><strong>+0123456789</strong></a>
                </div>
                <div class="footer-contact mb-3">
                    {{ __('template.master.footer.email') }}:
                    <a href="mailto:example@gmail.com"><strong>example@gmail.com</strong></a>
                </div>
            </div>

        </div>
        <div class="footer-trusted"> {{ __('template.master.footer.trusted_by') }}</div>
        <div class="footer-divider"></div>
        <div class="footer-bottom row w-100 mx-0 align-items-center py-3" style="font-size: 0.9rem;">
            <!-- Left Section -->
            <div class="col-12 col-md-4 text-start mb-2 mb-md-0">
                © 2025 Furass. Built by <a href="#">Altarek</a>
            </div>

            <!-- Center Section (Language Dropdown) -->
            <div class="col-12 col-md-4 text-end mb-2 mb-md-0">
                <div class="dropdown d-inline">
                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle footer-language" type="button" id="languageDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-globe"></i> {{ __('template.master.footer.lang') }}
                    </button>
                    <ul class="dropdown-menu text-center" aria-labelledby="languageDropdown">
                        <li><a class="dropdown-item" href="{{ route('language.switch', 'en') }}">English</a></li>
                        <li><a class="dropdown-item" href="{{ route('language.switch', 'ar') }}">العربية</a></li>
                    </ul>
                </div>
            </div>

            <!-- Right Section -->
            <div class="col-12 col-md-4 text-md-end text-center">
                <a href="#" class="me-3">{{ __('template.master.footer.terms') }}</a>
                <a href="#" class="me-3">{{ __('template.master.footer.privacy') }}</a>
            </div>
        </div>

    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    let scrollTimer = null;
    const navbar = document.querySelector('.navbar');

    // Initial state: show navbar
    navbar.classList.add('show-navbar');

    window.addEventListener('scroll', () => {
        // Always show navbar on scroll
        navbar.classList.add('show-navbar');
        navbar.classList.remove('hide-navbar');

        // Handle background color change
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }

        // Clear previous timer
        if (scrollTimer !== null) {
            clearTimeout(scrollTimer);
        }

        // Only start hide timer if not at the top
        if (window.scrollY > 0) {
            scrollTimer = setTimeout(() => {
                navbar.classList.remove('show-navbar');
                navbar.classList.add('hide-navbar');
            }, 2500);
        }
    });

</script>

@yield('script')
</body>
</html>
