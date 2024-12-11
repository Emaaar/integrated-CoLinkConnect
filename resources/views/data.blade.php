<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - CoLink</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="{{ asset('css/tailwind.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            lucide.createIcons();
        });
    </script>
</head>
<body class="bg-gray-50 text-gray-900">
    <div class="flex h-screen">
       <!-- Sidebar -->
       <aside class="bg-white shadow-md transition-all duration-300 ease-in-out flex flex-col"
                   :class="{ 'w-64': sidebarOpen, 'w-20': !sidebarOpen }">
                <div class="p-6 flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-blue-700" x-show="sidebarOpen">Dashboard</h1>
                    <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 hover:text-gray-600">
                        <i data-lucide="menu" class="h-6 w-6"></i>
                    </button>
                </div>
                <nav class="flex-grow mt-6 px-4 overflow-y-auto">
                    @php
                    $sidebarLinks = [
                        ['icon' => 'home', 'label' => 'Data Analysis', 'route' => 'data'],
                        ['icon' => 'file-text', 'label' => 'Contracting', 'route' => 'contracting2'],
                        ['icon' => 'file-text', 'label' => 'Records', 'route' => 'records'],
                        ['icon' => 'mail', 'label' => 'Messages', 'route' => 'admin.chat'],
                        ['icon' => 'book-open', 'label' => 'Blog', 'route' => 'blog'],
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
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex items-center space-x-2 px-4 py-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors duration-200">
                            <i data-lucide="log-out" class="w-5 h-5"></i>
                            <span x-show="sidebarOpen">Logout</span>
                        </button>
                    </form>
                </div>
            </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto">
            <div class="max-w-7xl mx-auto px-8 py-6">
                <!-- Header -->
                <header class="flex justify-between items-center mb-8">
                    <div class="relative">
                        <i data-lucide="search" class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-5 h-5"></i>
                        <input type="search" placeholder="Search..." class="pl-10 pr-4 py-2 w-64 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-shadow duration-200">
                    </div>
                    <div class="flex items-center space-x-4">
                        <button class="text-gray-500 hover:text-gray-700 transition-colors duration-200">
                            <i data-lucide="bell" class="h-6 w-6"></i>
                        </button>
                        <img src="{{ $user->avatar_url ?? asset('images/default-avatar.png') }}" alt="Avatar" class="w-10 h-10 rounded-full border-2 border-gray-200">
                    </div>
                </header>

               <!-- Dashboard Summary -->
               <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <!-- Total Partners Section -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Partners</h2>
        <p id="totalPartnersCount" class="text-3xl font-bold text-blue-600 mb-4">{{ $totalPartners ?? 'N/A' }}</p>
        

    </div>

  <!-- Total Donors Section -->
<div class="bg-white rounded-lg shadow-sm p-6">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Donations</h2>
    <p class="text-3xl font-bold text-green-600 mb-4">{{ $totalDonations ?? 'N/A' }}</p>

</div>
<div class="bg-white rounded-lg shadow-sm p-6">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Uplifted Youth</h2>
    <p class="text-3xl font-bold text-green-600 mb-4">{{ $totalDonations ?? 'N/A' }}</p>

</div>
<div class="bg-white rounded-lg shadow-sm p-6">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Interventions</h2>
    <p class="text-3xl font-bold text-green-600 mb-4">{{ $interventionsCount ?? 'N/A' }}</p>

</div>

            </div>
                <!-- Recent Breakthrough -->
<h2 class="text-2xl font-bold mb-6">Recent Breakthrough</h2>

<!-- Client List Header -->
<div class="grid grid-cols-4 font-semibold text-gray-700 border-b pb-2">
<div class="text-red-500">ID</div>
    <div>Name</div>
    <div>Organization</div>
    <div class="flex justify-between items-center"> <!-- Flex for aligning status and delete button -->
        <span>Status</span>
        <span></span> <!-- Empty span for spacing -->
    </div>
</div>

@if(isset($users) && $users->isNotEmpty())
        @foreach ($users as $client)
            <div class="grid grid-cols-4 py-4 border-b">
                <div>{{ $client->client_id }}</div>
                <div class="font-semibold">{{ $client->firstname }} {{ $client->lastname }}</div>
                <div>{{ $client->organization }}</div>
                <div class="flex justify-between items-center">
                    <span>
                        <span class="inline-block px-2 py-1 rounded-full text-xs font-medium
                            {{ $client->status === 'Completed' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $client->status === 'Pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $client->status === 'In Process' ? 'bg-blue-100 text-blue-800' : '' }}">
                            {{ $client->status }}
                        </span>
                    </span>
                    <!-- Delete button -->
                    @if($client->client_id)
                        <form id="delete-form-{{ $client->client_id }}" action="{{ route('clients.destroy', ['id' => $client->client_id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this client?')) document.getElementById('delete-form-{{ $client->client_id }}').submit();" class="text-red-500 hover:text-red-700 transition-colors duration-200">
                                <i data-lucide="trash-2" class="w-5 h-5"></i>
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @endforeach
    @else
        <div>No users found.</div>
    @endif
</div>
 


        </main>
    </div>
</body>
</html>