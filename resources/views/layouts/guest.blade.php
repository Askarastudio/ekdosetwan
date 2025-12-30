<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="icon" type="image/png" href="{{ asset('asset/images/LogoEKDO.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            @keyframes gradient {
                0% { background-position: 0% 50%; }
                50% { background-position: 100% 50%; }
                100% { background-position: 0% 50%; }
            }
            
            @keyframes float {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(-20px); }
            }
            
            @keyframes slideInFromLeft {
                0% { 
                    opacity: 0;
                    transform: translateX(-100px);
                }
                100% {
                    opacity: 1;
                    transform: translateX(0);
                }
            }
            
            @keyframes slideInFromRight {
                0% { 
                    opacity: 0;
                    transform: translateX(100px);
                }
                100% {
                    opacity: 1;
                    transform: translateX(0);
                }
            }
            
            @keyframes fadeInUp {
                0% { 
                    opacity: 0;
                    transform: translateY(30px);
                }
                100% {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            
            .animate-gradient {
                background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
                background-size: 400% 400%;
                animation: gradient 15s ease infinite;
            }
            
            .animate-float {
                animation: float 6s ease-in-out infinite;
            }
            
            .animate-slide-left {
                animation: slideInFromLeft 0.8s ease-out forwards;
            }
            
            .animate-slide-right {
                animation: slideInFromRight 0.8s ease-out forwards;
            }
            
            .animate-fade-up {
                animation: fadeInUp 0.6s ease-out forwards;
            }
            
            .glass-morphism {
                background: rgba(255, 255, 255, 0.25);
                backdrop-filter: blur(10px);
                -webkit-backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.18);
            }
            
            .input-focus:focus {
                transform: translateY(-2px);
                transition: all 0.3s ease;
            }
            
            .btn-hover:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
                transition: all 0.3s ease;
            }
            
            /* Particle animation */
            .particle {
                position: absolute;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.3);
                animation: rise 10s infinite ease-in;
            }
            
            @keyframes rise {
                0% {
                    bottom: -100px;
                    opacity: 0;
                }
                50% {
                    opacity: 1;
                }
                100% {
                    bottom: 100%;
                    opacity: 0;
                }
            }

            .logo-pulse {
                animation: logoPulse 6s ease-in-out infinite;
            }

            @keyframes logoPulse {
                0%, 100% { transform: translateY(0) scale(1); filter: drop-shadow(0 12px 30px rgba(0,0,0,0.18)); }
                50% { transform: translateY(-6px) scale(1.03); filter: drop-shadow(0 16px 36px rgba(0,0,0,0.22)); }
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased overflow-hidden">
        <div class="min-h-screen flex items-center justify-center relative animate-gradient">
            <!-- Floating particles -->
            <div class="particle" style="left: 10%; width: 10px; height: 10px; animation-delay: 0s; animation-duration: 8s;"></div>
            <div class="particle" style="left: 20%; width: 15px; height: 15px; animation-delay: 2s; animation-duration: 10s;"></div>
            <div class="particle" style="left: 30%; width: 8px; height: 8px; animation-delay: 4s; animation-duration: 12s;"></div>
            <div class="particle" style="left: 40%; width: 12px; height: 12px; animation-delay: 1s; animation-duration: 9s;"></div>
            <div class="particle" style="left: 50%; width: 10px; height: 10px; animation-delay: 3s; animation-duration: 11s;"></div>
            <div class="particle" style="left: 60%; width: 14px; height: 14px; animation-delay: 5s; animation-duration: 8s;"></div>
            <div class="particle" style="left: 70%; width: 9px; height: 9px; animation-delay: 2s; animation-duration: 10s;"></div>
            <div class="particle" style="left: 80%; width: 11px; height: 11px; animation-delay: 4s; animation-duration: 9s;"></div>
            <div class="particle" style="left: 90%; width: 13px; height: 13px; animation-delay: 1s; animation-duration: 11s;"></div>

            <div class="container mx-auto px-4 py-10 z-10">
                <div class="w-full max-w-xl mx-auto space-y-8 animate-fade-up">
                    <div class="flex items-center justify-center">
                        <div class="p-6 bg-white/25 backdrop-blur-lg rounded-3xl shadow-2xl logo-pulse">
                            <img src="{{ asset('asset/images/LogoEKDO.png') }}" alt="Logo EKDO" class="w-28 h-28 mx-auto">
                        </div>
                    </div>

                    <div class="glass-morphism rounded-3xl shadow-2xl p-8 lg:p-10">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
