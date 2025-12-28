<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('app.name', 'Laravel'))</title>
    @include('_partials.common-styles')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    @stack('styles')

    <style>
        /* Navbar styles */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 1000;
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .navbar-logo {
            height: 80px;
            /* Adjust logo size as needed */
        }

        /* Container for nav links */
        .nav-container {
            display: flex;
            align-items: center;
            gap: 1.5rem; /* Space between nav items */
        }

        /* Nav link styling */
        .nav-link {
            position: relative;
            padding: 8px 12px;
            font-size: 1rem;
            font-weight: 500;
            color: #4b5563; /* Gray-700 */
            text-decoration: none;
            transition: all 0.3s ease;
        }

        /* Hover effect */
        .nav-link:hover {
            color: #9333ea !important; /* Purple color matching the logo */
            transform: translateY(-2px);
        }

        /* Underline effect on hover */
        .nav-link:hover::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: #9333ea;
            transform: scaleX(1);
            transform-origin: bottom right;
            transition: transform 0.3s ease-out;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: #9333ea;
            transform: scaleX(0);
            transform-origin: bottom right;
            transition: transform 0.3s ease-out;
        }

        /* Active page highlight */
        .nav-link.active {
            color: #9333ea !important;
            font-weight: 600;
        }

        .nav-link.active::after {
            transform: scaleX(1);
            transform-origin: bottom left;
        }

        /* Auth links container */
        .auth-container {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        /* Auth link styling */
        .auth-link {
            padding: 8px 12px;
            font-size: 1rem;
            font-weight: 500;
            color: #4b5563; /* Gray-700 */
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .auth-link:hover {
            color: #9333ea !important;
            transform: translateY(-2px);
        }

        /* Logout button styling */
        .logout-btn {
            background: none;
            border: none;
            padding: 8px 12px;
            font-size: 1rem;
            font-weight: 500;
            color: #4b5563;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            color: #9333ea !important;
            transform: translateY(-2px);
        }

        /* Icon styling */
        .auth-icon {
            color: #4b5563;
            transition: color 0.3s ease;
        }

        .auth-icon:hover {
            color: #9333ea !important;
        }
    </style>
</head>
<body class="font-sans bg-gray-100">
<header class="navbar">
    <div class="container py-4 flex items-center justify-between">
        <!-- Logo -->
        <div>
            <a href="{{route('welcome')}}">
                <img src="{{ asset('images/logo of freelance connect.png') }}" alt="FreelanceConnect Logo" class="navbar-logo">
            </a>
        </div>
        <!-- Main Navigation (visible on md and up) -->
        <nav class="hidden md:flex nav-container">
            @auth
                @if(auth()->user()->isClient())
                    <a class="nav-link {{ request()->route()->named('clients.freelancers.index') ? 'active' : '' }}"
                       href="{{ route('clients.freelancers.index') }}">
                        Find talent
                    </a>
                @endif
            @endauth
            <a class="nav-link {{ request()->is('about') ? 'active' : '' }}"
               href="{{route('about')}}">
                Why FreelanceConnect
            </a>
            <a class="nav-link {{ request()->is('contact*') ? 'active' : '' }}"
               href="{{route('contact.index')}}">
                Contact Us
            </a>
            @auth
                @if(auth()->user()->isClient())
                    <a class="nav-link {{ request()->route()->named('clients.post-projects') ? 'active' : '' }}"
                       href="{{ route('clients.post-projects') }}">
                        Projects
                    </a>
                @endif
            @endauth

            @auth
                @if(auth()->user()->isClient())
                    <a class="nav-link {{ request()->is('client/transactions*') ? 'active' : '' }}"
                       href="{{ route('client.transactions') }}">
                        Transactions
                    </a>
                @endif
            @endauth
        </nav>
        <!-- Authentication Links -->
        <div class="auth-container">
            @auth
                <a href="{{ auth()->user()->getDefaultRoute() }}"
                   class="auth-link">Dashboard</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
                @if(auth()->user()->isClient())
                    <a href="{{ route('clients.profile.edit') }}" class="auth-link auth-icon">
                        <i class="fas fa-user-edit"></i>
                    </a>
                @endif
            @else
                <a href="{{ route('login') }}" class="auth-link">Log in</a>
                <a href="{{ route('register') }}" class="auth-link">Sign Up</a>
            @endauth
        </div>
    </div>
</header>
<div class="min-h-[calc(100vh-136px)]">
    @yield('content')
</div>
<footer class="bg-gray-800 text-white py-6">
    <div class="container mx-auto px-4 text-center">
        <p>© {{date('Y')}} {{config('app.name')}}. All rights reserved.</p>
    </div>
</footer>
@include('_partials.common-scripts')
@stack('scripts')
</body>
</html>
