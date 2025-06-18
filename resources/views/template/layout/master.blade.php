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
<body>
<!-- nav bar -->
{{--<nav class="navbar navbar-expand-lg navbar-light bg-white py-3 shadow-sm">
    <div class="container px-lg-5">
        <div class="d-flex align-items-center d-lg-none">
            <div class="d-flex flex-column lh-1">
                <span class="fw-bold" style="font-size:1.3rem; color:#4B3FA7; letter-spacing:1px;">فرص</span>
                <span class="fw-bold" style="font-size:1.1rem; color:#4B3FA7; letter-spacing:1px;">Furass</span>
            </div>
            <img src="{{asset('assets/imgs/favicon.png')}}" alt="Furass Logo" style="height:38px; margin-right:12px;">
        </div>
        <button class="navbar-toggler ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-lg-4 gap-2">
                <li class="nav-item logo-phone">
                    <div class="d-flex align-items-center">
                        <div class="d-flex flex-column lh-1">
                            <span class="fw-bold" style="font-size:1.3rem; color:#4B3FA7; letter-spacing:1px;">فرص</span>
                            <span class="fw-bold" style="font-size:1.1rem; color:#4B3FA7; letter-spacing:1px;">Furass</span>
                        </div>
                        <img src="{{asset('assets/imgs/favicon.png')}}" alt="Furass Logo" style="height:38px; margin-right:12px;">
                    </div>
                </li>
                <li class="nav-item"><a class="nav-link fw-semibold" href="{{route('template.home')}}">Home</a></li>
                <li class="nav-item"><a class="nav-link fw-semibold" href="#">Programs</a></li>
                <li class="nav-item"><a class="nav-link fw-semibold" href="#">Resources</a></li>
                <li class="nav-item"><a class="nav-link fw-semibold" href="{{route('template.about')}}">About us</a></li>
                <li class="nav-item"><a class="nav-link fw-semibold" href="#">Contact us</a></li>
                <li class="nav-item"> <a href="#" class="nav-link fw-semibold text-dark">
                        <i class="fas fa-arrow-right-to-bracket" style="font-size: 20px;"></i>
                        Login</a></li>
                <li class="nav-item">
                    <a href="#" class="btn px-4 py-2 fw-bold"
                       style="background:#543786; color:#fff; border-radius:24px;margin: 0">
                        Request a demo
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>--}}


<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="#">
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
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 d-flex gap-5 gap-md-4">
                <li class="nav-item ">
                    <a class="nav-link active" aria-current="page" href="{{route('template.home')}}">Home</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link active" aria-current="page" href="#">Programs</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link active" aria-current="page" href="#">Resources</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link active" aria-current="page" href="#">About us</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link active" aria-current="page" href="#">Contact us</a>
                </li>
                <li class="nav-item d-flex">
                    <a href="#" class="nav-link fw-semibold text-dark">
                        <i class="fas fa-arrow-right-to-bracket" style="font-size: 20px;"></i>
                        Login</a></li>
                <li class="nav-item">
                </li>
                <li class="nav-item ">
                    <a href="#" class="btn px-4 py-2 fw-bold"
                       style="background:#543786; color:#fff; border-radius:24px;margin: 0">
                        Request a demo
                    </a>
                </li>
            </ul>
        </div>

    </div>
</nav>
@yield('body')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
