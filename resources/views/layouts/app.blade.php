<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Toko Roti')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
    /* CSS untuk animasi fade-in */
    .fade-in {
        opacity: 0;
        transform: translateY(30px);
        transition: opacity 0.8s ease-out, transform 0.8s ease-out;
    }

    .fade-in.show {
        opacity: 1;
        transform: translateY(0);
    }

    /* Navbar Toggler Fix */
    .navbar-toggler {
        border: none;
        outline: none;
        background: none;
        box-shadow: none !important;
    }

    .navbar-toggler-icon {
        background-image: none !important;
        width: 30px;
        height: 3px;
        background-color: black;
        display: block;
        position: relative;
        transition: all 0.3s ease-in-out;
    }

    .navbar-toggler-icon::before,
    .navbar-toggler-icon::after {
        content: "";
        width: 30px;
        height: 3px;
        background-color: black;
        display: block;
        position: absolute;
        transition: all 0.3s ease-in-out;
    }

    .navbar-toggler-icon::before {
        top: -10px;
    }

    .navbar-toggler-icon::after {
        bottom: -10px;
    }

    .navbar-toggler:not(.collapsed) .navbar-toggler-icon {
        background: transparent;
    }

    .navbar-toggler:not(.collapsed) .navbar-toggler-icon::before {
        top: 0;
        transform: rotate(45deg);
    }

    .navbar-toggler:not(.collapsed) .navbar-toggler-icon::after {
        bottom: 0;
        transform: rotate(-45deg);
    }

    body {
        margin: auto;
        margin-top: 4%;
    }
    </style>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @if (isset($header))
        <header class="bg-light">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
        @endif

        <!-- Page Content -->
        <main>
            @yield('content')
        </main>
    </div>
    <!-- Page Content end -->

    <!-- Smooth Scroll dan Animasi -->
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll('.nav-link').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                if (this.getAttribute('href').startsWith('#')) {
                    e.preventDefault();
                    let targetId = this.getAttribute('href').substring(1);
                    let targetElement = document.getElementById(targetId);

                    if (targetElement) {
                        window.scrollTo({
                            top: targetElement.offsetTop - 60,
                            behavior: 'smooth'
                        });
                    }
                }
            });
        });

        function fadeInOnScroll() {
            let elements = document.querySelectorAll('.fade-in');
            elements.forEach(el => {
                let rect = el.getBoundingClientRect();
                if (rect.top < window.innerHeight - 100) {
                    el.classList.add('show');
                }
            });
        }

        window.addEventListener('scroll', fadeInOnScroll);
        fadeInOnScroll();
    });
    </script>

    <script>
    document.addEventListener("click", function(event) {
        const navbar = document.querySelector(".navbar-collapse");
        const toggleButton = document.querySelector(".navbar-toggler");

        if (!navbar.contains(event.target) && !toggleButton.contains(event.target)) {
            navbar.classList.remove("show");
            toggleButton.classList.add("collapsed");
            toggleButton.setAttribute("aria-expanded", "false");
        }
    });
    </script>
</body>

</html>