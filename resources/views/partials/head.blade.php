<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', __('menu.home')) | {{ site_name() }}</title>
    <meta name="description" content="{{ site_name() }} — solutions de financement rapides, flexibles et personnalisées à travers l'Europe.">
    <link rel="canonical" href="{{ url()->current() }}">
    @foreach (\App\Models\Language::enabledCodes() as $l)
    <link rel="alternate" hreflang="{{ $l }}" href="{{ url($l) }}">
    @endforeach
    {{-- Favicons generes depuis le logo configure en admin (route /site-icon-*.png),
         et non plus un PNG fige dans assets/. --}}
    <link rel="icon" type="image/png" sizes="32x32" href="/site-icon-32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/site-icon-16.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/site-icon-192.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/site-icon-180.png">
    <link rel="shortcut icon" type="image/png" href="/site-icon-32.png">

    <!-- Fonts: Inter + Fraunces -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,600;0,9..144,700;0,9..144,800;1,9..144,400;1,9..144,600&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    navy:      { DEFAULT:'#0E2A3A', mid:'#1A3D52', light:'#24485C', deep:'#0A1F2B' },
                    accent:      { DEFAULT:'#8F6A1F', light:'#A87F2B', pale:'#F6EEDC', dark:'#6F5116' },
                    cream:     { DEFAULT:'#F5F1E8', light:'#FAF8F3' },
                },
                fontFamily: {
                    sans:  ['Inter','ui-sans-serif','system-ui','sans-serif'],
                    serif: ['Fraunces','Georgia','serif'],
                },
                boxShadow: {
                    'card':  '0 1px 3px rgba(14,42,58,.06), 0 4px 16px rgba(14,42,58,.08)',
                    'card-hover': '0 4px 8px rgba(14,42,58,.08), 0 16px 40px rgba(14,42,58,.12)',
                    'accent':  '0 4px 24px rgba(143,106,31,.30)',
                    'nav':   '0 1px 0 rgba(14,42,58,.08)',
                },
                animation: {
                    'fade-in-up': 'fadeInUp .6s ease forwards',
                    'fade-in':    'fadeIn .5s ease forwards',
                    'pulse-slow': 'pulse 3s cubic-bezier(.4,0,.6,1) infinite',
                },
                keyframes: {
                    fadeInUp: { '0%':{ opacity:'0', transform:'translateY(24px)' }, '100%':{ opacity:'1', transform:'translateY(0)' } },
                    fadeIn:   { '0%':{ opacity:'0' }, '100%':{ opacity:'1' } },
                }
            }
        }
    }
    </script>

    <!-- Vendor: Bootstrap (grid + dropdown) -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap/css/bootstrap.min.css') }}">
    <!-- Vendor: Icons -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/easilon-icons/style.css') }}">
    <!-- Vendor: noUiSlider (loan calculator) -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/nouislider/nouislider.min.css') }}">

    <!-- Design system -->
    <link rel="stylesheet" href="{{ asset('assets/css/royal.css') }}">

    @stack('styles')
</head>
<body class="font-sans antialiased bg-white text-gray-900 @yield('body_class')" x-data="{ mobileOpen: false }">
