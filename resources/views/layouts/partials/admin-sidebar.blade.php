<!-- Overlay للتحكم في القائمة على الموبايل -->
<div x-show="sidebarOpen" 
     @click="sidebarOpen = false" 
     class="fixed inset-0 z-20 bg-black bg-opacity-50 transition-opacity md:hidden"
     x-transition:enter="ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0">
</div>

<!-- القائمة الجانبية -->
<aside 
    x-show="sidebarOpen"
    x-transition:enter="transition ease-in-out duration-300 transform"
    x-transition:enter-start="ltr:-translate-x-full rtl:translate-x-full"
    x-transition:enter-end="translate-x-0"
    x-transition:leave="transition ease-in-out duration-300 transform"
    x-transition:leave-start="translate-x-0"
    x-transition:leave-end="ltr:-translate-x-full rtl:translate-x-full"
    class="fixed inset-y-0 z-30 flex flex-col w-64 bg-white dark:bg-gray-800 shadow-lg
           md:static md:inset-auto md:translate-x-0
           ltr:left-0 rtl:right-0"
>
    <!-- Logo -->
    <div class="flex items-center justify-center h-16 bg-gray-100 dark:bg-gray-700">
        <a href="{{ route('admin.dashboard') }}">
            <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
        </a>
    </div>

    <!-- روابط القائمة -->
    <nav class="flex-1 overflow-y-auto px-4 py-6 space-y-2">
        
        <x-admin-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
            {{-- يمكنك إضافة أيقونة SVG هنا --}}
            <span>{{ __('Dashboard') }}</span> {{-- تأكد من ترجمة 'Dashboard' --}}
        </x-admin-nav-link>

        <x-admin-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
            <span>{{ __('Users') }}</span>
        </x-admin-nav-link>

        <x-admin-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')">
            <span>{{ __('Categories') }}</span>
        </x-admin-nav-link>
        
        <x-admin-nav-link :href="route('admin.services.index')" :active="request()->routeIs('admin.services.*')">
            <span>{{ __('Services') }}</span>
        </x-admin-nav-link>

        <x-admin-nav-link :href="route('admin.attributes.index')" :active="request()->routeIs('admin.attributes.*')">
            <span>{{ __('Attributes') }}</span>
        </x-admin-nav-link>

        <hr class="dark:border-gray-600">

        <x-admin-nav-link :href="route('admin.regions.index')" :active="request()->routeIs('admin.regions.*')">
            <span>{{ __('Regions') }}</span>
        </x-admin-nav-link>

        <x-admin-nav-link :href="route('admin.cities.index')" :active="request()->routeIs('admin.cities.*')">
            <span>{{ __('Cities') }}</span>
        </x-admin-nav-link>

        <hr class="dark:border-gray-600">
        
        <x-admin-nav-link :href="route('admin.pages.index')" :active="request()->routeIs('admin.pages.*')">
            <span>{{ __('Pages') }}</span>
        </x-admin-nav-link>

        <x-admin-nav-link :href="route('admin.settings.index')" :active="request()->routeIs('admin.settings.*')">
            <span>{{ __('Settings') }}</span>
        </x-admin-nav-link>

        <hr class="dark:border-gray-600">

        <x-admin-nav-link :href="route('admin.languages.index')" :active="request()->routeIs('admin.languages.*')">
            <span>{{ __('Languages') }}</span>
        </x-admin-nav-link>

        <x-admin-nav-link :href="route('admin.translations.index')" :active="request()->routeIs('admin.translations.*')">
            <span>{{ __('Translations') }}</span>
        </x-admin-nav-link>

    </nav>
</aside>