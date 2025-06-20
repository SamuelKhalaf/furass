<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Furass Hero Section</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/css/template.css')}}">
</head>
<body class="d-flex flex-column min-vh-100">
<!-- nav bar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="{{route('template.home')}}">
            <div class="d-flex" style="margin-right: 60px">
                <div class="d-flex flex-column lh-1">
                    <span class="fw-bold" style="font-size:1.3rem; color:#4B3FA7; letter-spacing:1px;">فرص</span>
                    <span class="fw-bold" style="font-size:1.1rem; color:#4B3FA7; letter-spacing:1px;">Furass</span>
                </div>
                <img src="{{asset('assets/imgs/favicon.png')}}" alt="Furass Logo" style="height:38px; margin-right:12px;">
            </div>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse w-100 " id="navbarSupportedContent">
            <ul class="navbar-nav m-auto mb-2 mb-lg-0 w-100 d-flex gap-5 gap-md-5 text-center">
                <li class="nav-item nav-button">
                    <a class="nav-link {{ Request::routeIs('template.home') ? 'active' : '' }}"  href="{{route('template.home')}}">Home</a>
                </li>
                <li class="nav-item nav-button">
                    <a class="nav-link {{ Request::routeIs('template.programs') ? 'active' : '' }}"  href="{{route('template.programs')}}">Programs</a>
                </li>
                <li class="nav-item nav-button">
                    <a class="nav-link "  aria-current="page" href="#">Resources</a>
                </li>
                <li class="nav-item nav-button">
                    <a class="nav-link {{ Request::routeIs('template.about') ? 'active' : '' }}" aria-current="page" href="{{route('template.about')}}">About us</a>
                </li>
                <li class="nav-item nav-button">
                    <a class="nav-link {{ Request::routeIs('template.contact') ? 'active' : '' }}" aria-current="page" href="{{route('template.contact')}}">Contact us</a>
                </li>
                <li class="nav-item d-flex">
                    <a href="#" class="nav-link fw-semibold text-dark">
                        <i class="fas fa-arrow-right-to-bracket" style="font-size: 20px;"></i>
                        Login</a></li>
                <li class="nav-item">
                </li>
            </ul>
            <a href="#" class="btn  fw-bold"
               style="background:#543786; color:#fff; border-radius:24px;margin: 0 ; padding: 7px ; width: 19%" >
                Request a demo
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
                    <div class="d-flex" style="margin-right: 60px">
                        <div class="d-flex flex-column lh-1">
                            <span class="fw-bold" style="font-size:1.3rem; color:#4B3FA7; letter-spacing:1px;">فرص</span>
                            <span class="fw-bold" style="font-size:1.1rem; color:#4B3FA7; letter-spacing:1px;">Furass</span>
                        </div>
                        <img src="{{asset('assets/imgs/favicon.png')}}" alt="Furass Logo" style="height:38px; margin-right:12px;">
                    </div>
                </a>
                <div class="footer-desc">We connect education and careers to help students succeed in school and life.</div>
                <div class="footer-social mb-2">
                    <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
            <div class="col-6 col-md-3 col-lg-2 d-flex flex-column justify-content-start">
                <div class="footer-title">Links</div>
                <ul class="footer-links">
                    <li><a href="{{route('template.home')}}">Home</a></li>
                    <li><a href="{{route('template.programs')}}">Programs</a></li>
                    <li><a href="#">Resources</a></li>
                    <li><a href="{{route('template.about')}}">About us</a></li>
                    <li><a href="{{route('template.contact')}}">Contact us</a></li>
                </ul>
            </div>
            <div class="col-6 col-md-3 col-lg-2 d-flex flex-column justify-content-start">
                <div class="footer-title">Programs</div>
                <ul class="footer-programs">
                    <li><a href="{{ route('template.details-programs') }}#self-compass">Self Compass</a></li>
                    <li><a href="{{ route('template.details-programs') }}#explore-career">Explore Career</a></li>
                    <li><a href="{{ route('template.details-programs') }}#ready-future">Ready Future</a></li>
                </ul>
            </div>
            <div class="col-12 col-md-12 col-lg-4 d-flex flex-column justify-content-start align-items-start">
                <div class="footer-title">Contacts</div>
                <div class="footer-contact mb-1">Tel: <a href="tel:+123456789"><strong>+0123456789</strong></a></div>
                <div class="footer-contact mb-3">E-mail: <a href="mailto:example@gmail.com"><strong>example@gmail.com</strong></a></div>
            </div>
        </div>
        <div class="footer-trusted">Trusted by educators and industry leaders in Saudi Arabia</div>
        <div class="footer-divider"></div>
        <div class="footer-bottom row w-100 mx-0">
            <div class="col-12 col-md-4 text-start mb-2 mb-md-0">Copyrights ©2025 Furass. Build by <a href="#">Altarek</a></div>
            <div class="col-12 col-md-4 text-md-end text-start">
                <span class="footer-language"><i class="fa fa-globe"></i> Language <i class="fa fa-angle-up"></i></span>
                <a href="#">Terms of use</a>
                <a href="#">Privacy policy</a>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
