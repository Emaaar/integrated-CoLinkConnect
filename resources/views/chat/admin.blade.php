<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CoLink - Admin Chat Support</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment-timezone@0.5.43/builds/moment-timezone-with-data.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.43/moment-timezone-with-data.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }
        .chat-container {
            height: calc(100vh - 240px);
            overflow-y: auto;
            scroll-behavior: smooth;
        }
        .message-bubble {
            max-width: 70%;
            word-wrap: break-word;
        }
        .sidebar-link.active {
            @apply bg-blue-50 text-blue-600;
        }
        .sidebar-link.active i {
            @apply text-blue-600;
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
    @if(session()->has('admin_email'))
        <div class="flex h-screen" x-data="{ sidebarOpen: true, unreadMessages: {}, currentTime: '', searchQuery: '', filteredUsers: [] }" x-init="
            {{-- setInterval(() => {
                currentTime = moment().tz('Asia/Manila').format('MMMM D, YYYY HH:mm:ss');
            }, 1000); --}}
            filteredUsers = {{ json_encode($users) }};
        ">
            <!-- Sidebar -->
            <aside class="bg-white shadow-md transition-all duration-300 ease-in-out flex flex-col"
                    :class="{ 'w-64': sidebarOpen, 'w-20': !sidebarOpen }">
                <div class="p-6 flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-blue-700" x-show="sidebarOpen">CoLink</h1>
                    <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 hover:text-gray-600">
                        <i data-lucide="menu" class="h-6 w-6"></i>
                    </button>
                </div>
                <nav class="flex-grow mt-6 px-4 overflow-y-auto">
                    @php
                    $sidebarLinks = [
                        ['icon' => 'home', 'label' => 'Dashboard', 'route' => 'admin-dash'],
                        ['icon' => 'file-text', 'label' => 'Contracting', 'route' => 'contracting'],
                        ['icon' => 'file-text', 'label' => 'Records', 'route' => 'records'],
                        ['icon' => 'mail', 'label' => 'Messages', 'route' => 'admin.chat'],
                        ['icon' => 'book-open', 'label' => 'Blog', 'route' => 'blog'],
                    ];
                    @endphp

                    {{-- @foreach($sidebarLinks as $link)
                        <a href="{{ route($link['route']) }}"
                           class="sidebar-link flex items-center space-x-2 px-4 py-3 rounded-lg mb-2 transition-colors duration-200 {{ request()->routeIs($link['route']) ? 'active' : 'text-gray-700 hover:bg-gray-100' }}">
                            <i data-lucide="{{ $link['icon'] }}" class="w-5 h-5"></i>
                            <span x-show="sidebarOpen">{{ $link['label'] }}</span>
                            @if($link['route'] === 'admin.chat')
                                <span x-show="Object.values(unreadMessages).reduce((a, b) => a + b, 0) > 0"
                                      class="ml-auto bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full"
                                      x-text="Object.values(unreadMessages).reduce((a, b) => a + b, 0)"></span>
                            @endif
                        </a>
                    @endforeach --}}
                    @foreach($sidebarLinks as $link)
                        @if($link['route'] === 'admin.chat')
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
                                @if($link['route'] === 'admin.chat')
                                    <span x-show="Object.values(unreadMessages).reduce((a, b) => a + b, 0) > 0"
                                        class="ml-auto bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full"
                                        x-text="Object.values(unreadMessages).reduce((a, b) => a + b, 0)"></span>
                                @endif
                            </a>
                        @endif
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
            <div class="flex-1 flex flex-col overflow-hidden">
                <!-- Top Bar -->
                <header class="bg-white shadow-sm border-b">
                    <div class="flex items-center justify-between px-6 py-4">
                        <div class="flex items-center space-x-4">
                            <div class="relative">
                                <i data-lucide="search" class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-gray-400"></i>
                                <input
                                    type="text"
                                    placeholder="Search a user or client"
                                    x-model="searchQuery"
                                    @input="
                                        filteredUsers = {{ json_encode($users) }}.filter(user =>
                                            user.firstname.toLowerCase().includes(searchQuery.toLowerCase()) ||
                                            user.lastname.toLowerCase().includes(searchQuery.toLowerCase()) ||
                                            user.user_email.toLowerCase().includes(searchQuery.toLowerCase())
                                        )
                                    "
                                    class="pl-10 pr-4 py-2 w-[300px] rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                >
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="text-sm font-medium text-gray-700" x-text="currentTime"></div>
                            <button class="relative p-2 text-gray-500 hover:text-gray-600 hover:bg-gray-100 rounded-full transition-colors duration-200">
                                <i data-lucide="bell" class="h-6 w-6"></i>
                                <span class="absolute top-0 right-0 h-2 w-2 bg-red-500 rounded-full"></span>
                            </button>
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                                    <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white font-semibold">
                                        A
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">Admin</span>
                                    <i data-lucide="chevron-down" class="w-4 h-4 text-gray-500"></i>
                                </button>
                                <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border py-2">
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>

                <!-- Chat Content Area -->
                <main class="flex-1 overflow-hidden p-6">
                    <div class="h-full flex flex-col">
                        <h2 class="text-2xl font-semibold mb-4">Admin Chat Support</h2>
                        <div class="flex-1 bg-white rounded-lg shadow-sm border flex overflow-hidden">
                            <!-- User List -->
                            <div class="w-1/4 border-r">
                                <div class="p-4 border-b">
                                    <h3 class="text-lg font-semibold">Users</h3>
                                </div>
                                <ul class="overflow-y-auto h-[calc(100%-60px)]">
                                    <template x-for="user in filteredUsers" :key="user.client_id">
                                        <li>
                                            <button class="user-item w-full text-left px-4 py-3 hover:bg-gray-50 focus:bg-blue-50 focus:outline-none transition-colors relative"
                                                    :data-email="user.user_email"
                                                    @click="currentUser = user.user_email; unreadMessages[user.user_email] = 0; fetchChatHistory(user.user_email);">
                                                <div class="flex items-center space-x-3">
                                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-semibold"
                                                         x-text="user.firstname.charAt(0).toUpperCase()"></div>
                                                    <div>
                                                        <div class="font-medium" x-text="`${user.firstname} ${user.lastname}`"></div>
                                                        <div class="text-sm text-gray-500" x-text="user.user_email"></div>
                                                    </div>
                                                </div>
                                                <span x-show="unreadMessages[user.user_email] > 0"
                                                      class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full"
                                                      x-text="unreadMessages[user.user_email]"></span>
                                            </button>
                                        </li>
                                    </template>
                                </ul>
                            </div>
                            <!-- Chat Window -->
                            <div class="w-3/4 flex flex-col">
                                <div id="chat-messages" class="chat-container flex-1 p-4 space-y-4">
                                    <!-- Messages will be dynamically added here -->
                                </div>
                                <div class="p-4 border-t bg-white">
                                    <form id="chat-form" class="flex space-x-2">
                                        <input type="text" id="message-input" class="flex-1 rounded-lg border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Type your message...">
                                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                            Send
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    @else
        <script>window.location.href = "{{ route('cclogin') }}";</script>
    @endif
{{-- MARK: CHECK HERE --}}
<script>
    lucide.createIcons();

    let currentUser = null;
    const messageContainer = document.getElementById('chat-messages');
    let unreadMessages = {};

    const pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
        cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
        encrypted: true
    });

    const channel = pusher.subscribe('chat');

    function clearMessages() {
        messageContainer.innerHTML = '';
    }
        // MARK: Admin Email here
    function appendMessage(message) {
        const messageDiv = document.createElement('div');

        const isAdmin = message.sender_email === 'arlonielockon@gmail.com';

        messageDiv.className = `flex ${isAdmin ? 'justify-end' : 'justify-start'}`;
        messageDiv.setAttribute('data-id', message.chat_id);

        messageDiv.innerHTML = `
            <div class="message-bubble ${isAdmin ? 'bg-blue-500 text-white' : 'bg-gray-100'} rounded-lg px-4 py-2 shadow-sm">
                <div class="text-sm font-medium mb-1">${isAdmin ? 'You' : message.sender_email}</div>
                <div>${message.message}</div>
            </div>
        `;

        messageContainer.appendChild(messageDiv);
        messageContainer.scrollTop = messageContainer.scrollHeight;
    }

    channel.bind('message.sent', function(data) {
        if (data.message.sender_email === currentUser || data.message.receiver_email === currentUser) {
            appendMessage(data.message);
        }
        if (data.message.sender_email !== 'arlonielockon@gmail.com') {
            unreadMessages[data.message.sender_email] = (unreadMessages[data.message.sender_email] || 0) + 1;
            updateUnreadMessageCount();
            updateUserListNotification(data.message.sender_email);
            if (!document.hasFocus()) {
                showBrowserNotification(data.message.sender_email, data.message.message);
            }
        }
    });

    function fetchChatHistory(userEmail) {
        clearMessages();
        currentUser = userEmail;
        fetch(`/admin/chat/history/${userEmail}`)
            .then(response => response.json())
            .then(messages => {
                messages.forEach(message => appendMessage(message));
                unreadMessages[userEmail] = 0;
                updateUnreadMessageCount();
                updateUserListNotification(userEmail);
            });
    }

    document.getElementById('chat-form').addEventListener('submit', function(e) {
        e.preventDefault();
        if (!currentUser) return;

        const messageInput = document.getElementById('message-input');
        const message = messageInput.value.trim();

        if (!message) return;

        messageInput.value = '';

        appendMessage({
            chat_id: Date.now(),
            sender_email: 'arlonielockon@gmail.com',
            message: message
        });

        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch('{{ route('admin.chat.send') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                message: message,
                receiver_email: currentUser
            })
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

    function updateUnreadMessageCount() {
        const totalUnread = Object.values(unreadMessages).reduce((a, b) => a + b, 0);
        const notificationDot = document.querySelector('.sidebar-link[href="{{ route('admin.chat') }}"] .notification-dot');
        if (totalUnread > 0) {
            notificationDot.classList.add('active');
            notificationDot.setAttribute('data-count', totalUnread);
        } else {
            notificationDot.classList.remove('active');
            notificationDot.removeAttribute('data-count');
        }
    }

    function showBrowserNotification(sender, message) {
        if ("Notification" in window && Notification.permission === "granted") {
            new Notification(`New message from ${sender}`, { body: message });
        } else if ("Notification" in window && Notification.permission !== "denied") {
            Notification.requestPermission().then(function (permission) {
                if (permission === "granted") {
                    new Notification(`New message from ${sender}`, { body: message });
                }
            });
        }
    }

    pusher.connection.bind('error', function(err) {
        console.error('Pusher connection error:', err);
    });

    pusher.connection.bind('disconnected', function() {
        setTimeout(() => pusher.connect(), 1000);
    });

    pusher.connection.bind('failed', function() {
        setTimeout(() => pusher.connect(), 1000);
    });

    channel.bind('pusher:subscription_error', function(status) {
        console.error('Pusher subscription error:', status);
    });

    document.addEventListener('alpine:init', () => {
        Alpine.store('unreadMessages', {});
    });
</script>



</body>
</html>
