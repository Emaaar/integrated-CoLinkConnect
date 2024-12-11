<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Upload Blog - CoLink</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-900">
<div class="flex flex-col h-screen md:flex-row">
        <!-- Sidebar -->
        <aside class="w-full md:w-64 bg-white border-r border-gray-200 md:block hidden" id="sidebar">
        <div class="p-6">
            <h1 class="text-2xl font-bold text-blue-600">Dashboard</h1>
        </div>
        <nav class="mt-6 space-y-1">
            @php
                    $sidebarLinks = [
                        ['icon' => 'home', 'label' => 'Data Analysis', 'url' => url('/dashboard')],
                        ['icon' => 'file-text', 'label' => 'Contracting', 'url' => url('/contracting')],
                        ['icon' => 'file-text', 'label' => 'Records', 'url' => url('/records')],
                        ['icon' => 'mail', 'label' => 'Messages', 'url' => url('/messages')],
                        ['icon' => 'book-open', 'label' => 'Blog', 'url' => url('/uploadblog')],
                    ];
                @endphp

@foreach($sidebarLinks as $link)
            <a href="{{ $link['url'] }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:text-blue-600 transition-colors duration-200">
                <i data-lucide="{{ $link['icon'] }}" class="w-5 h-5 mr-3"></i>
                <span class="text-sm font-medium">{{ $link['label'] }}</span>
            </a>
            @endforeach
        </nav>
        <div class="absolute bottom-0 w-full p-6">
            <a href="/" class="flex items-center text-red-500 hover:text-red-600 transition-colors duration-200">
                <i data-lucide="log-out" class="w-5 h-5 mr-3"></i>
                <span class="text-sm font-medium">Logout</span>
            </a>
        </div>
    </aside>
    <!-- Toggle Button -->
    <button class="block md:hidden p-4 text-blue-600" onclick="toggleSidebar()">
        <i data-lucide="menu" class="w-6 h-6"></i>
    </button>


        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto p-4">
            <!-- Top Bar -->
           <!-- Top Bar -->
        <header class="bg-white border-b border-gray-200 mb-4">
            <div class="flex items-center justify-between px-4 py-2">
                <div class="relative w-full">
                    <i data-lucide="search" class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-5 h-5"></i>
                    <input 
                        id="searchInput"  
                        type="text"
                        placeholder="Search blog posts..." 
                        class="pl-10 pr-4 py-2 w-full rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        oninput="showSuggestions()"
                    >
                    <div id="suggestions" class="absolute z-10 bg-white border border-gray-300 rounded-md mt-1 w-full hidden shadow-lg"></div>
                </div>
                <div class="flex items-center space-x-4">
                    <button class="text-gray-500 hover:text-gray-700 transition-colors duration-200">
                        <i data-lucide="bell" class="h-6 w-6"></i>
                    </button>
                    <button class="text-gray-500 hover:text-gray-700 transition-colors duration-200">
                        <i data-lucide="user" class="h-6 w-6"></i>
                    </button>
                </div>
            </div>
        </header>

      <!-- Upload Form -->
<div class="bg-white rounded-lg shadow-sm p-4 mb-8">
    <h2 class="text-lg font-semibold mb-4">Create New Post</h2>
    <form id="uploadForm" action="{{ route('uploadblog') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <label for="file-upload" class="flex flex-col items-center justify-center h-48 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
            <div class="flex flex-col items-center justify-center">
                <i data-lucide="upload-cloud" class="w-8 h-8 mb-2 text-gray-400"></i>
                <p class="text-sm text-gray-500"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                <p class="text-xs text-gray-500">PNG, JPG, or GIF</p>
            </div>
            <input id="file-upload" name="file" type="file" class="hidden" onchange="previewFile(event)" />
        </label>
        <!-- Preview Image -->
        <div id="preview-container" class="hidden mt-4">
            <img id="preview" src="" alt="Preview" class="max-w-full h-auto rounded-lg">
        </div>
        <!-- Title Input -->
        <input type="text" name="title" placeholder="Enter title..." class="w-full px-3 py-2 text-sm rounded-md border focus:ring-blue-500">
        <!-- Caption Input -->
        <textarea name="caption" placeholder="Write caption..." rows="3" class="w-full px-3 py-2 text-sm rounded-md border focus:ring-blue-500"></textarea>
        <!-- Submit Button -->
        <button type="submit" class="w-full py-2 text-sm bg-blue-500 text-white rounded-md hover:bg-blue-600">
            Publish Post
        </button>
    </form>
</div>


          <!-- Blog Posts -->
        <div id="blogPostsContainer" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
            @foreach ($blogPosts as $post)
            <div class="bg-white rounded-lg shadow p-4">
                <h3 class="text-lg font-semibold mb-2">{{ $post->title }}</h3>
                @if ($post->image)
                <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="w-full h-40 object-cover rounded-md mb-2">
                @endif
                <p class="text-gray-600 text-sm">{{ $post->caption }}</p>
            </div>
            @endforeach
        </div>
    </main>
</div>
    </div>

    <script>
        const blogPosts = JSON.parse(document.getElementById('blogPostsContainer').dataset.posts);

        lucide.createIcons();

        function previewFile(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('preview');
    const previewContainer = document.getElementById('preview-container');

    if (file) {
        const reader = new FileReader();

        reader.onload = function (e) {
            preview.src = e.target.result; // Set the image source to the file's data URL
            previewContainer.classList.remove('hidden'); // Make the preview container visible
        };

        reader.readAsDataURL(file); // Read the file as a data URL
    } else {
        previewContainer.classList.add('hidden'); // Hide the preview container if no file is selected
    }
}

        function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('hidden');
    }

        function filterPosts() {
            const searchInput = document.getElementById('searchInput').value.toLowerCase();
            const blogPosts = document.querySelectorAll('.blog-post');

            blogPosts.forEach(post => {
                const title = post.getAttribute('data-title').toLowerCase();
                post.style.display = title.includes(searchInput) ? '' : 'none';
            });
        }
        function showSuggestions() {
    const searchInput = document.getElementById('searchInput').value.toLowerCase();
    const suggestionsBox = document.getElementById('suggestions');
    const blogPosts = JSON.parse(document.getElementById('blogPostsContainer').dataset.posts); // Fetching blog posts data

    // Clear previous suggestions
    suggestionsBox.innerHTML = '';

    if (searchInput === '') {
        suggestionsBox.classList.add('hidden');
        return;
    }

    const filteredPosts = blogPosts.filter(post => post.title.toLowerCase().includes(searchInput));

    if (filteredPosts.length > 0) {
        suggestionsBox.classList.remove('hidden');
        filteredPosts.forEach(post => {
            const suggestionItem = document.createElement('div');
            suggestionItem.classList.add('px-4', 'py-2', 'hover:bg-gray-100', 'cursor-pointer');
            suggestionItem.textContent = post.title;

            // Handle click on a suggestion
            suggestionItem.onclick = function () {
                document.getElementById('searchInput').value = post.title;
                suggestionsBox.classList.add('hidden');
            };

            suggestionsBox.appendChild(suggestionItem);
        });
    } else {
        const noResults = document.createElement('div');
        noResults.classList.add('px-4', 'py-2', 'text-gray-500');
        noResults.textContent = 'No results found';
        suggestionsBox.appendChild(noResults);
        suggestionsBox.classList.remove('hidden');
    }
}
    </script>
</body>
</html>
