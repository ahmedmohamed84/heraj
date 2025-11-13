<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>موقع حراج</title>


    {{-- Tailwind CSS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet" />
    <link href="{{ asset('new-design/css/style.css') }}" rel="stylesheet" />
</head>
<body class="bg-gray-100">
    <!-- Header -->
    <header class="bg-white shadow-md">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center">
                    <a href="/" class="text-2xl font-bold text-indigo-600">حراج</a>
                    <nav class="hidden md:flex space-x-reverse space-x-4 mr-6">
                        <a href="#" class="text-gray-600 hover:text-indigo-600">الرئيسية</a>
                        <a href="#" class="text-gray-600 hover:text-indigo-600">الأقسام</a>
                        <a href="#" class="text-gray-600 hover:text-indigo-600">اتصل بنا</a>
                    </nav>
                </div>
                <div class="flex items-center">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">لوحة التحكم</a>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-600 hover:text-indigo-600 ml-4">دخول</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">تسجيل</a>
                            @endif
                        @endauth
                    @endif
                    <button id="mobile-menu-button" class="md:hidden ml-4 text-gray-600 hover:text-indigo-600">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>
        </div>
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-white">
            <nav class="flex flex-col space-y-2 px-4 py-2">
                <a href="#" class="text-gray-600 hover:text-indigo-600">الرئيسية</a>
                <a href="#" class="text-gray-600 hover:text-indigo-600">الأقسام</a>
                <a href="#" class="text-gray-600 hover:text-indigo-600">اتصل بنا</a>
            </nav>
        </div>
    </header>

    <main class="container mx-auto px-4 py-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-xl font-bold">حراج</h3>
                    <p class="mt-2 text-gray-400">منصة لبيع وشراء الخدمات والمنتجات.</p>
                </div>
                <div>
                    <h3 class="text-xl font-bold">روابط سريعة</h3>
                    <ul class="mt-2 space-y-2">
                        <li><a href="#" class="hover:text-indigo-400">الرئيسية</a></li>
                        <li><a href="#" class="hover:text-indigo-400">الأقسام</a></li>
                        <li><a href="#" class="hover:text-indigo-400">اتصل بنا</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-xl font-bold">صفحاتنا</h3>
                    <ul class="mt-2 space-y-2">
                        @foreach ($pages as $page)
                            <li><a href="{{ route('page.show', $page) }}" class="hover:text-indigo-400">{{ $page->title }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="mt-8 border-t border-gray-700 pt-4 text-center">
                <p>&copy; {{ date('Y') }} حراج. جميع الحقوق محفوظة.</p>
            </div>
        </div>
    </footer>

    <script src="{{ asset('new-design/js/scripts.js') }}"></script>
</body>
</html>
