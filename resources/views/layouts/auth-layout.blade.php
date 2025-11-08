<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=cairo:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200 font-sans" dir="rtl">

    <!-- Navigation -->
    <nav class="bg-white dark:bg-gray-800 shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <a href="/" class="flex-shrink-0 text-2xl font-bold text-indigo-600 dark:text-indigo-400">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <a href="." class="text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 px-3 py-2 rounded-md text-sm font-medium">الرئيسية</a>
                        <a href="#" class="text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 px-3 py-2 rounded-md text-sm font-medium">الخدمات</a>
                        <a href="#" class="text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 px-3 py-2 rounded-md text-sm font-medium">اتصل بنا</a>
                    </div>
                </div>
                <div class="hidden md:block">
                     @if (Route::has('login'))
                        <div class="flex items-center space-x-4">
                             @auth
                                <a href="{{ url('/dashboard') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-indigo-700">لوحة التحكم</a>
                            @else
                                <a href="{{ route('login') }}" class="text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 px-3 py-2 rounded-md text-sm font-medium">تسجيل الدخول</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-indigo-700">إنشاء حساب</a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>
                <div class="-mr-2 flex md:hidden">
                    <!-- Mobile menu button -->
                    <button type="button" class="bg-gray-200 dark:bg-gray-700 inline-flex items-center justify-center p-2 rounded-md text-gray-800 dark:text-gray-200 hover:text-gray-900 dark:hover:text-white hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white" aria-controls="mobile-menu" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu, show/hide based on menu state. -->
        <div class="md:hidden" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <a href="/" class="text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 block px-3 py-2 rounded-md text-base font-medium">الرئيسية</a>
                <a href="#" class="text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 block px-3 py-2 rounded-md text-base font-medium">الخدمات</a>
                <a href="#" class="text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 block px-3 py-2 rounded-md text-base font-medium">اتصل بنا</a>
            </div>
             @if (Route::has('login'))
            <div class="pt-4 pb-3 border-t border-gray-200 dark:border-gray-700">
                <div class="flex items-center px-5">
                     @auth
                        <a href="{{ url('/dashboard') }}" class="w-full text-center bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-indigo-700">لوحة التحكم</a>
                    @else
                        <div class="w-full flex items-center space-x-4">
                            <a href="{{ route('login') }}" class="w-1/2 text-center text-gray-700 dark:text-gray-300 bg-gray-200 dark:bg-gray-700 px-3 py-2 rounded-md text-sm font-medium">تسجيل الدخول</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="w-1/2 text-center bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-indigo-700">إنشاء حساب</a>
                            @endif
                        </div>
                    @endauth
                </div>
            </div>
            @endif
        </div>
    </nav>

    <!-- Page Content -->
    <main class="py-20">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-white dark:bg-gray-800">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="xl:grid xl:grid-cols-3 xl:gap-8">
                <div class="space-y-8 xl:col-span-1">
                    <a href="/" class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                    <p class="text-gray-500 dark:text-gray-400 text-base">
                        منصة لتقديم وشراء الخدمات المصغرة.
                    </p>
                </div>
                <div class="mt-12 grid grid-cols-2 gap-8 xl:mt-0 xl:col-span-2">
                    <div class="md:grid md:grid-cols-2 md:gap-8">
                        <div>
                            <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">روابط سريعة</h3>
                            <ul class="mt-4 space-y-4">
                                <li><a href="/" class="text-base text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">الرئيسية</a></li>
                                <li><a href="#" class="text-base text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">الخدمات</a></li>
                            </ul>
                        </div>
                        <div class="mt-12 md:mt-0">
                            <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">قانوني</h3>
                            <ul class="mt-4 space-y-4">
                                <li><a href="#" class="text-base text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">سياسة الخصوصية</a></li>
                                <li><a href="#" class="text-base text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">شروط الاستخدام</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-8 border-t border-gray-200 dark:border-gray-700 pt-8 md:flex md:items-center md:justify-between">
                <p class="mt-8 text-base text-gray-400 md:mt-0 md:order-1">
                    &copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. جميع الحقوق محفوظة.
                </p>
            </div>
        </div>
    </footer>

    <script>
        const mobileMenuButton = document.querySelector('[aria-controls="mobile-menu"]');
        const mobileMenu = document.getElementById('mobile-menu');
        const svgs = mobileMenuButton.querySelectorAll('svg');

        if (mobileMenuButton) {
            mobileMenuButton.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
                svgs.forEach(svg => svg.classList.toggle('hidden'));
            });
        }
    </script>

</body>
</html>
