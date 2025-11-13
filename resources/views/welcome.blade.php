@extends('layouts.new_app')

@section('content')
<!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar -->
            <aside class="lg:w-64 flex-shrink-0">
                <div class="bg-white rounded-xl shadow-md p-6 mb-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">تصنيفات الخدمات</h2>
                    <div class="space-y-2">
                        @php
                            $categories = [
                                ['icon' => 'laptop-code', 'name' => 'البرمجة والتقنية'],
                                ['icon' => 'paint-brush', 'name' => 'التصميم والإبداع'],
                                ['icon' => 'bullhorn', 'name' => 'التسويق الرقمي'],
                                ['icon' => 'file-alt', 'name' => 'الكتابة والترجمة'],
                                ['icon' => 'video', 'name' => 'الفيديو والصوتيات'],
                                ['icon' => 'shopping-cart', 'name' => 'المبيعات والخدمات'],
                            ];
                        @endphp

                        @foreach($categories as $category)
                            <div class="category-item border border-gray-200 rounded-lg p-3 cursor-pointer transition-colors duration-200">
                                <div class="flex items-center space-x-3 space-x-reverse">
                                    <div class="bg-blue-50 w-10 h-10 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-{{ $category['icon'] }} text-blue-600"></i>
                                    </div>
                                    <span class="font-medium text-gray-700">{{ $category['name'] }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Filters -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">تصفية النتائج</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">السعر</label>
                            <div class="flex items-center space-x-2 space-x-reverse">
                                <input type="number" placeholder="من" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-100">
                                <span class="text-gray-500">إلى</span>
                                <input type="number" placeholder="إلى" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-100">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">التقييم</label>
                            <div class="flex space-x-1 space-x-reverse">
                                @for($i = 1; $i <= 5; $i++)
                                    <button class="text-yellow-400"><i class="fas fa-star"></i></button>
                                @endfor
                            </div>
                        </div>
                        <button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg transition-colors duration-200">
                            تطبيق التصفية
                        </button>
                    </div>
                </div>
            </aside>

            <!-- Services Grid -->
            <div class="flex-1">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">جميع الخدمات</h2>
                    <div class="flex items-center space-x-2 space-x-reverse">
                        <span class="text-gray-600">ترتيب حسب:</span>
                        <select class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-100">
                            <option>الأحدث</option>
                            <option>الأكثر مبيعاً</option>
                            <option>الأعلى تقييماً</option>
                            <option>السعر: منخفض إلى مرتفع</option>
                            <option>السعر: مرتفع إلى منخفض</option>
                        </select>
                    </div>
                </div>

                <!-- Services Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @php
                        $services = [
                            ['title' => 'تصميم موقع ويب احترافي', 'price' => 50, 'rating' => 4.8, 'provider' => 'أحمد محمد', 'color' => '2563eb'],
                            ['title' => 'تطوير تطبيق جوال', 'price' => 120, 'rating' => 4.9, 'provider' => 'سارة علي', 'color' => '1d4ed8'],
                            ['title' => 'تصميم شعار احترافي', 'price' => 30, 'rating' => 4.7, 'provider' => 'خالد عبدالله', 'color' => 'dc2626'],
                            ['title' => 'حملة تسويق رقمي', 'price' => 80, 'rating' => 4.6, 'provider' => 'منى أحمد', 'color' => '7c3aed'],
                            ['title' => 'كتابة محتوى احترافي', 'price' => 25, 'rating' => 4.8, 'provider' => 'فاطمة حسن', 'color' => 'ea580c'],
                            ['title' => 'تحرير فيديو احترافي', 'price' => 60, 'rating' => 4.9, 'provider' => 'علي سالم', 'color' => '0891b2'],
                        ];
                    @endphp

                    @foreach($services as $service)
                        <div class="service-card bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300">
                            <div class="h-48 bg-gray-200 relative">
                                <img src="https://placehold.co/400x300/{{ $service['color'] }}/white?text={{ urlencode($service['title']) }}" alt="{{ $service['title'] }}" class="w-full h-full object-cover">
                                <div class="absolute top-3 right-3 bg-blue-600 text-white px-2 py-1 rounded-lg text-sm font-medium">
                                    ${{ $service['price'] }}
                                </div>
                            </div>
                            <div class="p-4">
                                <div class="flex items-center justify-between mb-2">
                                    <h3 class="font-bold text-lg text-gray-900">{{ $service['title'] }}</h3>
                                    <div class="flex items-center space-x-1 space-x-reverse">
                                        <i class="fas fa-star text-yellow-400"></i>
                                        <span class="text-sm text-gray-600">{{ $service['rating'] }}</span>
                                    </div>
                                </div>
                                <p class="text-gray-600 text-sm mb-3">وصف مختصر للخدمة يوضح ما الذي سيحصل عليه العميل عند طلب هذه الخدمة.</p>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-2 space-x-reverse">
                                        <div class="w-8 h-8 bg-gray-200 rounded-full"></div>
                                        <span class="text-sm font-medium text-gray-700">{{ $service['provider'] }}</span>
                                    </div>
                                    <a href="#" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded-lg text-sm transition-colors duration-200">
                                        عرض التفاصيل
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8 flex items-center justify-center space-x-2 space-x-reverse">
                    <button class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                        السابق
                    </button>
                    <button class="px-4 py-2 bg-blue-600 text-white rounded-lg">1</button>
                    <button class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">2</button>
                    <button class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">3</button>
                    <button class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                        التالي
                    </button>
                </div>
            </div>
        </div>
    </main>
@endsection
