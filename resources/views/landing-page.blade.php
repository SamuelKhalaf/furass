<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Furass Hero Section</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/css/landing-page.css')}}">
</head>
<body>
<!-- nav bar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white py-3 shadow-sm">
    <div class="container px-lg-5">
        <div class="d-flex align-items-center">
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
                <li class="nav-item"><a class="nav-link fw-semibold" href="#">Home</a></li>
                <li class="nav-item"><a class="nav-link fw-semibold" href="#">Programs</a></li>
                <li class="nav-item"><a class="nav-link fw-semibold" href="#">Resources</a></li>
                <li class="nav-item"><a class="nav-link fw-semibold" href="#">About us</a></li>
                <li class="nav-item"><a class="nav-link fw-semibold" href="#">Contact us</a></li>
            </ul>
            <div class="d-flex align-items-center ms-auto gap-2">
                <a href="#" class="nav-link fw-semibold text-dark">
                    <i class="fas fa-arrow-right-to-bracket" style="font-size: 20px;"></i>
                    Login</a>
                <a href="#" class="btn px-4 py-2 fw-bold" style="background:#543786; color:#fff; border-radius:24px;">Request a demo</a>
            </div>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container ssmall-section">
        <div class="row align-items-center">
            <!-- Left: Text -->
            <div class="col-lg-6 mb-4 mb-lg-0">
                <h1 class="display-5 fw-bold mb-3">Equip students for college<br>and career success based<br>on their unique aptitudes</h1>
                <p class="lead-section mb-3">Furass is the only career readiness (CCR) platform specifically built to ensure compliance and deliver measurable impact for students</p>
            </div>
            <!-- Right: Image and Details -->
            <div class="col-lg-6 d-flex justify-content-center align-items-center position-relative">
                <div class="position-relative" style="display:inline-block;">
                    <!-- Main Image in rounded rectangle -->
                    <div class="  position-relative" style="overflow:hidden; width:460px; max-width:100%;">
                        <img src="{{asset('assets/imgs/land-section.png')}}" alt="Student with headphones" class="img-fluid w-100">
                        <!-- Floating Card -->

                    </div>
                </div>
            </div>
        </div>
        <!-- Centered Text at Bottom -->

    </div>

</section>


<!-- Hero Section -->


<div class="container mb-5 mt-5 program" >
    <h1 class="h-section mb-5 mt-5">Choose Your Program</h1>
    <div class="row">
        <div class="col-lg-4  col-sm-1">
            <div class="card">
                <h4>Self Compass Plus program</h4>
                <p>Take test & Know your potential</p>
                <img src="{{asset('assets/imgs/section_1.jpg')}}" class="centered-image  mt-4 mb-5" alt="Furass Logo">
                <button class="btn">Learn more</button>
            </div>
        </div>
        <div class="col-lg-4  col-sm-1 ">
            <div class="card">
                <h4>Explore Your Career Destination program</h4>
                <p>Go on trips & Discover the practical life on field</p>
                <img src="{{asset('assets/imgs/section_2.webp')}}" class="centered-image  mt-4 mb-5" alt="Furass Logo">
                <button class="btn">Learn more</button>
            </div>
        </div>
        <div class="col-lg-4  col-sm-1 ">
            <div class="card">
                <h4>Ready For The Future program</h4>
                <p>Workshop to learn more about Different careers</p>
                <img src="{{asset('assets/imgs/section_3.webp')}}" class="centered-image mt-4 mb-5" alt="Furass Logo">
                <button class="btn">Learn more</button>
            </div>
        </div>

    </div>
</div>

    <div class="col-12 text-center mb-5">
        <p class="fw-semibold mb-0">Trusted by schools and districts to connect education to careers</p>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
