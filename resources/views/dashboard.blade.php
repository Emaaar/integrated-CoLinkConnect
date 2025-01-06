<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - CoLink</title>
    <!-- External Libraries -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Inline Styles -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            transition: background-color 0.3s, color 0.3s;
        }
        [x-cloak] { display: none; }
        .hover-lift {
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .hover-lift:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }
        .dark .bg-gray-800\/80 {
            background-color: rgba(31, 41, 55, 0.8);
        }
        .dark .text-gray-200 {
            color: #e5e7eb;
        }
        .dark .border-gray-700 {
            border-color: #374151;
        }
        .dark .text-gray-400 {
            color: #9ca3af;
        }
        .dark .hover\:text-gray-200:hover {
            color: #e5e7eb;
        }
        .dark .focus\:border-blue-500:focus {
            border-color: #3b82f6;
        }
        .dark .focus\:ring-blue-500:focus {
            --tw-ring-color: #3b82f6;
        }
        
    </style>
  <script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('searchComponent', () => ({
            isSearchOpen: false,
            searchQuery: '',
            searchResults: [],
            performSearch() {
                if (this.searchQuery.length > 0) {
                    // Simulate a search or make an API call
                    this.searchResults = [
                        { name: 'Result 1', route: '/result-1' },
                        { name: 'Result 2', route: '/result-2' },
                        { name: 'Result 3', route: '/result-3' },
                    ];
                } else {
                    this.searchResults = [];
                }
            }
        }));
    });

        document.addEventListener("DOMContentLoaded", () => {
            const fetchBreakthroughData = async () => {
                try {
                    const response = await fetch('/api/breakthrough-data');
                    const data = await response.json();

                    const labels = data.interventionsPerMonth.map(item => `Month ${item.month}`);
                    const counts = data.interventionsPerMonth.map(item => item.total);

                    const ctx = document.getElementById('chart').getContext('2d');
                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Interventions per Month',
                                data: counts,
                                backgroundColor: '#09359A',
                                borderColor: '#09359A',
                                borderWidth: 1,
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                title: {
                                    display: true,
                                    text: `Youth Count: ${data.youthCount}`
                                },
                                legend: {
                                    display: true
                                },
                                tooltip: {
                                    callbacks: {
                                        title: function(tooltipItem) {
                                            return `Month: ${tooltipItem[0].label}`;
                                        },
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true
                                },
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Months'
                                    }
                                }
                            }
                        }
                    });
                } catch (error) {
                    console.error('Error fetching breakthrough data:', error);
                }
            };

            fetchBreakthroughData();
        });

        function dashboard() {
    return {
        darkMode: false,
        searchQuery: '',
        searchResults: [],
        activeMenu: 'Dashboard',
        isSearchOpen: false,
        bgColor: '#09359A', // Define the background color
        navigationMenu: [
    {
        name: 'Dashboard',
        icon: 'layout-dashboard',
        route: '/dashboard',
        tooltip: 'View your dashboard',
        children: [
            {
                name: 'Data Analysis',
                icon: 'activity',
                route: '/data-analysis',
                tooltip: 'Analyze data and view reports',
            }
        ]
    },
    {
        name: 'Management',
        icon: 'layers',
        children: [
            { name: 'Tracker', route: '/tracker', tooltip: 'View progress tracking' },
            { name: 'Contracting', route: '/contracting', tooltip: 'Manage contracts' },
            { name: 'Needs Assessment', route: 'form/needs-assessment', tooltip: 'Assess needs and priorities' },
            { name: 'Activity Design', route: '/activity-design', tooltip: 'Plan and design activities' },
        ],
    },
    {
        name: 'Records',
        icon: 'file-text',
        route: '/records',
        tooltip: 'Manage and view records',
    },
    {
        name: 'Messages',
        icon: 'mail',
        route: '/chat',
        tooltip: 'Check your messages',
    },
    {
        name: 'Blog',
        icon: 'book-open',
        route: '/blog',
        tooltip: 'Read and manage blog posts',
    },


        ],
        applyHeaderStyle() {
            const header = document.querySelector('header');
            if (header) {
                header.style.backgroundColor = this.bgColor;
                header.style.color = 'white'; // Optional: Adjust text color for contrast
            }
        },
        performSearch() {
            this.searchResults = this.navigationMenu.filter(item => 
                item.name.toLowerCase().includes(this.searchQuery.toLowerCase()) || 
                (item.children && item.children.some(child => 
                    child.name.toLowerCase().includes(this.searchQuery.toLowerCase())
                ))
            );
        },
        setActive(menu) {
            this.activeMenu = menu;
        },
        toggleDarkMode() {
            this.darkMode = !this.darkMode;
            if (this.darkMode) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        },
    };
}
function searchComponent() {
        return {
            isSearchOpen: true, // Controls visibility of the search bar
            searchQuery: '', // Holds the input value
            searchResults: [], // Array to store search results

            performSearch() {
                // Example search logic
                const allResults = [
                    { id: 1, name: 'Dashboard 1', url: '/dashboard/1' },
                    { id: 2, name: 'Dashboard 2', url: '/dashboard/2' },
                    { id: 3, name: 'Metric A', url: '/metric/a' },
                ];

                if (this.searchQuery.trim() === '') {
                    this.searchResults = [];
                } else {
                    this.searchResults = allResults.filter((result) =>
                        result.name.toLowerCase().includes(this.searchQuery.toLowerCase())
                    );
                }
            },

            clearSearch() {
                this.searchQuery = '';
                this.searchResults = [];
            },

            closeSearch() {
                this.isSearchOpen = false;
            },
        };
    }
document.addEventListener("DOMContentLoaded", () => {
    lucide.createIcons();
    const dashboardApp = dashboard();
    dashboardApp.applyHeaderStyle(); // Apply header background color on page load
});
document.addEventListener('alpine:init', () => {
        Alpine.data('searchComponent', () => ({
            isSearchOpen: false,
            searchQuery: '',
            searchResults: [],
            selectedIndex: -1,
            init() {
                document.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape') {
                        this.closeSearch();
                    }
                });
            },
            performSearch() {
                if (this.searchQuery.length > 0) {
                    // Simulate a search or use an API call to fetch results
                    this.searchResults = [
                        { name: 'Result 1', route: '/result-1' },
                        { name: 'Result 2', route: '/result-2' },
                        { name: 'Result 3', route: '/result-3' },
                    ];
                } else {
                    this.searchResults = [];
                }
            },
            navigateSuggestions(e) {
                if (e.key === 'ArrowDown') {
                    if (this.selectedIndex < this.searchResults.length - 1) {
                        this.selectedIndex++;
                    }
                } else if (e.key === 'ArrowUp') {
                    if (this.selectedIndex > 0) {
                        this.selectedIndex--;
                    }
                }
            },
            selectSuggestion(result = null) {
                if (result) {
                    window.location.href = result.route; // Navigate to selected result
                } else if (this.selectedIndex >= 0 && this.searchResults[this.selectedIndex]) {
                    window.location.href = this.searchResults[this.selectedIndex].route; // Navigate to the selected suggestion
                }
            },
            closeSearch() {
                this.isSearchOpen = false;
            }
        }));
    });
    </script>
</head>
<body 
    class="bg-[#f8fafc] text-gray-900" 
    x-data="dashboard()"
>
<div class="flex h-screen" style="background-color: #EDA900;">
        <aside class="w-64 bg-white border-r border-[#EDA900]-100 flex flex-col">
            <div class="p-5 flex items-center justify-center border-b border-gray-50 h-20">
                <img src="{{ asset('/images/CoLinklogo.jpg') }}" alt="CoLink Logo" class="w-27 h-10">
            </div>
            <nav class="flex-grow pt-5">
                <ul class="space-y-0.5">
                    <template x-for="menu in navigationMenu" :key="menu.name">
                        <li>
                            <a 
                                :href="menu.route" 
                                class="flex items-center px-5 py-2 text-sm text-gray-600 hover:bg-gray-50 hover:text-primary transition-colors"
                                :class="{'text-primary bg-blue-50 font-medium': activeMenu === menu.name}"
                                @click="setActive(menu.name)"
                            >
                            <i :data-lucide="menu.icon" class="w-4 h-4 mr-3"></i>
                            <span x-text="menu.name"></span>
                            </a>
                            <ul x-show="menu.children" x-cloak class="pl-12 py-2 space-y-1">
                                <template x-for="child in menu.children" :key="child.name">
                                    <li>
                                        <a 
                                            :href="child.route" 
                                            class="block py-1 text-xs text-gray-500 hover:text-primary transition-colors"
                                        >
                                            <span x-text="child.name"></span>
                                        </a>
                                    </li>
                                </template>
                            </ul>
                        </li>
                    </template>
                </ul>
            </nav>
            <div class="border-t border-gray-50 p-5 flex items-center">
    @if(Auth::check()) <!-- Check if the user is authenticated -->
        <img src="{{ Auth::user()->avatar_url ?? asset('images/colinklogo.png') }}" alt="User Avatar" class="w-8 h-8 rounded-full">
        <div class="ml-3">
            @if(Auth::user()->is_admin) <!-- Directly check if the user is an admin -->
                <p class="text-sm font-medium text-gray-900">Admin: {{ Auth::user()->name }}</p>
                <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
            @else
                <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                <p class="text-xs text-gray-500">{{ Auth::user()->email ?? 'No email' }}</p>
            @endif
        </div>
    @else
        <p class="text-sm font-medium text-gray-900">Guest</p>
        <p class="text-xs text-gray-500">No email</p>
    @endif
</div>



         
              <!-- Logout Button -->
              <div class="border-t border-gray-50 p-5">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full py-2 bg-[#EDA900] text-white rounded-md hover:bg-[#EDA900]/80">
    Logout
</button>

                </form>
            </div>
        </aside>

        <main class="flex-1 overflow-auto bg-[#f8fafc]">
        <header class="h-16 px-6 flex items-center justify-between border-b border-gray-100">
    <div class="flex items-center space-x-4">
        <h1 class="text-lg font-medium">Dashboard</h1>
    </div>
    <div class="flex items-center space-x-4">
        <button @click="isSearchOpen = !isSearchOpen" class="p-2 text-gray-400 hover:text-gray-600 transition-colors">
            <i data-lucide="search" class="w-5 h-5"></i>
        </button>
        <button @click="toggleDarkMode" class="p-2 text-gray-400 hover:text-gray-600 transition-colors">
            <i data-lucide="moon" class="w-5 h-5"></i>
        </button>
    </div>
</header>
<div x-show="isSearchOpen" x-cloak class="fixed top-0 left-0 right-0 bottom-0 bg-transparent backdrop-blur-sm backdrop-brightness-50 shadow-lg z-20 flex justify-center items-start p-4">
    <!-- Full Page Search Bar Container -->
    <div class="w-full max-w-4xl mx-auto mt-20 relative bg-gray-900 rounded-lg shadow-xl text-gray-100">
        <!-- Search Bar -->
        <div class="flex items-center justify-between px-4 py-3 border-b border-gray-700">
            <!-- Left: Search Input -->
            <div class="flex items-center w-full">
                <i class="text-gray-400 mr-2" data-lucide="search"></i>
                <input 
                    type="text" 
                    x-model="searchQuery" 
                    @input="performSearch" 
                    class="w-full bg-transparent text-gray-100 placeholder-gray-400 focus:outline-none"
                    placeholder="Enter a keyword..."
                >
            </div>
            <!-- Right: Clear and Close Buttons -->
            <div class="flex items-center space-x-4">
                <button 
                    @click="searchQuery = ''" 
                    class="text-gray-400 hover:text-gray-200 text-sm"
                >
                    Clear
                </button>
                <button 
                    @click="isSearchOpen = false" 
                    class="text-gray-400 hover:text-gray-200 text-sm"
                >
                    Close
                </button>
            </div>
        </div>

    <!-- Search Results / Default Content / No Results -->
<div class="px-4 py-6">
    <!-- Default Content -->
    <div x-show="searchQuery.length === 0" class="text-center text-gray-400">
        <p class="text-lg font-semibold">Start typing to search</p>
        <p class="text-sm text-gray-400 mt-1">Search metrics and dashboards available in your account</p>
    </div>

    <!-- "No results found" Message -->
    <div 
        x-show="searchQuery.length > 0 && searchResults.length === 0" 
        class="text-center"
        x-init="handleNoResults()"
    >
        <p class="text-lg font-semibold">No results found</p>
        <p class="text-sm text-gray-400 mt-1">No assets in your account match this search request</p>
    </div>

    <!-- Search Results -->
    <ul x-show="searchResults.length > 0" class="space-y-2">
        <template x-for="result in searchResults" :key="result.id">
            <li>
                <a 
                    :href="result.url" 
                    class="block py-2 px-4 bg-gray-800 rounded hover:bg-gray-700 transition"
                >
                    <span x-text="result.name"></span>
                </a>
            </li>
        </template>
    </ul>

            <!-- "Help/Support" Footer -->
            <div class="mt-8 flex justify-between items-center text-sm border-t border-gray-700 pt-4">
                <div class="flex space-x-2">
                    <span class="bg-gray-800 px-2 py-1 rounded text-gray-400">↩ select</span>
                    <span class="bg-gray-800 px-2 py-1 rounded text-gray-400">↑↓ navigate</span>
                    <span class="bg-gray-800 px-2 py-1 rounded text-gray-400">esc close</span>
                </div>
               
            </div>
        </div>
    </div>
</div>



<!-- Content -->
            <div class="p-6 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="bg-white p-6 rounded-lg shadow-lg hover-lift">
                        <h3 class="text-md font-medium text-gray-900 mb-3">Youth Uplifted</h3>
                        <p class="text-gray-500">Number of youth uplifted this month.</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-lg hover-lift">
                        <h3 class="text-md font-medium text-gray-900 mb-3">Partners</h3>
                        <p class="text-gray-500">Details of partners engaged in projects.</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-lg hover-lift">
                        <h3 class="text-md font-medium text-gray-900 mb-3">Intervention</h3>
                        <p class="text-gray-500">Details of interventions performed.</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-lg hover-lift">
                        <h3 class="text-md font-medium text-gray-900 mb-3">Donation</h3>
                        <p class="text-gray-500">Track donations made this year.</p>
                    </div>
                </div>
             <!-- Chart Section -->
<div class="bg-white p-6 rounded-lg shadow-lg">
    <!-- Chart Title -->
    <h2 class="text-lg font-semibold text-gray-900 mb-4">Recent Breakthrough</h2>
    
    <!-- Chart Canvas -->
    <canvas id="chart" height="200"></canvas>

    <!-- Chart Description -->
    <div class="mt-4">
        <p class="text-sm text-gray-600">This chart displays the number of interventions per month. Track progress and performance to better understand the impact of initiatives over time.</p>
    </div>
</div>

                <!-- 4 Divs for Youth Uplifted, Partners, Intervention, and Donation -->
              
            </div>
        </main>
    </div>
</body>
</html>
