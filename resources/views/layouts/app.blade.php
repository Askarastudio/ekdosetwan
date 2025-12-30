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
            :root {
                --brand-1: #3b82f6;
                --brand-2: #6366f1;
                --brand-3: #22c55e;
                --surface: #ffffff;
            }

            body.app-shell {
                background: radial-gradient(circle at 15% 20%, rgba(99, 102, 241, 0.12), transparent 28%),
                            radial-gradient(circle at 80% 0%, rgba(34, 197, 94, 0.12), transparent 25%),
                            radial-gradient(circle at 50% 50%, rgba(59, 130, 246, 0.12), transparent 35%),
                            #f7f9fb;
            }

            .aurora-blob {
                position: absolute;
                width: 32rem;
                height: 32rem;
                filter: blur(90px);
                opacity: 0.45;
                mix-blend-mode: screen;
                animation: floaty 18s ease-in-out infinite;
                z-index: -1;
            }

            .aurora-1 { top: -10%; left: -10%; background: radial-gradient(circle, rgba(99,102,241,0.9), transparent 55%); }
            .aurora-2 { top: 10%; right: -15%; background: radial-gradient(circle, rgba(34,197,94,0.9), transparent 55%); animation-delay: 3s; }
            .aurora-3 { bottom: -20%; left: 20%; background: radial-gradient(circle, rgba(59,130,246,0.9), transparent 55%); animation-delay: 6s; }

            .card-animate {
                transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
                box-shadow: 0 10px 30px rgba(15, 23, 42, 0.06);
                border: 1px solid rgba(226, 232, 240, 0.7);
            }

            .card-animate:hover {
                transform: translateY(-6px) scale(1.01);
                box-shadow: 0 18px 40px rgba(59, 130, 246, 0.15);
                border-color: rgba(99, 102, 241, 0.35);
            }

            .glass-panel {
                background: rgba(255, 255, 255, 0.85);
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
            }

            .table-animate tbody tr {
                transition: transform 0.2s ease, background-color 0.2s ease, box-shadow 0.2s ease;
            }

            .table-animate tbody tr:hover {
                transform: translateX(4px);
                background-color: #f8fafc;
                box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
            }

            .badge-soft {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                padding: 0.35rem 0.7rem;
                border-radius: 9999px;
                font-weight: 600;
                font-size: 0.75rem;
            }

            .fade-in { animation: fadeIn 0.6s ease-out forwards; opacity: 0; }
            .slide-up { animation: slideUp 0.65s ease-out forwards; opacity: 0; }

            .stagger > * { opacity: 0; animation: slideUp 0.65s ease-out forwards; }
            .stagger > *:nth-child(1) { animation-delay: 0.05s; }
            .stagger > *:nth-child(2) { animation-delay: 0.12s; }
            .stagger > *:nth-child(3) { animation-delay: 0.18s; }
            .stagger > *:nth-child(4) { animation-delay: 0.24s; }
            .stagger > *:nth-child(5) { animation-delay: 0.3s; }

            @keyframes fadeIn {
                from { opacity: 0; }
                to { opacity: 1; }
            }

            @keyframes slideUp {
                from { opacity: 0; transform: translateY(16px); }
                to { opacity: 1; transform: translateY(0); }
            }

            @keyframes floaty {
                0%, 100% { transform: translateY(0); }
                50% { transform: translateY(-18px); }
            }
        </style>
    </head>
    <body class="font-sans antialiased app-shell">
        <div class="min-h-screen bg-gray-100 relative overflow-hidden">
            <span class="aurora-blob aurora-1"></span>
            <span class="aurora-blob aurora-2"></span>
            <span class="aurora-blob aurora-3"></span>
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
