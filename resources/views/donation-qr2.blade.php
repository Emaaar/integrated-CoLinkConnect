<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CoLink - Donation</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
        }
        .sidebar-link.active {
            @apply bg-blue-50 text-blue-600;
        }
        .sidebar-link.active i {
            @apply text-blue-600;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="flex h-screen" x-data="{ sidebarOpen: true }">
        <!-- Sidebar -->
        <aside class="bg-white shadow-md transition-all duration-300 ease-in-out"
               :class="{ 'w-64': sidebarOpen, 'w-20': !sidebarOpen }">
            <div class="p-6 flex items-center justify-between">
                <h1 class="text-2xl font-bold text-blue-600" x-show="sidebarOpen"><a href="{{ route('home') }}">CoLink</a></h1>
                <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 hover:text-gray-600">
                    <i data-lucide="menu" class="h-6 w-6"></i>
                </button>
            </div>
            <nav class="mt-6 px-4">
                @php
                $sidebarLinks = [
                    // ['icon' => 'home', 'label' => 'Dashboard', 'route' => 'home'],
                    ['icon' => 'home', 'label' => 'Profile', 'route' => 'profile'],
                    ['icon' => 'bar-chart-2', 'label' => 'Progress Tracker', 'route' => 'progress'],
                    ['icon' => 'heart', 'label' => 'Donate', 'route' => 'donation'],
                    ['icon' => 'message-circle', 'label' => 'Chat Support', 'route' => 'chat.index'],
                    ['icon' => 'mail', 'label' => 'Contact us', 'route' => 'contact'],
                ];
                @endphp

                @foreach($sidebarLinks as $link)
                    <a href="{{ route($link['route']) }}"
                       class="sidebar-link flex items-center space-x-2 px-4 py-3 rounded-lg mb-2 transition-colors duration-200 {{ request()->routeIs($link['route']) ? 'active' : 'text-gray-700 hover:bg-gray-100' }}">
                        <i data-lucide="{{ $link['icon'] }}" class="w-5 h-5"></i>
                        <span x-show="sidebarOpen">{{ $link['label'] }}</span>
                    </a>
                @endforeach
            </nav>
            @auth
                <div class="absolute bottom-0 w-full p-4">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex items-center space-x-2 px-4 py-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors duration-200">
                            <i data-lucide="log-out" class="w-5 h-5"></i>
                            <span x-show="sidebarOpen">Logout</span>
                        </button>
                    </form>
                </div>
            @endauth
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm border-b">
                <div class="flex items-center justify-between px-6 py-4">
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <i data-lucide="search" class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-gray-400"></i>
                            <input
                                type="text"
                                placeholder="Search..."
                                class="pl-10 pr-4 py-2 w-[300px] rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        @auth
                            <button class="relative p-2 text-gray-500 hover:text-gray-600 hover:bg-gray-100 rounded-full transition-colors duration-200">
                                <i data-lucide="bell" class="h-6 w-6"></i>
                                <span class="absolute top-0 right-0 h-2 w-2 bg-red-500 rounded-full"></span>
                            </button>
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                                    <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white font-semibold">
                                        {{ substr(Auth::user()->firstname, 0, 1) }}
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">{{ Auth::user()->firstname }}</span>
                                    <i data-lucide="chevron-down" class="w-4 h-4 text-gray-500"></i>
                                </button>
                                <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border py-2">
                                    <a href="{{ route('profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-medium">Login</a>
                            <a href="{{ route('registration') }}" class="text-blue-600 hover:text-blue-800 font-medium">Register</a>
                        @endauth
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100">
                <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                    <div class="bg-white shadow-md rounded-lg overflow-hidden">
                        <div class="p-6 bg-blue-600 text-white">
                            <h2 class="text-2xl font-semibold mb-2">Donate via Maya</h2>
                            <p class="text-blue-100">Scan the QR code below to make your donation</p>
                        </div>
                        <div class="p-6 flex flex-col items-center">
                            <div id="qr-container" class="mb-6">
                                <img src="/images/paymaya-qr.jpg" alt="GCash QR Code" class="w-64 h-64 mx-auto">
                            </div>
                            <h3 class="text-xl font-semibold mb-2">ARLON BOI CARILIMAN</h3>
                            <p class="text-lg text-gray-600 mb-4">0951 582 8946</p>
                            <p class="text-sm text-gray-500">Thank you for your support!</p>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
