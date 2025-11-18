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