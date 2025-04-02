<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Toko-roti</title>
    @vite(['resources/js/app.js'])

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome for X icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <!-- AOS (Animate On Scroll) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">

    <style>
    body {
        background: linear-gradient(to right, #ff7e5f, #feb47b);
        color: white;
    }

    .welcome-section {
        height: 100vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .navbar-toggler {
        border: none;
        outline: none;
        transition: transform 0.3s ease-in-out;
    }

    .navbar-toggler-icon {
        display: none;
    }

    .navbar-toggler .fa-bars {
        display: inline;
    }

    .navbar-toggler.active .fa-bars {
        display: none;
    }

    .navbar-toggler.active .fa-times {
        display: inline;
    }

    .fa-times {
        display: none;
    }

    .navbar-collapse {
        transition: height 0.3s ease-in-out, opacity 0.3s ease-in-out;
    }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">Toko-roti</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
                <i class="fas fa-times"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="ms-auto">
                    <a href="{{ url('/login') }}"
                        class="btn btn-primary me-2 animate__animated animate__fadeInDown">Login</a>
                    <a href="{{ url('/register') }}"
                        class="btn btn-success animate__animated animate__fadeInDown">Register</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="welcome-section text-center" data-aos="zoom-in">
        <h1 class="display-3 animate__animated animate__bounceInDown">Welcome to My E-Commerce</h1>
        <p class="lead animate__animated animate__fadeInUp">Experience the best shopping journey with us!</p>
        <a href="#shop" class="btn btn-warning btn-lg animate__animated animate__pulse animate__infinite">Start
            Shopping</a>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- AOS Script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
    AOS.init();

    // Toggle icon change on navbar-toggler click
    document.querySelector(".navbar-toggler").addEventListener("click", function() {
        this.classList.toggle("active");
    });

    // Close navbar smoothly when clicking outside
    document.addEventListener("click", function(event) {
        let navbar = document.querySelector(".navbar-collapse");
        let toggler = document.querySelector(".navbar-toggler");
        if (!navbar.contains(event.target) && !toggler.contains(event.target)) {
            navbar.classList.remove("show");
            toggler.classList.remove("active");
        }
    });
    </script>
</body>

</html>