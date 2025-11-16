<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" 
      dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}"
      x-data="{ sidebarOpen: window.innerWidth >= 768 ? true : false }" 
      @resize.window="sidebarOpen = window.innerWidth >= 768 ? true : false">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* كود لتهيئة الـ scrollbar ليتناسب مع الوضع الفاتح */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-thumb {
            background-color: #a0aec0; /* bg-gray-400 */
            border-radius: 4px;
        }
        ::-webkit-scrollbar-track {
            background-color: #f7fafc; /* bg-gray-100 */
        }
    </style>
</head>
<body class="font-sans antialiased">
    
    @if (Auth::user()->role !== 'admin')
        <script>window.location = "/dashboard";</script>
    @endif

    <div class="flex h-screen bg-gray-100" 
         @keydown.escape.window="sidebarOpen = false">

        <!-- 1. القائمة الجانبية (Sidebar) -->
        @include('layouts.partials.admin-sidebar')

        <!-- 2. المحتوى الرئيسي والشريط العلوي -->
        <div class="flex-1 flex flex-col overflow-hidden">
            
            <!-- 2.1 الشريط العلوي (Top Navbar) -->
            @include('layouts.partials.admin-navigation')

            <!-- 2.2 المحتوى الرئيسي (Page Content) -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100">
                <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
                    
                    <!-- Page Heading -->
                    @if (isset($header))
                        <header class="mb-6">
                            <h1 class="text-3xl font-bold text-gray-800">
                                {{ $header }}
                            </h1>
                        </header>
                    @endif

                    <!-- Page Content -->
                    {{ $slot }}

                </div>
            </main>
        </div>
    </div>
</body>
</html>