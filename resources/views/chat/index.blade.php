<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CoLink - Chat Support</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.43/moment-timezone-with-data.min.js"></script>
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
        .chat-container {
            height: calc(100vh - 280px);
            overflow-y: auto;
            scroll-behavior: smooth;
        }
        .message-bubble {
            max-width: 80%;
            word-wrap: break-word;
        }
        .notification-dot {
            position: relative;
        }
        .notification-dot::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 8px;
            height: 8px;
            background-color: #EF4444;
            border-radius: 50%;
            display: none;
        }
        .notification-dot.active::after {
            display: block;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="flex h-screen" x-data="{ sidebarOpen: true }">
        <!-- Sidebar -->
        <aside class="bg-white shadow-md transition-all duration-300 ease-in-out flex flex-col"
                :class="{ 'w-64': sidebarOpen, 'w-20': !sidebarOpen }">
            <div class="p-6 flex items-center justify-between">
                <h1 class="text-2xl font-bold text-blue-600" x-show="sidebarOpen"><a href="{{ route('home') }}">CoLink</a></h1>
                <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 hover:text-gray-600">
                    <i data-lucide="menu" class="h-6 w-6"></i>
                </button>
            </div>
            <nav class="flex-grow mt-6 px-4 overflow-y-auto">
                @php
                $sidebarLinks = [
                    // ['icon' => 'home', 'label' => 'Dashboard', 'route' => 'home'],
                    ['icon' => 'home', 'label' => 'Profile', 'route' => 'profile'],
                    ['icon' => 'heart', 'label' => 'Donate', 'route' => 'donation'],
                    ['icon' => 'message-circle', 'label' => 'Chat Support', 'route' => 'chat.index'],
                    ['icon' => 'mail', 'label' => 'Contact us', 'route' => 'contact'],
                ];
                @endphp

                {{-- @foreach($sidebarLinks as $link)
                    <a href="{{ route($link['route']) }}"
                       class="sidebar-link flex items-center space-x-2 px-4 py-3 rounded-lg mb-2 transition-colors duration-200 {{ request()->routeIs($link['route']) ? 'active' : 'text-gray-700 hover:bg-gray-100' }}">
                        <i data-lucide="{{ $link['icon'] }}" class="w-5 h-5"></i>
                        <span x-show="sidebarOpen">{{ $link['label'] }}</span>
                    </a>
                @endforeach --}}
                @foreach($sidebarLinks as $link)
                        @if($link['label'] === 'Chat Support')
                        <a href="{{ route($link['route']) }}"
                        class="sidebar-link flex items-center space-x-2 px-4 py-3 rounded-lg mb-2 transition-colors duration-200 {{ request()->routeIs($link['route']) ? 'active' : 'text-gray-700 hover:bg-gray-100' }}">
                            <i data-lucide="{{ $link['icon'] }}" class="w-5 h-5 notification-dot"></i>
                            <span x-show="sidebarOpen">{{ $link['label'] }}</span>
                        </a>
                    @else
                        <!-- ... (existing sidebar link code) ... -->
                        <a href="{{ route($link['route']) }}"
                            class="sidebar-link flex items-center space-x-2 px-4 py-3 rounded-lg mb-2 transition-colors duration-200 {{ request()->routeIs($link['route']) ? 'active' : 'text-gray-700 hover:bg-gray-100' }}">
                            <i data-lucide="{{ $link['icon'] }}" class="w-5 h-5"></i>
                            <span x-show="sidebarOpen">{{ $link['label'] }}</span>
                        </a>
                    @endif
                @endforeach
            </nav>
            @auth
            <div class="p-4 mt-auto">
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

            <!-- Chat Content -->
            <main class="flex-1 overflow-hidden">
                <div class="h-full flex flex-col p-6">
                    <div class="bg-white rounded-lg shadow-sm border flex-1 flex flex-col">
                        <div class="p-4 border-b flex justify-between items-center">
                            <h2 class="text-lg font-semibold">Chat Support</h2>
                            <button id="delete-conversation" class="text-red-600 hover:text-red-700 text-sm font-medium">
                                Delete Conversation
                            </button>
                        </div>

                        <div id="chat-messages" class="chat-container p-4 space-y-4">
                            @foreach($messages as $message)
                                <div class="flex {{ $message->sender_email == Auth::user()->user_email ? 'justify-end' : 'justify-start' }}">
                                    <div class="message-bubble {{ $message->sender_email == Auth::user()->user_email ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-900' }} rounded-lg px-4 py-2 shadow-sm">
                                        <div class="text-sm font-medium mb-1">
                                            {{ $message->sender_email == Auth::user()->user_email ? 'You' : 'Support' }}
                                        </div>
                                        <div>{{ $message->message }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="p-4 border-t bg-white">
                            <form id="chat-form" class="flex space-x-2">
                                <input type="text"
                                       id="message-input"
                                       class="flex-1 rounded-lg border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       placeholder="Type your message...">
                                <button type="submit"
                                        class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    Send
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    {{-- MARK: CHECK HERE --}}
    <script>
        lucide.createIcons();

        const pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
            cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
            encrypted: true
        });

        const channel = pusher.subscribe('chat');
        const chatMessages = document.getElementById('chat-messages');
        let hasUnreadMessages = false;

        function appendMessage(message, isCurrentUser) {
            const messageDiv = document.createElement('div');
            messageDiv.className = `flex ${isCurrentUser ? 'justify-end' : 'justify-start'}`;
            messageDiv.innerHTML = `
                <div class="message-bubble ${isCurrentUser ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-900'} rounded-lg px-4 py-2 shadow-sm">
                    <div class="text-sm font-medium mb-1">${isCurrentUser ? 'You' : 'Support'}</div>
                    <div>${message}</div>
                </div>
            `;
            chatMessages.appendChild(messageDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        channel.bind('message.sent', function(data) {
            const isCurrentUser = data.message.sender_email === '{{ Auth::user()->user_email }}';
            appendMessage(data.message.message, isCurrentUser);

            if (!isCurrentUser && !document.hasFocus()) {
                hasUnreadMessages = true;
                updateNotificationDot();
                showBrowserNotification(data.message.message);
            }
        });

        document.getElementById('chat-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const messageInput = document.getElementById('message-input');
            const message = messageInput.value.trim();

            if (!message) return;

            appendMessage(message, true);

            messageInput.value = '';

            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch('{{ route('chat.send') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ message: message })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.status === 'success') {
                    showFeedback('Message sent successfully', 'success');
                } else {
                    showFeedback('Failed to send message', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showFeedback('Failed to send message', 'error');
            });
        });

        function showFeedback(message, type) {
            const feedbackDiv = document.createElement('div');
            feedbackDiv.className = `fixed bottom-4 right-4 px-4 py-2 rounded-lg ${type === 'success' ? 'bg-green-500' : 'bg-red-500'} text-white`;
            feedbackDiv.textContent = message;
            document.body.appendChild(feedbackDiv);
            setTimeout(() => feedbackDiv.remove(), 3000);
        }

        document.getElementById('delete-conversation').addEventListener('click', function() {
            if (!confirm('Are you sure you want to delete this conversation? This action cannot be undone.')) return;

            fetch('{{ route('chat.delete') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    chatMessages.innerHTML = '';
                } else {
                    alert('Failed to delete conversation. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while deleting the conversation.');
            });
        });

        function updateNotificationDot() {
            const notificationDot = document.querySelector('.notification-dot');
            if (hasUnreadMessages) {
                notificationDot.classList.add('active');
            } else {
                notificationDot.classList.remove('active');
            }
        }

        function showBrowserNotification(message) {
            if ("Notification" in window && Notification.permission === "granted") {
                new Notification("New Message", { body: message });
            } else if ("Notification" in window && Notification.permission !== "denied") {
                Notification.requestPermission().then(function (permission) {
                    if (permission === "granted") {
                        new Notification("New Message", { body: message });
                    }
                });
            }
        }

        window.addEventListener('focus', function() {
            hasUnreadMessages = false;
            updateNotificationDot();
        });

        pusher.connection.bind('error', function(err) {
            console.error('Pusher connection error:', err);
        });

        channel.bind('pusher:subscription_error', function(status) {
            console.error('Pusher subscription error:', status);
        });
    </script>



</body>
</html>
