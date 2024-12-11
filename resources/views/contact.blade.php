<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CoLink - Contact Us</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex flex-col">
        <header class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex justify-between items-center">
                    <h1 class="text-2xl font-semibold text-gray-900">Contact Us</h1>
                    <a href="{{ route('home') }}" class="flex items-center text-gray-600 hover:text-gray-900">
                        <i data-lucide="arrow-left" class="w-5 h-5 mr-2"></i>
                        Back to Home
                    </a>
                </div>
            </div>
        </header>

        <main class="flex-grow">
            <div class="max-w-7xl mx-auto py-12 sm:px-6 lg:px-8">
                <div class="bg-white shadow-xl rounded-lg overflow-hidden">
                    <div class="px-4 py-5 sm:p-6">
                        <h2 class="text-3xl font-extrabold text-gray-900 mb-6">Get in Touch</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <p class="text-lg text-gray-700 mb-4">We'd love to hear from you. Please fill out this form and we will get in touch with you shortly.</p>
                                <div class="space-y-4">
                                    <div class="flex items-center">
                                        <i data-lucide="map-pin" class="w-6 h-6 text-blue-600 mr-2"></i>
                                        <span class="text-gray-700">123 Business Ave, Suite 100, City, State 12345</span>
                                    </div>
                                    <div class="flex items-center">
                                        <i data-lucide="phone" class="w-6 h-6 text-blue-600 mr-2"></i>
                                        <span class="text-gray-700">+1 (555) 123-4567</span>
                                    </div>
                                    <div class="flex items-center">
                                        <i data-lucide="mail" class="w-6 h-6 text-blue-600 mr-2"></i>
                                        <span class="text-gray-700">info@colink.com</span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                @if(session('success'))
                                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                                        <span class="block sm:inline">{{ session('success') }}</span>
                                    </div>
                                @endif

                                <form action="{{ route('contact.submit') }}" method="POST">
                                    @csrf
                                    <div class="space-y-4">
                                        <div>
                                            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                            <input type="text" name="name" id="name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                        </div>
                                        <div>
                                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                            <input type="email" name="email" id="email" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                        </div>
                                        <div>
                                            <label for="subject" class="block text-sm font-medium text-gray-700">Subject</label>
                                            <input type="text" name="subject" id="subject" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                        </div>
                                        <div>
                                            <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
                                            <textarea name="message" id="message" rows="4" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"></textarea>
                                        </div>
                                        <div class="flex items-center justify-end">
                                            <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                <i data-lucide="send" class="w-5 h-5 mr-2"></i>
                                                Send Message
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <footer class="bg-gray-800">
            <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
                <div class="md:flex md:items-center md:justify-between">
                    <div class="flex justify-center space-x-6 md:order-2">
                        <a href="#" class="text-gray-400 hover:text-gray-300">
                            <span class="sr-only">Facebook</span>
                            <i data-lucide="facebook" class="w-6 h-6"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-gray-300">
                            <span class="sr-only">Twitter</span>
                            <i data-lucide="twitter" class="w-6 h-6"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-gray-300">
                            <span class="sr-only">LinkedIn</span>
                            <i data-lucide="linkedin" class="w-6 h-6"></i>
                        </a>
                    </div>
                    <div class="mt-8 md:mt-0 md:order-1">
                        <p class="text-center text-base text-gray-400">&copy; 2024 CoLink. All rights reserved.</p>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
