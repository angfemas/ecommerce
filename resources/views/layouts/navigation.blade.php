<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top px-5 shadow">
            <div class="d-flex align-items-center">
                <!-- Logo -->
                <a class="navbar-brand" href="{{ route('dashboard') }}">
                    <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                </a>
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                    class="d-none d-lg-inline-block ms-3">
                    {{ __('Dashboard') }}
                </x-nav-link>
            </div>

            <!-- Toggler Button for Mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navigation Links -->
            <div class="navbar-collapse collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto d-flex align-items-left">
                    <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#products">Produk</a></li>
                    <li class="nav-item"><a class="nav-link" href="#about">About Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="#outlet">Outlet</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                    <li class="nav-item">
                        <a class="nav-link" href="/">🛒 Keranjang (<span id="cart-count">0</span>)</a>
                    </li>

                    <!-- Dropdown for User -->
                    <li class="nav-item dropdown">
                        <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                            <!-- Tombol Dropdown -->
                            <button @click="open = !open"
                                class="inline-flex items-center px-3 py-2 border text-sm font-medium rounded-md text-gray-500 bg-white hover:text-gray-700">
                                <div>
                                    @if(Auth::check())
                                    {{ Auth::user()->name }}
                                    @else
                                    Guest
                                    @endif
                                </div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="open" x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95"
                                class="absolute z-50 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5"
                                @click="open = false">

                                <!-- Link ke Profil -->
                                <a href="{{ route('profile.edit') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Profile
                                </a>

                                <!-- Tombol Logout -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="block w-full text-start px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Log Out
                                    </button>
                                </form>
                            </div>
                        </div>

                    </li>
                </ul>
            </div>
        </nav>
    </div>
</nav>