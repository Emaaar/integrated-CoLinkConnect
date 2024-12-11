<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CoLink - User Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
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
        <aside class="bg-white shadow-md transition-all duration-300 ease-in-out flex flex-col"
                :class="{ 'w-64': sidebarOpen, 'w-20': !sidebarOpen }">
            <div class="p-6 flex items-center justify-between">
                <h1 class="text-2xl font-bold text-blue-700" x-show="sidebarOpen"><a href="{{ route('home') }}">CoLink</a></h1>
                <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 hover:text-gray-600">
                    <i data-lucide="menu" class="h-6 w-6"></i>
                </button>
            </div>
            <nav class="flex-grow mt-6 px-4 overflow-y-auto">
                @php
                $sidebarLinks = [
                    // ['icon' => 'home', 'label' => 'Dashboard', 'route' => 'home'],
                    ['icon' => 'home', 'label' => 'Home', 'route' => 'home'],
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
            <div class="p-4 mt-auto">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center space-x-2 px-4 py-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors duration-200">
                        <i data-lucide="log-out" class="w-5 h-5"></i>
                        <span x-show="sidebarOpen">Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm border-b">
                <div class="flex items-center justify-between px-6 py-4">
                    <h2 class="text-xl font-semibold text-gray-800">User Profile</h2>
                    <div class="flex items-center space-x-4">
                        <button class="relative p-2 text-gray-500 hover:text-gray-600 hover:bg-gray-100 rounded-full transition-colors duration-200">
                            <i data-lucide="bell" class="h-6 w-6"></i>
                            <span class="absolute top-0 right-0 h-2 w-2 bg-red-500 rounded-full"></span>
                        </button>
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                                <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white font-semibold">
                                    {{ substr($user->firstname, 0, 1) }}
                                </div>
                                <span class="text-sm font-medium text-gray-700">{{ $user->firstname }}</span>
                                <i data-lucide="chevron-down" class="w-4 h-4 text-gray-500"></i>
                            </button>
                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border py-2">
                                <a href="{{ route('profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                @if (session('status'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('status') }}</span>
                    </div>
                @endif

                <div class="max-w-4xl mx-auto">
                    <div class="bg-white shadow-md rounded-lg overflow-hidden mb-6">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Personal Information</h3>
                            <form action="{{ route('profile.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="grid grid-cols-2 gap-6">
                                    <div>
                                        <label for="firstname" class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                                        <input type="text" name="firstname" id="firstname" value="{{ $user->firstname }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                    <div>
                                        <label for="lastname" class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                                        <input type="text" name="lastname" id="lastname" value="{{ $user->lastname }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                    <div>
                                        <label for="user_email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                        <input type="email" name="user_email" id="user_email" value="{{ $user->user_email }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                    <div>
                                        <label for="organization" class="block text-sm font-medium text-gray-700 mb-1">Organization</label>
                                        <input type="text" name="organization" id="organization" value="{{ $user->organization }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                </div>
                                <div class="mt-6">
                                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                        Update Profile
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="bg-white shadow-md rounded-lg overflow-hidden">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Change Password</h3>
                            <form action="{{ route('profile.change-password') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="space-y-4">
                                    <div>
                                        <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                                        <input type="password" name="current_password" id="current_password" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                    <div>
                                        <label for="new_password" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                                        <input type="password" name="new_password" id="new_password" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                    <div>
                                        <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                                        <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                </div>
                                <div class="mt-6">
                                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                        Change Password
                                    </button>
                                </div>
                            </form>
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
