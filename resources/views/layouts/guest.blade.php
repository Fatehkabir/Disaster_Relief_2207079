<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Disaster Relief Platform') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
        <!-- Bootstrap Icons (icon fonts only) -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

        <style>
            body { font-family: 'Inter', sans-serif; background: #f0f9ff; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        </style>
    </head>
    <body>
        <div class="w-100" style="max-width: 480px; margin: auto; padding: 2rem 1rem;">
            <div class="text-center mb-4">
                <a href="{{ route('login') }}" class="text-decoration-none">
                    <span style="font-size: 2.5rem;">🆘</span>
                    <div class="fw-bold text-dark mt-1">{{ config('app.name', 'Disaster Relief') }}</div>
                </a>
            </div>
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
