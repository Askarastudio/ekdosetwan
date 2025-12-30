<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

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
            
            <div class="container mx-auto px-4 py-8 z-10">
                <div class="flex flex-col lg:flex-row items-center justify-center gap-8 lg:gap-16">
                    <!-- Left Side - Branding -->
                    <div class="w-full lg:w-1/2 max-w-lg text-white text-center lg:text-left animate-slide-left">
                        <div class="mb-8 animate-float">
                            <div class="inline-block p-6 bg-white/20 backdrop-blur-lg rounded-3xl shadow-2xl">
                                <svg class="w-24 h-24 mx-auto lg:mx-0" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2L2 7v10c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V7l-10-5zm0 18c-3.31 0-6-2.69-6-6V8.5l6-3.3 6 3.3V14c0 3.31-2.69 6-6 6z"/>
                                    <path d="M9.5 11.5L11 13l3.5-3.5L13 8l-2 2-1.5-1.5z"/>
                                </svg>
                            </div>
                        </div>
                        <h1 class="text-4xl lg:text-5xl font-bold mb-4 drop-shadow-lg">
                            E-Peminjaman KDO
                        </h1>
                        <p class="text-xl lg:text-2xl mb-6 text-white/90">
                            Sekretariat DPRD Provinsi DKI Jakarta
                        </p>
                        <p class="text-lg text-white/80 leading-relaxed">
                            Sistem Manajemen Peminjaman Kendaraan Dinas Operasional yang Modern dan Terintegrasi
                        </p>
                    </div>
                    
                    <!-- Right Side - Login Form -->
                    <div class="w-full lg:w-1/2 max-w-md animate-slide-right">
                        <div class="glass-morphism rounded-3xl shadow-2xl p-8 lg:p-10">
                            {{ $slot }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
