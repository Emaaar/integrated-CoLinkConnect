<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CoLink - Contracting</title>
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

        .slider-container {
            width: 100%;
            max-width: 1000px; /* Increased from 800px to 1000px */
            margin: 0 auto;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            height: calc(100vh - 200px);
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .slider {
            flex: 1;
            display: flex;
            transition: transform 0.4s ease-in-out;
            overflow-y: visible;
        }

        .slide {
            min-width: 100%;
            padding: 2rem;
            box-sizing: border-box;
            max-height: calc(100vh - 280px);
            overflow-y: auto;
        }

        .slide h3 {
            font-size: 1.5rem;
            font-weight: 600;
            color: #2563eb;
            margin-bottom: 1.5rem;
            position: sticky;
            top: 0;
            background: white;
            padding: 1rem 0;
            z-index: 10;
        }

        input, textarea, select {
            width: 100%;
            padding: 0.75rem;
            margin-bottom: 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.375rem;
            font-size: 1rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        input:focus, textarea:focus, select:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .table-container {
            overflow-x: auto;
            margin: 0 -2rem;
            padding: 0 2rem;
        }

        table {
            font-size: 0.875rem;
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-bottom: 1.5rem;
        }

        th, td {
            padding: 0.75rem;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
            white-space: nowrap;
        }

        th {
            background-color: #f8fafc;
            font-weight: 600;
            color: #475569;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        td input {
            padding: 0.5rem;
            margin-bottom: 0;
        }

        .side-button {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: #2563eb;
            color: white;
            padding: 1rem 0.5rem;
            border: none;
            cursor: pointer;
            z-index: 20;
        }

        .side-button:hover {
            background-color: #1d4ed8;
        }

        .side-button:disabled {
            background-color: #94a3b8;
            cursor: not-allowed;
        }

        .side-button.left {
            left: 0;
            border-top-right-radius: 0.375rem;
            border-bottom-right-radius: 0.375rem;
        }

        .side-button.right {
            right: 0;
            border-top-left-radius: 0.375rem;
            border-bottom-left-radius: 0.375rem;
        }

        /* Responsive adjustments */
        @media (max-width: 1024px) {
            .slider-container {
                max-width: 95%;
                height: calc(100vh - 150px);
            }

            .slide {
                padding: 1.5rem;
            }

            input, textarea, select {
                font-size: 0.875rem;
            }
        }
    </style>
</head>
<body class="bg-gray-100">
    @if(session()->has('admin_email'))
        <div class="flex h-screen" x-data="{ sidebarOpen: true }">
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

                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100">
                    <!-- Error Messages - Moved to the top of the main content -->
                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <strong class="font-bold">Error!</strong>
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @elseif ($errors->has('conflict'))
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                            <p class="font-bold">Conflict Detected</p>
                            <p>{{ $errors->first('conflict') }}</p>
                        </div>
                    @endif

                    <!-- Slides -->
                    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                        <div class="slider-container">
                            <button onclick="prevSlide()" class="side-button left" id="leftButton">&lt;</button>
                            <button onclick="nextSlide()" class="side-button right" id="rightButton">&gt;</button>
                            <form action="{{ route('contracting.post') }}" method="POST" id="contractingForm">
                                @csrf
                                <div class="slider">
                                    <!--MARK: Slide 1 -->
                                    <div class="slide">
                                        <h3>I. Partner's Information</h3>
                                        <div class="space-y-4">
                                            <div>
                                                <label for="name_of_the_org" class="block text-sm font-medium text-gray-700 mb-1">Name of Organization</label>
                                                <input type="text" id="name_of_the_org" name="name_of_the_org" value="{{ old('name_of_the_org') }}" placeholder="Enter organization name" class="w-full border border-gray-300 rounded-md p-2">
                                                @error('name_of_the_org')
                                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div>
                                                <label for="nature_of_the_org" class="block text-sm font-medium text-gray-700 mb-1">Nature of the Organization</label>
                                                <input type="text" id="nature_of_the_org" name="nature_of_the_org" value="{{ old('nature_of_the_org') }}" placeholder="Describe organization nature" class="w-full border border-gray-300 rounded-md p-2">
                                                @error('nature_of_the_org')
                                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div>
                                                <h4 class="font-semibold mt-6 mb-3">Head of the Organization</h4>
                                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                    <div>
                                                        <label for="head_org_name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                                                        <input type="text" id="head_org_name" name="head_org_name" value="{{ old('head_org_name') }}" placeholder="Enter name" class="w-full border border-gray-300 rounded-md p-2">
                                                        @error('head_org_name')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                    <div>
                                                        <label for="head_org_designation" class="block text-sm font-medium text-gray-700 mb-1">Designation</label>
                                                        <input type="text" id="head_org_designation" name="head_org_designation" placeholder="Enter designation" value="{{ old('head_org_designation') }}" class="w-full border border-gray-300 rounded-md p-2">
                                                        @error('head_org_designation')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                    <div>
                                                        <label for="head_org_contact" class="block text-sm font-medium text-gray-700 mb-1">Contact</label>
                                                        <input type="text" id="head_org_contact" name="head_org_contact" value="{{ old('head_org_contact') }}" placeholder="Enter contact information" class="w-full border border-gray-300 rounded-md p-2">
                                                        @error('head_org_contact')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <h4 class="font-semibold mt-6 mb-3">Coordinator of the Organization</h4>
                                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                    <div>
                                                        <label for="coor_name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                                                        <input type="text" id="coor_name" name="coor_name"  value="{{ old('coor_name') }}" placeholder="Enter name" class="w-full border border-gray-300 rounded-md p-2">
                                                        @error('coor_name')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                    <div>
                                                        <label for="coor_designation" class="block text-sm font-medium text-gray-700 mb-1">Designation</label>
                                                        <input type="text" id="coor_designation" name="coor_designation"  value="{{ old('coor_designation') }}" placeholder="Enter designation" class="w-full border border-gray-300 rounded-md p-2">
                                                        @error('coor_designation')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                    <div>
                                                        <label for="coor_contact" class="block text-sm font-medium text-gray-700 mb-1">Contact</label>
                                                        <input type="text" id="coor_contact" name="coor_contact" value="{{ old('coor_contact') }}" placeholder="Enter contact information" class="w-full border border-gray-300 rounded-md p-2">
                                                        @error('coor_contact')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!--MARK: Slide 2 -->
                                    <div class="slide">
                                        <h3>II. Participants' Background</h3>
                                        <div class="space-y-4">
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div>
                                                    <label for="age" class="block text-sm font-medium text-gray-700 mb-1">Age</label>
                                                    <input type="number" id="age" name="age" value="{{ old('age') }}" placeholder="Enter age" min="0" class="w-full border border-gray-300 rounded-md p-2">
                                                    @error('age')
                                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div>
                                                    <label for="gender" class="block text-sm font-medium text-gray-700 mb-1">Gender</label>
                                                    <select id="gender" name="gender" class="w-full border border-gray-300 rounded-md p-2">
                                                        <option value="" disabled selected>Select gender</option>
                                                        <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                                        <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                                                    </select>
                                                    @error('gender')
                                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div>
                                                <label for="education_status" class="block text-sm font-medium text-gray-700 mb-1">Educational Status</label>
                                                <input type="text" id="education_status" name="education_status" value="{{ old('education_status') }}" placeholder="Enter educational status" class="w-full border border-gray-300 rounded-md p-2">
                                                @error('education_status')
                                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div>
                                                <label for="leadership_exp" class="block text-sm font-medium text-gray-700 mb-1">Leadership Experience</label>
                                                <input type="text" id="leadership_exp" name="leadership_exp" value="{{ old('leadership_exp') }}" placeholder="Describe leadership experience" class="w-full border border-gray-300 rounded-md p-2">
                                                @error('leadership_exp')
                                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div>
                                                <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                                                <textarea id="address" name="address" placeholder="Enter address" rows="4" class="w-full border border-gray-300 rounded-md p-2">{{ old('address') }}</textarea>
                                                @error('address')
                                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!--MARK: Slide 3 -->
                                    <div class="slide">
                                        <h3>III. Intervention Assessment</h3>
                                        <div class="space-y-4">
                                            <div>
                                                <label for="pic_success" class="block text-sm font-medium text-gray-700 mb-1">Picture of Success</label>
                                                <textarea id="pic_success" name="pic_success" placeholder="Describe the picture of success" rows="4" maxlength="1000" class="w-full border border-gray-300 rounded-md p-2">{{ old('pic_success') }}</textarea>
                                                @error('pic_success')
                                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div>
                                                <label for="knowledge_gap" class="block text-sm font-medium text-gray-700 mb-1">Knowledge Gap</label>
                                                <textarea id="knowledge_gap" name="knowledge_gap" placeholder="Describe knowledge gaps" rows="3" maxlength="1000" class="w-full border border-gray-300 rounded-md p-2">{{ old('knowledge_gap') }}</textarea>
                                                @error('knowledge_gap')
                                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div>
                                                <label for="skills_gap" class="block text-sm font-medium text-gray-700 mb-1">Skills Gap</label>
                                                <textarea id="skills_gap" name="skills_gap" placeholder="Describe skills gaps" rows="3" maxlength="1000" class="w-full border border-gray-300 rounded-md p-2">{{ old('skills_gap') }}</textarea>
                                                @error('skills_gap')
                                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div>
                                                <label for="team_dynamic_gap" class="block text-sm font-medium text-gray-700 mb-1">Team Dynamic Gap</label>
                                                <textarea id="team_dynamic_gap" name="team_dynamic_gap" placeholder="Describe team dynamic gaps" rows="3" maxlength="1000" class="w-full border border-gray-300 rounded-md p-2">{{ old('team_dynamic_gap') }}</textarea>
                                                @error('team_dynamic_gap')
                                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div>
                                                <label for="issues_and_concern" class="block text-sm font-medium text-gray-700 mb-1">Issues and Concerns</label>
                                                <textarea id="issues_and_concern" name="issues_and_concern" placeholder="List issues and concerns" rows="4" maxlength="1000" class="w-full border border-gray-300 rounded-md p-2">{{ old('issues_and_concern') }}</textarea>
                                                @error('issues_and_concern')
                                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>


                                    <!--MARK: Slide 4 -->
                                    <div class="slide">
                                        <h3>IV. Proposed Intervention</h3>
                                        <div class="space-y-4">
                                            <div>
                                                <label for="type_intervention" class="block text-sm font-medium text-gray-700 mb-1">Type of Intervention</label>
                                                <textarea id="type_intervention" name="type_intervention" placeholder="Describe the type of intervention (e.g., camp, training, workshop)" rows="3" class="w-full border border-gray-300 rounded-md p-2">{{ old('type_intervention') }}</textarea>
                                                @error('type_intervention')
                                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div>
                                                <label for="intervention_venue" class="block text-sm font-medium text-gray-700 mb-1">Venue</label>
                                                <input type="text" id="intervention_venue" name="intervention_venue" value="{{ old('intervention_venue') }}" placeholder="Enter intervention venue" class="w-full border border-gray-300 rounded-md p-2">
                                                @error('intervention_venue')
                                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div>
                                                    <label for="intervention_start_date" class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                                                    <input type="date" id="intervention_start_date" name="intervention_start_date" value="{{ old('intervention_start_date') }}"  class="w-full border border-gray-300 rounded-md p-2">
                                                    @error('intervention_start_date')
                                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div>
                                                    <label for="intervention_end_date" class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                                                    <input type="date" id="intervention_end_date" name="intervention_end_date" value="{{ old('intervention_end_date') }}" class="w-full border border-gray-300 rounded-md p-2">
                                                    @error('intervention_end_date')
                                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div>
                                                <label for="intervention_days" class="block text-sm font-medium text-gray-700 mb-1">Number of Days</label>
                                                <input type="number" id="intervention_days" name="intervention_days" value="{{ old('intervention_days') }}" readonly class="w-full border border-gray-300 rounded-md p-2 bg-gray-100">
                                            </div>
                                            <div>
                                                <label for="intervention_duration" class="block text-sm font-medium text-gray-700 mb-1">Duration (hours)</label>
                                                <input type="number" id="intervention_duration" name="intervention_duration" value="{{ old('intervention_duration') }}" placeholder="Enter duration in hours" min="1" class="w-full border border-gray-300 rounded-md p-2">
                                                @error('intervention_duration')
                                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div>
                                                <label for="intervention_objectives" class="block text-sm font-medium text-gray-700 mb-1">Intervention Objectives</label>
                                                <textarea id="intervention_objectives" name="intervention_objectives" placeholder="List intervention objectives" rows="3" class="w-full border border-gray-300 rounded-md p-2">{{ old('intervention_objectives') }}</textarea>
                                                @error('intervention_objectives')
                                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div>
                                                <label for="intervention_output" class="block text-sm font-medium text-gray-700 mb-1">Intervention Output</label>
                                                <textarea id="intervention_output" name="intervention_output" placeholder="Describe expected intervention output" rows="3" class="w-full border border-gray-300 rounded-md p-2">{{ old('intervention_output') }}</textarea>
                                                @error('intervention_output')
                                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>


                                    <!--MARK: Slide 5 (Accountabilities) -->
                                    <div class="slide">
                                        <h3>V. Accountabilities (part 1)</h3>
                                        <div class="table-container">
                                            <table>
                                                <thead>
                                                    <tr>
                                                        <th>Tasking</th>
                                                        <th>Costing</th>
                                                        <th>Partner</th>
                                                        <th>CoLink IC</th>
                                                        <th>Timeline</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <label for="needs_assessment" class="block text-sm font-medium text-gray-700">Needs Assessment</label>
                                                        </td>
                                                        <td>
                                                            @error('needs_assessment_cost')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <input type="text" id="needs_assessment_cost" name="needs_assessment_cost" placeholder="Cost" value="{{ old('needs_assessment_cost') }}" class="w-full p-2 border rounded">
                                                        </td>
                                                        <td>
                                                            @error('needs_assessment_partner')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <input type="text" name="needs_assessment_partner" placeholder="Partner" value="{{ old('needs_assessment_partner') }}" class="w-full p-2 border rounded">
                                                        </td>
                                                        <td>
                                                            @error('needs_assessment_colink')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <select name="needs_assessment_colink" class="w-full p-2 border rounded">
                                                                <option value="" disabled selected>Select CoLink IC</option>
                                                                <option value="Aimie Rumaguera" {{ old('needs_assessment_colink') == 'Aimie Rumaguera' ? 'selected' : '' }}>Aimie Rumaguera</option>
                                                                <option value="Andrey Gel Bajenting" {{ old('needs_assessment_colink') == 'Andrey Gel Bajenting' ? 'selected' : '' }}>Andrey Gel Bajenting</option>
                                                                <option value="Berminie Albacite" {{ old('needs_assessment_colink') == 'Berminie Albacite' ? 'selected' : '' }}>Berminie Albacite</option>
                                                                <option value="Fritzie Rama" {{ old('needs_assessment_colink') == 'Fritzie Rama' ? 'selected' : '' }}>Fritzie Rama</option>
                                                                <option value="Jerson Cabunilas" {{ old('needs_assessment_colink') == 'Jerson Cabunilas' ? 'selected' : '' }}>Jerson Cabunilas</option>
                                                                <option value="Jhiezel Jane Camarillo" {{ old('needs_assessment_colink') == 'Jhiezel Jane Camarillo' ? 'selected' : '' }}>Jhiezel Jane Camarillo</option>
                                                                <option value="John Adrian Anonat" {{ old('needs_assessment_colink') == 'John Adrian Anonat' ? 'selected' : '' }}>John Adrian Anonat</option>
                                                                <option value="Kathlyn Baclayon" {{ old('needs_assessment_colink') == 'Kathlyn Baclayon' ? 'selected' : '' }}>Kathlyn Baclayon</option>
                                                                <option value="Kent John Gella" {{ old('needs_assessment_colink') == 'Kent John Gella' ? 'selected' : '' }}>Kent John Gella</option>
                                                                <option value="Khevin Mamolo" {{ old('needs_assessment_colink') == 'Khevin Mamolo' ? 'selected' : '' }}>Khevin Mamolo</option>
                                                                <option value="Leendon Gelborion" {{ old('needs_assessment_colink') == 'Leendon Gelborion' ? 'selected' : '' }}>Leendon Gelborion</option>
                                                                <option value="Marianne Anselm Dela Cruz" {{ old('needs_assessment_colink') == 'Marianne Anselm Dela Cruz' ? 'selected' : '' }}>Marianne Anselm Dela Cruz</option>
                                                                <option value="Mariella Mamalias" {{ old('needs_assessment_colink') == 'Mariella Mamalias' ? 'selected' : '' }}>Mariella Mamalias</option>
                                                                <option value="Mary Jedde Ampolitod-Busa" {{ old('needs_assessment_colink') == 'Mary Jedde Ampolitod-Busa' ? 'selected' : '' }}>Mary Jedde Ampolitod-Busa</option>
                                                                <option value="Mayell Mamalias" {{ old('needs_assessment_colink') == 'Mayell Mamalias' ? 'selected' : '' }}>Mayell Mamalias</option>
                                                                <option value="Michelle Alcain" {{ old('needs_assessment_colink') == 'Michelle Alcain' ? 'selected' : '' }}>Michelle Alcain</option>
                                                                <option value="Nheil Stephen Dela Cruz" {{ old('needs_assessment_colink') == 'Nheil Stephen Dela Cruz' ? 'selected' : '' }}>Nheil Stephen Dela Cruz</option>
                                                                <option value="Paul Benedict Sariana" {{ old('needs_assessment_colink') == 'Paul Benedict Sariana' ? 'selected' : '' }}>Paul Benedict Sariana</option>
                                                                <option value="Peter Cris Rufo" {{ old('needs_assessment_colink') == 'Peter Cris Rufo' ? 'selected' : '' }}>Peter Cris Rufo</option>
                                                                <option value="Raden Remolino" {{ old('needs_assessment_colink') == 'Raden Remolino' ? 'selected' : '' }}>Raden Remolino</option>
                                                                <option value="Rica Jane Camello" {{ old('needs_assessment_colink') == 'Rica Jane Camello' ? 'selected' : '' }}>Rica Jane Camello</option>
                                                                <option value="Richard De Los Reyes" {{ old('needs_assessment_colink') == 'Richard De Los Reyes' ? 'selected' : '' }}>Richard De Los Reyes</option>
                                                                <option value="Shaine Birondo" {{ old('needs_assessment_colink') == 'Shaine Birondo' ? 'selected' : '' }}>Shaine Birondo</option>
                                                                <option value="Zaire Nathaniel Almirante" {{ old('needs_assessment_colink') == 'Zaire Nathaniel Almirante' ? 'selected' : '' }}>Zaire Nathaniel Almirante</option>
                                                            </select>
                                                        </td>

                                                        <td>
                                                            @error('needs_assessment_timeline')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <input type="date" value="{{ old('needs_assessment_timeline') }}" name="needs_assessment_timeline" class="w-full p-2 border rounded">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="training_design" class="block text-sm font-medium text-gray-700">Training Design and Implementation</label>
                                                        </td>
                                                        <td>
                                                            @error('training_design_cost')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <input type="text" id="training_design_cost" name="training_design_cost" value="{{ old('training_design_cost') }}" placeholder="Cost" class="w-full p-2 border rounded">
                                                        </td>
                                                        <td>
                                                            @error('training_design_partner')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <input type="text" name="training_design_partner"value="{{ old('training_design_partner') }}" placeholder="Partner" class="w-full p-2 border rounded">
                                                        </td>
                                                        <td>
                                                            @error('training_design_colink')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <select name="training_design_colink" class="w-full p-2 border rounded">
                                                                <option value="" disabled selected>Select CoLink IC</option>
                                                                <option value="Aimie Rumaguera" {{ old('training_design_colink') == 'Aimie Rumaguera' ? 'selected' : '' }}>Aimie Rumaguera</option>
                                                                <option value="Andrey Gel Bajenting" {{ old('training_design_colink') == 'Andrey Gel Bajenting' ? 'selected' : '' }}>Andrey Gel Bajenting</option>
                                                                <option value="Berminie Albacite" {{ old('training_design_colink') == 'Berminie Albacite' ? 'selected' : '' }}>Berminie Albacite</option>
                                                                <option value="Fritzie Rama" {{ old('training_design_colink') == 'Fritzie Rama' ? 'selected' : '' }}>Fritzie Rama</option>
                                                                <option value="Jerson Cabunilas" {{ old('training_design_colink') == 'Jerson Cabunilas' ? 'selected' : '' }}>Jerson Cabunilas</option>
                                                                <option value="Jhiezel Jane Camarillo" {{ old('training_design_colink') == 'Jhiezel Jane Camarillo' ? 'selected' : '' }}>Jhiezel Jane Camarillo</option>
                                                                <option value="John Adrian Anonat" {{ old('training_design_colink') == 'John Adrian Anonat' ? 'selected' : '' }}>John Adrian Anonat</option>
                                                                <option value="Kathlyn Baclayon" {{ old('training_design_colink') == 'Kathlyn Baclayon' ? 'selected' : '' }}>Kathlyn Baclayon</option>
                                                                <option value="Kent John Gella" {{ old('training_design_colink') == 'Kent John Gella' ? 'selected' : '' }}>Kent John Gella</option>
                                                                <option value="Khevin Mamolo" {{ old('training_design_colink') == 'Khevin Mamolo' ? 'selected' : '' }}>Khevin Mamolo</option>
                                                                <option value="Leendon Gelborion" {{ old('training_design_colink') == 'Leendon Gelborion' ? 'selected' : '' }}>Leendon Gelborion</option>
                                                                <option value="Marianne Anselm Dela Cruz" {{ old('training_design_colink') == 'Marianne Anselm Dela Cruz' ? 'selected' : '' }}>Marianne Anselm Dela Cruz</option>
                                                                <option value="Mariella Mamalias" {{ old('training_design_colink') == 'Mariella Mamalias' ? 'selected' : '' }}>Mariella Mamalias</option>
                                                                <option value="Mary Jedde Ampolitod-Busa" {{ old('training_design_colink') == 'Mary Jedde Ampolitod-Busa' ? 'selected' : '' }}>Mary Jedde Ampolitod-Busa</option>
                                                                <option value="Mayell Mamalias" {{ old('training_design_colink') == 'Mayell Mamalias' ? 'selected' : '' }}>Mayell Mamalias</option>
                                                                <option value="Michelle Alcain" {{ old('training_design_colink') == 'Michelle Alcain' ? 'selected' : '' }}>Michelle Alcain</option>
                                                                <option value="Nheil Stephen Dela Cruz" {{ old('training_design_colink') == 'Nheil Stephen Dela Cruz' ? 'selected' : '' }}>Nheil Stephen Dela Cruz</option>
                                                                <option value="Paul Benedict Sariana" {{ old('training_design_colink') == 'Paul Benedict Sariana' ? 'selected' : '' }}>Paul Benedict Sariana</option>
                                                                <option value="Peter Cris Rufo" {{ old('training_design_colink') == 'Peter Cris Rufo' ? 'selected' : '' }}>Peter Cris Rufo</option>
                                                                <option value="Raden Remolino" {{ old('training_design_colink') == 'Raden Remolino' ? 'selected' : '' }}>Raden Remolino</option>
                                                                <option value="Rica Jane Camello" {{ old('training_design_colink') == 'Rica Jane Camello' ? 'selected' : '' }}>Rica Jane Camello</option>
                                                                <option value="Richard De Los Reyes" {{ old('training_design_colink') == 'Richard De Los Reyes' ? 'selected' : '' }}>Richard De Los Reyes</option>
                                                                <option value="Shaine Birondo" {{ old('training_design_colink') == 'Shaine Birondo' ? 'selected' : '' }}>Shaine Birondo</option>
                                                                <option value="Zaire Nathaniel Almirante" {{ old('training_design_colink') == 'Zaire Nathaniel Almirante' ? 'selected' : '' }}>Zaire Nathaniel Almirante</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            @error('training_design_timeline')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <input type="date" value="{{ old('training_design_timeline') }}" name="training_design_timeline" class="w-full p-2 border rounded">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="facilitators_cost" class="block text-sm font-medium text-gray-700">Number of Facilitators</label>
                                                        </td>
                                                        <td>
                                                            @error('facilitators_cost')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <input type="text" id="facilitators_cost" name="facilitators_cost" value="{{ old('facilitators_cost') }}" placeholder="1,500 per fac/day" class="w-full p-2 border rounded">
                                                        </td>
                                                        <td>
                                                            @error('facilitators_partner')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <input type="text" name="facilitators_partner" value="{{ old('facilitators_partner') }}" placeholder="Partner" class="w-full p-2 border rounded">
                                                        </td>
                                                        <td>
                                                            @error('facilitators_colink')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <select name="facilitators_colink" class="w-full p-2 border rounded">
                                                                <option value="" disabled selected>Select CoLink IC</option>
                                                                <option value="Aimie Rumaguera" {{ old('facilitators_colink') == 'Aimie Rumaguera' ? 'selected' : '' }}>Aimie Rumaguera</option>
                                                                <option value="Andrey Gel Bajenting" {{ old('facilitators_colink') == 'Andrey Gel Bajenting' ? 'selected' : '' }}>Andrey Gel Bajenting</option>
                                                                <option value="Berminie Albacite" {{ old('facilitators_colink') == 'Berminie Albacite' ? 'selected' : '' }}>Berminie Albacite</option>
                                                                <option value="Fritzie Rama" {{ old('facilitators_colink') == 'Fritzie Rama' ? 'selected' : '' }}>Fritzie Rama</option>
                                                                <option value="Jerson Cabunilas" {{ old('facilitators_colink') == 'Jerson Cabunilas' ? 'selected' : '' }}>Jerson Cabunilas</option>
                                                                <option value="Jhiezel Jane Camarillo" {{ old('facilitators_colink') == 'Jhiezel Jane Camarillo' ? 'selected' : '' }}>Jhiezel Jane Camarillo</option>
                                                                <option value="John Adrian Anonat" {{ old('facilitators_colink') == 'John Adrian Anonat' ? 'selected' : '' }}>John Adrian Anonat</option>
                                                                <option value="Kathlyn Baclayon" {{ old('facilitators_colink') == 'Kathlyn Baclayon' ? 'selected' : '' }}>Kathlyn Baclayon</option>
                                                                <option value="Kent John Gella" {{ old('facilitators_colink') == 'Kent John Gella' ? 'selected' : '' }}>Kent John Gella</option>
                                                                <option value="Khevin Mamolo" {{ old('facilitators_colink') == 'Khevin Mamolo' ? 'selected' : '' }}>Khevin Mamolo</option>
                                                                <option value="Leendon Gelborion" {{ old('facilitators_colink') == 'Leendon Gelborion' ? 'selected' : '' }}>Leendon Gelborion</option>
                                                                <option value="Marianne Anselm Dela Cruz" {{ old('facilitators_colink') == 'Marianne Anselm Dela Cruz' ? 'selected' : '' }}>Marianne Anselm Dela Cruz</option>
                                                                <option value="Mariella Mamalias" {{ old('facilitators_colink') == 'Mariella Mamalias' ? 'selected' : '' }}>Mariella Mamalias</option>
                                                                <option value="Mary Jedde Ampolitod-Busa" {{ old('facilitators_colink') == 'Mary Jedde Ampolitod-Busa' ? 'selected' : '' }}>Mary Jedde Ampolitod-Busa</option>
                                                                <option value="Mayell Mamalias" {{ old('facilitators_colink') == 'Mayell Mamalias' ? 'selected' : '' }}>Mayell Mamalias</option>
                                                                <option value="Michelle Alcain" {{ old('facilitators_colink') == 'Michelle Alcain' ? 'selected' : '' }}>Michelle Alcain</option>
                                                                <option value="Nheil Stephen Dela Cruz" {{ old('facilitators_colink') == 'Nheil Stephen Dela Cruz' ? 'selected' : '' }}>Nheil Stephen Dela Cruz</option>
                                                                <option value="Paul Benedict Sariana" {{ old('facilitators_colink') == 'Paul Benedict Sariana' ? 'selected' : '' }}>Paul Benedict Sariana</option>
                                                                <option value="Peter Cris Rufo" {{ old('facilitators_colink') == 'Peter Cris Rufo' ? 'selected' : '' }}>Peter Cris Rufo</option>
                                                                <option value="Raden Remolino" {{ old('facilitators_colink') == 'Raden Remolino' ? 'selected' : '' }}>Raden Remolino</option>
                                                                <option value="Rica Jane Camello" {{ old('facilitators_colink') == 'Rica Jane Camello' ? 'selected' : '' }}>Rica Jane Camello</option>
                                                                <option value="Richard De Los Reyes" {{ old('facilitators_colink') == 'Richard De Los Reyes' ? 'selected' : '' }}>Richard De Los Reyes</option>
                                                                <option value="Shaine Birondo" {{ old('facilitators_colink') == 'Shaine Birondo' ? 'selected' : '' }}>Shaine Birondo</option>
                                                                <option value="Zaire Nathaniel Almirante" {{ old('facilitators_colink') == 'Zaire Nathaniel Almirante' ? 'selected' : '' }}>Zaire Nathaniel Almirante</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            @error('facilitators_timeline')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <input type="date" value="{{ old('facilitators_timeline') }}" name="facilitators_timeline" class="w-full p-2 border rounded">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="conduct_cost" class="block text-sm font-medium text-gray-700">Conduct of Orientation</label>
                                                        </td>
                                                        <td>
                                                            @error('conduct_cost')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <input type="text" id="conduct_cost" name="conduct_cost" placeholder="Costing" value="{{ old('conduct_cost') }}" class="w-full p-2 border rounded">
                                                        </td>
                                                        <td>
                                                            @error('conduct_partner')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <input type="text" name="conduct_partner" value="{{ old('conduct_partner') }}" placeholder="Partner" class="w-full p-2 border rounded">
                                                        </td>
                                                        <td>
                                                            @error('conduct_colink')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <select name="conduct_colink" class="w-full p-2 border rounded">
                                                                <option value="" disabled selected>Select CoLink IC</option>
                                                                <option value="Aimie Rumaguera" {{ old('conduct_colink') == 'Aimie Rumaguera' ? 'selected' : '' }}>Aimie Rumaguera</option>
                                                                <option value="Andrey Gel Bajenting" {{ old('conduct_colink') == 'Andrey Gel Bajenting' ? 'selected' : '' }}>Andrey Gel Bajenting</option>
                                                                <option value="Berminie Albacite" {{ old('conduct_colink') == 'Berminie Albacite' ? 'selected' : '' }}>Berminie Albacite</option>
                                                                <option value="Fritzie Rama" {{ old('conduct_colink') == 'Fritzie Rama' ? 'selected' : '' }}>Fritzie Rama</option>
                                                                <option value="Jerson Cabunilas" {{ old('conduct_colink') == 'Jerson Cabunilas' ? 'selected' : '' }}>Jerson Cabunilas</option>
                                                                <option value="Jhiezel Jane Camarillo" {{ old('conduct_colink') == 'Jhiezel Jane Camarillo' ? 'selected' : '' }}>Jhiezel Jane Camarillo</option>
                                                                <option value="John Adrian Anonat" {{ old('conduct_colink') == 'John Adrian Anonat' ? 'selected' : '' }}>John Adrian Anonat</option>
                                                                <option value="Kathlyn Baclayon" {{ old('conduct_colink') == 'Kathlyn Baclayon' ? 'selected' : '' }}>Kathlyn Baclayon</option>
                                                                <option value="Kent John Gella" {{ old('conduct_colink') == 'Kent John Gella' ? 'selected' : '' }}>Kent John Gella</option>
                                                                <option value="Khevin Mamolo" {{ old('conduct_colink') == 'Khevin Mamolo' ? 'selected' : '' }}>Khevin Mamolo</option>
                                                                <option value="Leendon Gelborion" {{ old('conduct_colink') == 'Leendon Gelborion' ? 'selected' : '' }}>Leendon Gelborion</option>
                                                                <option value="Marianne Anselm Dela Cruz" {{ old('conduct_colink') == 'Marianne Anselm Dela Cruz' ? 'selected' : '' }}>Marianne Anselm Dela Cruz</option>
                                                                <option value="Mariella Mamalias" {{ old('conduct_colink') == 'Mariella Mamalias' ? 'selected' : '' }}>Mariella Mamalias</option>
                                                                <option value="Mary Jedde Ampolitod-Busa" {{ old('conduct_colink') == 'Mary Jedde Ampolitod-Busa' ? 'selected' : '' }}>Mary Jedde Ampolitod-Busa</option>
                                                                <option value="Mayell Mamalias" {{ old('conduct_colink') == 'Mayell Mamalias' ? 'selected' : '' }}>Mayell Mamalias</option>
                                                                <option value="Michelle Alcain" {{ old('conduct_colink') == 'Michelle Alcain' ? 'selected' : '' }}>Michelle Alcain</option>
                                                                <option value="Nheil Stephen Dela Cruz" {{ old('conduct_colink') == 'Nheil Stephen Dela Cruz' ? 'selected' : '' }}>Nheil Stephen Dela Cruz</option>
                                                                <option value="Paul Benedict Sariana" {{ old('conduct_colink') == 'Paul Benedict Sariana' ? 'selected' : '' }}>Paul Benedict Sariana</option>
                                                                <option value="Peter Cris Rufo" {{ old('conduct_colink') == 'Peter Cris Rufo' ? 'selected' : '' }}>Peter Cris Rufo</option>
                                                                <option value="Raden Remolino" {{ old('conduct_colink') == 'Raden Remolino' ? 'selected' : '' }}>Raden Remolino</option>
                                                                <option value="Rica Jane Camello" {{ old('conduct_colink') == 'Rica Jane Camello' ? 'selected' : '' }}>Rica Jane Camello</option>
                                                                <option value="Richard De Los Reyes" {{ old('conduct_colink') == 'Richard De Los Reyes' ? 'selected' : '' }}>Richard De Los Reyes</option>
                                                                <option value="Shaine Birondo" {{ old('conduct_colink') == 'Shaine Birondo' ? 'selected' : '' }}>Shaine Birondo</option>
                                                                <option value="Zaire Nathaniel Almirante" {{ old('conduct_colink') == 'Zaire Nathaniel Almirante' ? 'selected' : '' }}>Zaire Nathaniel Almirante</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            @error('conduct_timeline')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <input type="date" value="{{ old('conduct_timeline') }}" name="conduct_timeline" class="w-full p-2 border rounded">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="coordination_of_materials_cost" class="block text-sm font-medium text-gray-700">Coordination of Materials</label>
                                                        </td>
                                                        <td>
                                                            @error('coordination_of_materials_cost')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <input type="text" id="coordination_of_materials_cost" name="coordination_of_materials_cost" value="{{ old('coordination_of_materials_cost') }}" placeholder="Costing" class="w-full p-2 border rounded">
                                                        </td>
                                                        <td>
                                                            @error('coordination_of_materials_partner')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <input type="text" name="coordination_of_materials_partner" value="{{ old('coordination_of_materials_partner') }}" placeholder="Partner" class="w-full p-2 border rounded">
                                                        </td>
                                                        <td>
                                                            @error('coordination_of_materials_colink')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <select name="coordination_of_materials_colink" class="w-full p-2 border rounded">
                                                                <option value="" disabled selected>Select CoLink IC</option>
                                                                <option value="Aimie Rumaguera" {{ old('coordination_of_materials_colink') == 'Aimie Rumaguera' ? 'selected' : '' }}>Aimie Rumaguera</option>
                                                                <option value="Andrey Gel Bajenting" {{ old('coordination_of_materials_colink') == 'Andrey Gel Bajenting' ? 'selected' : '' }}>Andrey Gel Bajenting</option>
                                                                <option value="Berminie Albacite" {{ old('coordination_of_materials_colink') == 'Berminie Albacite' ? 'selected' : '' }}>Berminie Albacite</option>
                                                                <option value="Fritzie Rama" {{ old('coordination_of_materials_colink') == 'Fritzie Rama' ? 'selected' : '' }}>Fritzie Rama</option>
                                                                <option value="Jerson Cabunilas" {{ old('coordination_of_materials_colink') == 'Jerson Cabunilas' ? 'selected' : '' }}>Jerson Cabunilas</option>
                                                                <option value="Jhiezel Jane Camarillo" {{ old('coordination_of_materials_colink') == 'Jhiezel Jane Camarillo' ? 'selected' : '' }}>Jhiezel Jane Camarillo</option>
                                                                <option value="John Adrian Anonat" {{ old('coordination_of_materials_colink') == 'John Adrian Anonat' ? 'selected' : '' }}>John Adrian Anonat</option>
                                                                <option value="Kathlyn Baclayon" {{ old('coordination_of_materials_colink') == 'Kathlyn Baclayon' ? 'selected' : '' }}>Kathlyn Baclayon</option>
                                                                <option value="Kent John Gella" {{ old('coordination_of_materials_colink') == 'Kent John Gella' ? 'selected' : '' }}>Kent John Gella</option>
                                                                <option value="Khevin Mamolo" {{ old('coordination_of_materials_colink') == 'Khevin Mamolo' ? 'selected' : '' }}>Khevin Mamolo</option>
                                                                <option value="Leendon Gelborion" {{ old('coordination_of_materials_colink') == 'Leendon Gelborion' ? 'selected' : '' }}>Leendon Gelborion</option>
                                                                <option value="Marianne Anselm Dela Cruz" {{ old('coordination_of_materials_colink') == 'Marianne Anselm Dela Cruz' ? 'selected' : '' }}>Marianne Anselm Dela Cruz</option>
                                                                <option value="Mariella Mamalias" {{ old('coordination_of_materials_colink') == 'Mariella Mamalias' ? 'selected' : '' }}>Mariella Mamalias</option>
                                                                <option value="Mary Jedde Ampolitod-Busa" {{ old('coordination_of_materials_colink') == 'Mary Jedde Ampolitod-Busa' ? 'selected' : '' }}>Mary Jedde Ampolitod-Busa</option>
                                                                <option value="Mayell Mamalias" {{ old('coordination_of_materials_colink') == 'Mayell Mamalias' ? 'selected' : '' }}>Mayell Mamalias</option>
                                                                <option value="Michelle Alcain" {{ old('coordination_of_materials_colink') == 'Michelle Alcain' ? 'selected' : '' }}>Michelle Alcain</option>
                                                                <option value="Nheil Stephen Dela Cruz" {{ old('coordination_of_materials_colink') == 'Nheil Stephen Dela Cruz' ? 'selected' : '' }}>Nheil Stephen Dela Cruz</option>
                                                                <option value="Paul Benedict Sariana" {{ old('coordination_of_materials_colink') == 'Paul Benedict Sariana' ? 'selected' : '' }}>Paul Benedict Sariana</option>
                                                                <option value="Peter Cris Rufo" {{ old('coordination_of_materials_colink') == 'Peter Cris Rufo' ? 'selected' : '' }}>Peter Cris Rufo</option>
                                                                <option value="Raden Remolino" {{ old('coordination_of_materials_colink') == 'Raden Remolino' ? 'selected' : '' }}>Raden Remolino</option>
                                                                <option value="Rica Jane Camello" {{ old('coordination_of_materials_colink') == 'Rica Jane Camello' ? 'selected' : '' }}>Rica Jane Camello</option>
                                                                <option value="Richard De Los Reyes" {{ old('coordination_of_materials_colink') == 'Richard De Los Reyes' ? 'selected' : '' }}>Richard De Los Reyes</option>
                                                                <option value="Shaine Birondo" {{ old('coordination_of_materials_colink') == 'Shaine Birondo' ? 'selected' : '' }}>Shaine Birondo</option>
                                                                <option value="Zaire Nathaniel Almirante" {{ old('coordination_of_materials_colink') == 'Zaire Nathaniel Almirante' ? 'selected' : '' }}>Zaire Nathaniel Almirante</option>
                                                                </select>
                                                        </td>
                                                        <td>
                                                            @error('coordination_of_materials_timeline')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <input type="date" value="{{ old('coordination_of_materials_timeline') }}" name="coordination_of_materials_timeline" class="w-full p-2 border rounded">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="slide">
                                        <h3>V. Accountabilities (part 2)</h3>
                                        <div class="table-container">
                                            <table>
                                                <thead>
                                                    <tr>
                                                        <th>Tasking</th>
                                                        <th>Costing</th>
                                                        <th>Partner</th>
                                                        <th>CoLink IC</th>
                                                        <th>Timeline</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <label for="secretariat" class="block text-sm font-medium text-gray-700">Secretariat (Attendance forms and Kits)</label>
                                                        </td>
                                                        <td>
                                                            @error('secretariat_cost')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <input type="text" name="secretariat_cost" value="{{ old('secretariat_cost') }}" placeholder="Costing" class="w-full p-2 border rounded">
                                                        </td>
                                                        <td>
                                                            @error('secretariat_partner')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <input type="text" name="secretariat_partner" value="{{ old('secretariat_partner') }}" placeholder="Partner" class="w-full p-2 border rounded">
                                                        </td>
                                                        <td>
                                                            @error('secretariat_colink')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <select name="secretariat_colink" class="w-full p-2 border rounded">
                                                                <option value="" disabled selected>Select CoLink IC</option>
                                                                <option value="Aimie Rumaguera" {{ old('secretariat_colink') == 'Aimie Rumaguera' ? 'selected' : '' }}>Aimie Rumaguera</option>
                                                                <option value="Andrey Gel Bajenting" {{ old('secretariat_colink') == 'Andrey Gel Bajenting' ? 'selected' : '' }}>Andrey Gel Bajenting</option>
                                                                <option value="Berminie Albacite" {{ old('secretariat_colink') == 'Berminie Albacite' ? 'selected' : '' }}>Berminie Albacite</option>
                                                                <option value="Fritzie Rama" {{ old('secretariat_colink') == 'Fritzie Rama' ? 'selected' : '' }}>Fritzie Rama</option>
                                                                <option value="Jerson Cabunilas" {{ old('secretariat_colink') == 'Jerson Cabunilas' ? 'selected' : '' }}>Jerson Cabunilas</option>
                                                                <option value="Jhiezel Jane Camarillo" {{ old('secretariat_colink') == 'Jhiezel Jane Camarillo' ? 'selected' : '' }}>Jhiezel Jane Camarillo</option>
                                                                <option value="John Adrian Anonat" {{ old('secretariat_colink') == 'John Adrian Anonat' ? 'selected' : '' }}>John Adrian Anonat</option>
                                                                <option value="Kathlyn Baclayon" {{ old('secretariat_colink') == 'Kathlyn Baclayon' ? 'selected' : '' }}>Kathlyn Baclayon</option>
                                                                <option value="Kent John Gella" {{ old('secretariat_colink') == 'Kent John Gella' ? 'selected' : '' }}>Kent John Gella</option>
                                                                <option value="Khevin Mamolo" {{ old('secretariat_colink') == 'Khevin Mamolo' ? 'selected' : '' }}>Khevin Mamolo</option>
                                                                <option value="Leendon Gelborion" {{ old('secretariat_colink') == 'Leendon Gelborion' ? 'selected' : '' }}>Leendon Gelborion</option>
                                                                <option value="Marianne Anselm Dela Cruz" {{ old('secretariat_colink') == 'Marianne Anselm Dela Cruz' ? 'selected' : '' }}>Marianne Anselm Dela Cruz</option>
                                                                <option value="Mariella Mamalias" {{ old('secretariat_colink') == 'Mariella Mamalias' ? 'selected' : '' }}>Mariella Mamalias</option>
                                                                <option value="Mary Jedde Ampolitod-Busa" {{ old('secretariat_colink') == 'Mary Jedde Ampolitod-Busa' ? 'selected' : '' }}>Mary Jedde Ampolitod-Busa</option>
                                                                <option value="Mayell Mamalias" {{ old('secretariat_colink') == 'Mayell Mamalias' ? 'selected' : '' }}>Mayell Mamalias</option>
                                                                <option value="Michelle Alcain" {{ old('secretariat_colink') == 'Michelle Alcain' ? 'selected' : '' }}>Michelle Alcain</option>
                                                                <option value="Nheil Stephen Dela Cruz" {{ old('secretariat_colink') == 'Nheil Stephen Dela Cruz' ? 'selected' : '' }}>Nheil Stephen Dela Cruz</option>
                                                                <option value="Paul Benedict Sariana" {{ old('secretariat_colink') == 'Paul Benedict Sariana' ? 'selected' : '' }}>Paul Benedict Sariana</option>
                                                                <option value="Peter Cris Rufo" {{ old('secretariat_colink') == 'Peter Cris Rufo' ? 'selected' : '' }}>Peter Cris Rufo</option>
                                                                <option value="Raden Remolino" {{ old('secretariat_colink') == 'Raden Remolino' ? 'selected' : '' }}>Raden Remolino</option>
                                                                <option value="Rica Jane Camello" {{ old('secretariat_colink') == 'Rica Jane Camello' ? 'selected' : '' }}>Rica Jane Camello</option>
                                                                <option value="Richard De Los Reyes" {{ old('secretariat_colink') == 'Richard De Los Reyes' ? 'selected' : '' }}>Richard De Los Reyes</option>
                                                                <option value="Shaine Birondo" {{ old('secretariat_colink') == 'Shaine Birondo' ? 'selected' : '' }}>Shaine Birondo</option>
                                                                <option value="Zaire Nathaniel Almirante" {{ old('secretariat_colink') == 'Zaire Nathaniel Almirante' ? 'selected' : '' }}>Zaire Nathaniel Almirante</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            @error('secretariat_timeline')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <input type="date" value="{{ old('secretariat_timeline') }}" name="secretariat_timeline" class="w-full p-2 border rounded">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="id" class="block text-sm font-medium text-gray-700">ID</label>
                                                        </td>
                                                        <td>
                                                            @error('id_cost')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <input type="text" name="id_cost" value="{{ old('id_cost') }}" placeholder="Costing" class="w-full p-2 border rounded">
                                                        </td>
                                                        <td>
                                                            @error('id_partner')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <input type="text" name="id_partner" value="{{ old('id_partner') }}" placeholder="Partner" class="w-full p-2 border rounded">
                                                        </td>
                                                        <td>
                                                            @error('id_colink')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <select name="id_colink" class="w-full p-2 border rounded">
                                                                <option value="" disabled selected>Select CoLink IC</option>
                                                                <option value="Aimie Rumaguera" {{ old('id_colink') == 'Aimie Rumaguera' ? 'selected' : '' }}>Aimie Rumaguera</option>
                                                                <option value="Andrey Gel Bajenting" {{ old('id_colink') == 'Andrey Gel Bajenting' ? 'selected' : '' }}>Andrey Gel Bajenting</option>
                                                                <option value="Berminie Albacite" {{ old('id_colink') == 'Berminie Albacite' ? 'selected' : '' }}>Berminie Albacite</option>
                                                                <option value="Fritzie Rama" {{ old('id_colink') == 'Fritzie Rama' ? 'selected' : '' }}>Fritzie Rama</option>
                                                                <option value="Jerson Cabunilas" {{ old('id_colink') == 'Jerson Cabunilas' ? 'selected' : '' }}>Jerson Cabunilas</option>
                                                                <option value="Jhiezel Jane Camarillo" {{ old('id_colink') == 'Jhiezel Jane Camarillo' ? 'selected' : '' }}>Jhiezel Jane Camarillo</option>
                                                                <option value="John Adrian Anonat" {{ old('id_colink') == 'John Adrian Anonat' ? 'selected' : '' }}>John Adrian Anonat</option>
                                                                <option value="Kathlyn Baclayon" {{ old('id_colink') == 'Kathlyn Baclayon' ? 'selected' : '' }}>Kathlyn Baclayon</option>
                                                                <option value="Kent John Gella" {{ old('id_colink') == 'Kent John Gella' ? 'selected' : '' }}>Kent John Gella</option>
                                                                <option value="Khevin Mamolo" {{ old('id_colink') == 'Khevin Mamolo' ? 'selected' : '' }}>Khevin Mamolo</option>
                                                                <option value="Leendon Gelborion" {{ old('id_colink') == 'Leendon Gelborion' ? 'selected' : '' }}>Leendon Gelborion</option>
                                                                <option value="Marianne Anselm Dela Cruz" {{ old('id_colink') == 'Marianne Anselm Dela Cruz' ? 'selected' : '' }}>Marianne Anselm Dela Cruz</option>
                                                                <option value="Mariella Mamalias" {{ old('id_colink') == 'Mariella Mamalias' ? 'selected' : '' }}>Mariella Mamalias</option>
                                                                <option value="Mary Jedde Ampolitod-Busa" {{ old('id_colink') == 'Mary Jedde Ampolitod-Busa' ? 'selected' : '' }}>Mary Jedde Ampolitod-Busa</option>
                                                                <option value="Mayell Mamalias" {{ old('id_colink') == 'Mayell Mamalias' ? 'selected' : '' }}>Mayell Mamalias</option>
                                                                <option value="Michelle Alcain" {{ old('id_colink') == 'Michelle Alcain' ? 'selected' : '' }}>Michelle Alcain</option>
                                                                <option value="Nheil Stephen Dela Cruz" {{ old('id_colink') == 'Nheil Stephen Dela Cruz' ? 'selected' : '' }}>Nheil Stephen Dela Cruz</option>
                                                                <option value="Paul Benedict Sariana" {{ old('id_colink') == 'Paul Benedict Sariana' ? 'selected' : '' }}>Paul Benedict Sariana</option>
                                                                <option value="Peter Cris Rufo" {{ old('id_colink') == 'Peter Cris Rufo' ? 'selected' : '' }}>Peter Cris Rufo</option>
                                                                <option value="Raden Remolino" {{ old('id_colink') == 'Raden Remolino' ? 'selected' : '' }}>Raden Remolino</option>
                                                                <option value="Rica Jane Camello" {{ old('id_colink') == 'Rica Jane Camello' ? 'selected' : '' }}>Rica Jane Camello</option>
                                                                <option value="Richard De Los Reyes" {{ old('id_colink') == 'Richard De Los Reyes' ? 'selected' : '' }}>Richard De Los Reyes</option>
                                                                <option value="Shaine Birondo" {{ old('id_colink') == 'Shaine Birondo' ? 'selected' : '' }}>Shaine Birondo</option>
                                                                <option value="Zaire Nathaniel Almirante" {{ old('id_colink') == 'Zaire Nathaniel Almirante' ? 'selected' : '' }}>Zaire Nathaniel Almirante</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            @error('id_timeline')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <input type="date" value="{{ old('id_timeline') }}" name="id_timeline" class="w-full p-2 border rounded">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="parent_consent" class="block text-sm font-medium text-gray-700">Parents' Consent</label>
                                                        </td>
                                                        <td>
                                                            @error('parent_consent_cost')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <input type="text" name="parent_consent_cost" value="{{ old('parent_consent_cost') }}" placeholder="Costing" class="w-full p-2 border rounded">
                                                        </td>
                                                        <td>
                                                            @error('parent_consent_partner')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <input type="text" name="parent_consent_partner" value="{{ old('parent_consent_partner') }}" placeholder="Partner" class="w-full p-2 border rounded">
                                                        </td>
                                                        <td>
                                                            @error('parent_consent_colink')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <select name="parent_consent_colink" class="w-full p-2 border rounded">
                                                                <option value="" disabled selected>Select CoLink IC</option>
                                                                <option value="Aimie Rumaguera" {{ old('parent_consent_colink') == 'Aimie Rumaguera' ? 'selected' : '' }}>Aimie Rumaguera</option>
                                                                <option value="Andrey Gel Bajenting" {{ old('parent_consent_colink') == 'Andrey Gel Bajenting' ? 'selected' : '' }}>Andrey Gel Bajenting</option>
                                                                <option value="Berminie Albacite" {{ old('parent_consent_colink') == 'Berminie Albacite' ? 'selected' : '' }}>Berminie Albacite</option>
                                                                <option value="Fritzie Rama" {{ old('parent_consent_colink') == 'Fritzie Rama' ? 'selected' : '' }}>Fritzie Rama</option>
                                                                <option value="Jerson Cabunilas" {{ old('parent_consent_colink') == 'Jerson Cabunilas' ? 'selected' : '' }}>Jerson Cabunilas</option>
                                                                <option value="Jhiezel Jane Camarillo" {{ old('parent_consent_colink') == 'Jhiezel Jane Camarillo' ? 'selected' : '' }}>Jhiezel Jane Camarillo</option>
                                                                <option value="John Adrian Anonat" {{ old('parent_consent_colink') == 'John Adrian Anonat' ? 'selected' : '' }}>John Adrian Anonat</option>
                                                                <option value="Kathlyn Baclayon" {{ old('parent_consent_colink') == 'Kathlyn Baclayon' ? 'selected' : '' }}>Kathlyn Baclayon</option>
                                                                <option value="Kent John Gella" {{ old('parent_consent_colink') == 'Kent John Gella' ? 'selected' : '' }}>Kent John Gella</option>
                                                                <option value="Khevin Mamolo" {{ old('parent_consent_colink') == 'Khevin Mamolo' ? 'selected' : '' }}>Khevin Mamolo</option>
                                                                <option value="Leendon Gelborion" {{ old('parent_consent_colink') == 'Leendon Gelborion' ? 'selected' : '' }}>Leendon Gelborion</option>
                                                                <option value="Marianne Anselm Dela Cruz" {{ old('parent_consent_colink') == 'Marianne Anselm Dela Cruz' ? 'selected' : '' }}>Marianne Anselm Dela Cruz</option>
                                                                <option value="Mariella Mamalias" {{ old('parent_consent_colink') == 'Mariella Mamalias' ? 'selected' : '' }}>Mariella Mamalias</option>
                                                                <option value="Mary Jedde Ampolitod-Busa" {{ old('parent_consent_colink') == 'Mary Jedde Ampolitod-Busa' ? 'selected' : '' }}>Mary Jedde Ampolitod-Busa</option>
                                                                <option value="Mayell Mamalias" {{ old('parent_consent_colink') == 'Mayell Mamalias' ? 'selected' : '' }}>Mayell Mamalias</option>
                                                                <option value="Michelle Alcain" {{ old('parent_consent_colink') == 'Michelle Alcain' ? 'selected' : '' }}>Michelle Alcain</option>
                                                                <option value="Nheil Stephen Dela Cruz" {{ old('parent_consent_colink') == 'Nheil Stephen Dela Cruz' ? 'selected' : '' }}>Nheil Stephen Dela Cruz</option>
                                                                <option value="Paul Benedict Sariana" {{ old('parent_consent_colink') == 'Paul Benedict Sariana' ? 'selected' : '' }}>Paul Benedict Sariana</option>
                                                                <option value="Peter Cris Rufo" {{ old('parent_consent_colink') == 'Peter Cris Rufo' ? 'selected' : '' }}>Peter Cris Rufo</option>
                                                                <option value="Raden Remolino" {{ old('parent_consent_colink') == 'Raden Remolino' ? 'selected' : '' }}>Raden Remolino</option>
                                                                <option value="Rica Jane Camello" {{ old('parent_consent_colink') == 'Rica Jane Camello' ? 'selected' : '' }}>Rica Jane Camello</option>
                                                                <option value="Richard De Los Reyes" {{ old('parent_consent_colink') == 'Richard De Los Reyes' ? 'selected' : '' }}>Richard De Los Reyes</option>
                                                                <option value="Shaine Birondo" {{ old('parent_consent_colink') == 'Shaine Birondo' ? 'selected' : '' }}>Shaine Birondo</option>
                                                                <option value="Zaire Nathaniel Almirante" {{ old('parent_consent_colink') == 'Zaire Nathaniel Almirante' ? 'selected' : '' }}>Zaire Nathaniel Almirante</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            @error('parent_consent_timeline')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <input type="date" value="{{ old('parent_consent_timeline') }}" name="parent_consent_timeline" class="w-full p-2 border rounded">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="designing_poster" class="block text-sm font-medium text-gray-700">Designing of Poster</label>
                                                        </td>
                                                        <td>
                                                            @error('designing_poster_cost')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <input type="text" name="designing_poster_cost" value="{{ old('designing_poster_cost') }}" placeholder="300 per design" class="w-full p-2 border rounded">
                                                        </td>
                                                        <td>
                                                            @error('designing_poster_partner')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <input type="text" name="designing_poster_partner" value="{{ old('designing_poster_partner') }}" placeholder="Partner" class="w-full p-2 border rounded">
                                                        </td>
                                                        <td>
                                                            @error('designing_poster_colink')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <select name="designing_poster_colink" class="w-full p-2 border rounded">
                                                                <option value="" disabled selected>Select CoLink IC</option>
                                                                <option value="Aimie Rumaguera" {{ old('designing_poster_colink') == 'Aimie Rumaguera' ? 'selected' : '' }}>Aimie Rumaguera</option>
                                                                <option value="Andrey Gel Bajenting" {{ old('designing_poster_colink') == 'Andrey Gel Bajenting' ? 'selected' : '' }}>Andrey Gel Bajenting</option>
                                                                <option value="Berminie Albacite" {{ old('designing_poster_colink') == 'Berminie Albacite' ? 'selected' : '' }}>Berminie Albacite</option>
                                                                <option value="Fritzie Rama" {{ old('designing_poster_colink') == 'Fritzie Rama' ? 'selected' : '' }}>Fritzie Rama</option>
                                                                <option value="Jerson Cabunilas" {{ old('designing_poster_colink') == 'Jerson Cabunilas' ? 'selected' : '' }}>Jerson Cabunilas</option>
                                                                <option value="Jhiezel Jane Camarillo" {{ old('designing_poster_colink') == 'Jhiezel Jane Camarillo' ? 'selected' : '' }}>Jhiezel Jane Camarillo</option>
                                                                <option value="John Adrian Anonat" {{ old('designing_poster_colink') == 'John Adrian Anonat' ? 'selected' : '' }}>John Adrian Anonat</option>
                                                                <option value="Kathlyn Baclayon" {{ old('designing_poster_colink') == 'Kathlyn Baclayon' ? 'selected' : '' }}>Kathlyn Baclayon</option>
                                                                <option value="Kent John Gella" {{ old('designing_poster_colink') == 'Kent John Gella' ? 'selected' : '' }}>Kent John Gella</option>
                                                                <option value="Khevin Mamolo" {{ old('designing_poster_colink') == 'Khevin Mamolo' ? 'selected' : '' }}>Khevin Mamolo</option>
                                                                <option value="Leendon Gelborion" {{ old('designing_poster_colink') == 'Leendon Gelborion' ? 'selected' : '' }}>Leendon Gelborion</option>
                                                                <option value="Marianne Anselm Dela Cruz" {{ old('designing_poster_colink') == 'Marianne Anselm Dela Cruz' ? 'selected' : '' }}>Marianne Anselm Dela Cruz</option>
                                                                <option value="Mariella Mamalias" {{ old('designing_poster_colink') == 'Mariella Mamalias' ? 'selected' : '' }}>Mariella Mamalias</option>
                                                                <option value="Mary Jedde Ampolitod-Busa" {{ old('designing_poster_colink') == 'Mary Jedde Ampolitod-Busa' ? 'selected' : '' }}>Mary Jedde Ampolitod-Busa</option>
                                                                <option value="Mayell Mamalias" {{ old('designing_poster_colink') == 'Mayell Mamalias' ? 'selected' : '' }}>Mayell Mamalias</option>
                                                                <option value="Michelle Alcain" {{ old('designing_poster_colink') == 'Michelle Alcain' ? 'selected' : '' }}>Michelle Alcain</option>
                                                                <option value="Nheil Stephen Dela Cruz" {{ old('designing_poster_colink') == 'Nheil Stephen Dela Cruz' ? 'selected' : '' }}>Nheil Stephen Dela Cruz</option>
                                                                <option value="Paul Benedict Sariana" {{ old('designing_poster_colink') == 'Paul Benedict Sariana' ? 'selected' : '' }}>Paul Benedict Sariana</option>
                                                                <option value="Peter Cris Rufo" {{ old('designing_poster_colink') == 'Peter Cris Rufo' ? 'selected' : '' }}>Peter Cris Rufo</option>
                                                                <option value="Raden Remolino" {{ old('designing_poster_colink') == 'Raden Remolino' ? 'selected' : '' }}>Raden Remolino</option>
                                                                <option value="Rica Jane Camello" {{ old('designing_poster_colink') == 'Rica Jane Camello' ? 'selected' : '' }}>Rica Jane Camello</option>
                                                                <option value="Richard De Los Reyes" {{ old('designing_poster_colink') == 'Richard De Los Reyes' ? 'selected' : '' }}>Richard De Los Reyes</option>
                                                                <option value="Shaine Birondo" {{ old('designing_poster_colink') == 'Shaine Birondo' ? 'selected' : '' }}>Shaine Birondo</option>
                                                                <option value="Zaire Nathaniel Almirante" {{ old('designing_poster_colink') == 'Zaire Nathaniel Almirante' ? 'selected' : '' }}>Zaire Nathaniel Almirante</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            @error('designing_poster_timeline')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <input type="date" value="{{ old('designing_poster_timeline') }}" name="designing_poster_timeline" class="w-full p-2 border rounded">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="tshirt_printing" class="block text-sm font-medium text-gray-700">T-Shirt Printing</label>
                                                        </td>
                                                        <td>
                                                            @error('tshirt_printing_cost')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <input type="text" name="tshirt_printing_cost" value="{{ old('tshirt_printing_cost') }}" placeholder="250 per design" class="w-full p-2 border rounded">
                                                        </td>
                                                        <td>
                                                            @error('tshirt_printing_partner')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <input type="text" name="tshirt_printing_partner" value="{{ old('tshirt_printing_partner') }}" placeholder="Partner" class="w-full p-2 border rounded">
                                                        </td>
                                                        <td>
                                                            @error('tshirt_printing_colink')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <select name="tshirt_printing_colink" class="w-full p-2 border rounded">
                                                                <option value="" disabled selected>Select CoLink IC</option>
                                                                <option value="Aimie Rumaguera" {{ old('tshirt_printing_colink') == 'Aimie Rumaguera' ? 'selected' : '' }}>Aimie Rumaguera</option>
                                                                <option value="Andrey Gel Bajenting" {{ old('tshirt_printing_colink') == 'Andrey Gel Bajenting' ? 'selected' : '' }}>Andrey Gel Bajenting</option>
                                                                <option value="Berminie Albacite" {{ old('tshirt_printing_colink') == 'Berminie Albacite' ? 'selected' : '' }}>Berminie Albacite</option>
                                                                <option value="Fritzie Rama" {{ old('tshirt_printing_colink') == 'Fritzie Rama' ? 'selected' : '' }}>Fritzie Rama</option>
                                                                <option value="Jerson Cabunilas" {{ old('tshirt_printing_colink') == 'Jerson Cabunilas' ? 'selected' : '' }}>Jerson Cabunilas</option>
                                                                <option value="Jhiezel Jane Camarillo" {{ old('tshirt_printing_colink') == 'Jhiezel Jane Camarillo' ? 'selected' : '' }}>Jhiezel Jane Camarillo</option>
                                                                <option value="John Adrian Anonat" {{ old('tshirt_printing_colink') == 'John Adrian Anonat' ? 'selected' : '' }}>John Adrian Anonat</option>
                                                                <option value="Kathlyn Baclayon" {{ old('tshirt_printing_colink') == 'Kathlyn Baclayon' ? 'selected' : '' }}>Kathlyn Baclayon</option>
                                                                <option value="Kent John Gella" {{ old('tshirt_printing_colink') == 'Kent John Gella' ? 'selected' : '' }}>Kent John Gella</option>
                                                                <option value="Khevin Mamolo" {{ old('tshirt_printing_colink') == 'Khevin Mamolo' ? 'selected' : '' }}>Khevin Mamolo</option>
                                                                <option value="Leendon Gelborion" {{ old('tshirt_printing_colink') == 'Leendon Gelborion' ? 'selected' : '' }}>Leendon Gelborion</option>
                                                                <option value="Marianne Anselm Dela Cruz" {{ old('tshirt_printing_colink') == 'Marianne Anselm Dela Cruz' ? 'selected' : '' }}>Marianne Anselm Dela Cruz</option>
                                                                <option value="Mariella Mamalias" {{ old('tshirt_printing_colink') == 'Mariella Mamalias' ? 'selected' : '' }}>Mariella Mamalias</option>
                                                                <option value="Mary Jedde Ampolitod-Busa" {{ old('tshirt_printing_colink') == 'Mary Jedde Ampolitod-Busa' ? 'selected' : '' }}>Mary Jedde Ampolitod-Busa</option>
                                                                <option value="Mayell Mamalias" {{ old('tshirt_printing_colink') == 'Mayell Mamalias' ? 'selected' : '' }}>Mayell Mamalias</option>
                                                                <option value="Michelle Alcain" {{ old('tshirt_printing_colink') == 'Michelle Alcain' ? 'selected' : '' }}>Michelle Alcain</option>
                                                                <option value="Nheil Stephen Dela Cruz" {{ old('tshirt_printing_colink') == 'Nheil Stephen Dela Cruz' ? 'selected' : '' }}>Nheil Stephen Dela Cruz</option>
                                                                <option value="Paul Benedict Sariana" {{ old('tshirt_printing_colink') == 'Paul Benedict Sariana' ? 'selected' : '' }}>Paul Benedict Sariana</option>
                                                                <option value="Peter Cris Rufo" {{ old('tshirt_printing_colink') == 'Peter Cris Rufo' ? 'selected' : '' }}>Peter Cris Rufo</option>
                                                                <option value="Raden Remolino" {{ old('tshirt_printing_colink') == 'Raden Remolino' ? 'selected' : '' }}>Raden Remolino</option>
                                                                <option value="Rica Jane Camello" {{ old('tshirt_printing_colink') == 'Rica Jane Camello' ? 'selected' : '' }}>Rica Jane Camello</option>
                                                                <option value="Richard De Los Reyes" {{ old('tshirt_printing_colink') == 'Richard De Los Reyes' ? 'selected' : '' }}>Richard De Los Reyes</option>
                                                                <option value="Shaine Birondo" {{ old('tshirt_printing_colink') == 'Shaine Birondo' ? 'selected' : '' }}>Shaine Birondo</option>
                                                                <option value="Zaire Nathaniel Almirante" {{ old('tshirt_printing_colink') == 'Zaire Nathaniel Almirante' ? 'selected' : '' }}>Zaire Nathaniel Almirante</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            @error('tshirt_printing_timeline')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <input type="date" value="{{ old('tshirt_printing_timeline') }}" name="tshirt_printing_timeline" class="w-full p-2 border rounded">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="slide">
                                        <h3>V. Accountabilities (part 3)</h3>
                                        <div class="table-container">
                                            <table>
                                                <thead>
                                                    <tr>
                                                        <th>Tasking</th>
                                                        <th>Costing</th>
                                                        <th>Partner</th>
                                                        <th>CoLink IC</th>
                                                        <th>Timeline</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <label for="banner_printing" class="block text-sm font-medium text-gray-700">Banner Printing</label>
                                                        </td>
                                                        <td>
                                                            @error('banner_printing_cost')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <input type="text" name="banner_printing_cost" value="{{ old('banner_printing_cost') }}" placeholder="Costing" class="w-full p-2 border rounded">
                                                        </td>
                                                        <td>
                                                            @error('banner_printing_partner')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <input type="text" name="banner_printing_partner" value="{{ old('banner_printing_partner') }}" placeholder="Partner" class="w-full p-2 border rounded">
                                                        </td>
                                                        <td>
                                                            @error('banner_printing_colink')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <select name="banner_printing_colink" class="w-full p-2 border rounded">
                                                                <option value="" disabled selected>Select CoLink IC</option>
                                                                <option value="Aimie Rumaguera" {{ old('banner_printing_colink') == 'Aimie Rumaguera' ? 'selected' : '' }}>Aimie Rumaguera</option>
                                                                <option value="Andrey Gel Bajenting" {{ old('banner_printing_colink') == 'Andrey Gel Bajenting' ? 'selected' : '' }}>Andrey Gel Bajenting</option>
                                                                <option value="Berminie Albacite" {{ old('banner_printing_colink') == 'Berminie Albacite' ? 'selected' : '' }}>Berminie Albacite</option>
                                                                <option value="Fritzie Rama" {{ old('banner_printing_colink') == 'Fritzie Rama' ? 'selected' : '' }}>Fritzie Rama</option>
                                                                <option value="Jerson Cabunilas" {{ old('banner_printing_colink') == 'Jerson Cabunilas' ? 'selected' : '' }}>Jerson Cabunilas</option>
                                                                <option value="Jhiezel Jane Camarillo" {{ old('banner_printing_colink') == 'Jhiezel Jane Camarillo' ? 'selected' : '' }}>Jhiezel Jane Camarillo</option>
                                                                <option value="John Adrian Anonat" {{ old('banner_printing_colink') == 'John Adrian Anonat' ? 'selected' : '' }}>John Adrian Anonat</option>
                                                                <option value="Kathlyn Baclayon" {{ old('banner_printing_colink') == 'Kathlyn Baclayon' ? 'selected' : '' }}>Kathlyn Baclayon</option>
                                                                <option value="Kent John Gella" {{ old('banner_printing_colink') == 'Kent John Gella' ? 'selected' : '' }}>Kent John Gella</option>
                                                                <option value="Khevin Mamolo" {{ old('banner_printing_colink') == 'Khevin Mamolo' ? 'selected' : '' }}>Khevin Mamolo</option>
                                                                <option value="Leendon Gelborion" {{ old('banner_printing_colink') == 'Leendon Gelborion' ? 'selected' : '' }}>Leendon Gelborion</option>
                                                                <option value="Marianne Anselm Dela Cruz" {{ old('banner_printing_colink') == 'Marianne Anselm Dela Cruz' ? 'selected' : '' }}>Marianne Anselm Dela Cruz</option>
                                                                <option value="Mariella Mamalias" {{ old('banner_printing_colink') == 'Mariella Mamalias' ? 'selected' : '' }}>Mariella Mamalias</option>
                                                                <option value="Mary Jedde Ampolitod-Busa" {{ old('banner_printing_colink') == 'Mary Jedde Ampolitod-Busa' ? 'selected' : '' }}>Mary Jedde Ampolitod-Busa</option>
                                                                <option value="Mayell Mamalias" {{ old('banner_printing_colink') == 'Mayell Mamalias' ? 'selected' : '' }}>Mayell Mamalias</option>
                                                                <option value="Michelle Alcain" {{ old('banner_printing_colink') == 'Michelle Alcain' ? 'selected' : '' }}>Michelle Alcain</option>
                                                                <option value="Nheil Stephen Dela Cruz" {{ old('banner_printing_colink') == 'Nheil Stephen Dela Cruz' ? 'selected' : '' }}>Nheil Stephen Dela Cruz</option>
                                                                <option value="Paul Benedict Sariana" {{ old('banner_printing_colink') == 'Paul Benedict Sariana' ? 'selected' : '' }}>Paul Benedict Sariana</option>
                                                                <option value="Peter Cris Rufo" {{ old('banner_printing_colink') == 'Peter Cris Rufo' ? 'selected' : '' }}>Peter Cris Rufo</option>
                                                                <option value="Raden Remolino" {{ old('banner_printing_colink') == 'Raden Remolino' ? 'selected' : '' }}>Raden Remolino</option>
                                                                <option value="Rica Jane Camello" {{ old('banner_printing_colink') == 'Rica Jane Camello' ? 'selected' : '' }}>Rica Jane Camello</option>
                                                                <option value="Richard De Los Reyes" {{ old('banner_printing_colink') == 'Richard De Los Reyes' ? 'selected' : '' }}>Richard De Los Reyes</option>
                                                                <option value="Shaine Birondo" {{ old('banner_printing_colink') == 'Shaine Birondo' ? 'selected' : '' }}>Shaine Birondo</option>
                                                                <option value="Zaire Nathaniel Almirante" {{ old('banner_printing_colink') == 'Zaire Nathaniel Almirante' ? 'selected' : '' }}>Zaire Nathaniel Almirante</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            @error('banner_printing_timeline')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <input type="date" value="{{ old('banner_printing_timeline') }}" name="banner_printing_timeline" class="w-full p-2 border rounded">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="coordination_for_venue" class="block text-sm font-medium text-gray-700">Coordination for Venue</label>
                                                        </td>
                                                        <td>
                                                            @error('coordination_for_venue_cost')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <input type="text" name="coordination_for_venue_cost" value="{{ old('coordination_for_venue_cost') }}" placeholder="Costing" class="w-full p-2 border rounded">
                                                        </td>
                                                        <td>
                                                            @error('coordination_for_venue_partner')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <input type="text" name="coordination_for_venue_partner" value="{{ old('coordination_for_venue_partner') }}" placeholder="Partner" class="w-full p-2 border rounded">
                                                        </td>
                                                        <td>
                                                            @error('coordination_for_venue_colink')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <select name="coordination_for_venue_colink" class="w-full p-2 border rounded">
                                                                <option value="" disabled selected>Select CoLink IC</option>
                                                                <option value="Aimie Rumaguera" {{ old('coordination_for_venue_colink') == 'Aimie Rumaguera' ? 'selected' : '' }}>Aimie Rumaguera</option>
                                                                <option value="Andrey Gel Bajenting" {{ old('coordination_for_venue_colink') == 'Andrey Gel Bajenting' ? 'selected' : '' }}>Andrey Gel Bajenting</option>
                                                                <option value="Berminie Albacite" {{ old('coordination_for_venue_colink') == 'Berminie Albacite' ? 'selected' : '' }}>Berminie Albacite</option>
                                                                <option value="Fritzie Rama" {{ old('coordination_for_venue_colink') == 'Fritzie Rama' ? 'selected' : '' }}>Fritzie Rama</option>
                                                                <option value="Jerson Cabunilas" {{ old('coordination_for_venue_colink') == 'Jerson Cabunilas' ? 'selected' : '' }}>Jerson Cabunilas</option>
                                                                <option value="Jhiezel Jane Camarillo" {{ old('coordination_for_venue_colink') == 'Jhiezel Jane Camarillo' ? 'selected' : '' }}>Jhiezel Jane Camarillo</option>
                                                                <option value="John Adrian Anonat" {{ old('coordination_for_venue_colink') == 'John Adrian Anonat' ? 'selected' : '' }}>John Adrian Anonat</option>
                                                                <option value="Kathlyn Baclayon" {{ old('coordination_for_venue_colink') == 'Kathlyn Baclayon' ? 'selected' : '' }}>Kathlyn Baclayon</option>
                                                                <option value="Kent John Gella" {{ old('coordination_for_venue_colink') == 'Kent John Gella' ? 'selected' : '' }}>Kent John Gella</option>
                                                                <option value="Khevin Mamolo" {{ old('coordination_for_venue_colink') == 'Khevin Mamolo' ? 'selected' : '' }}>Khevin Mamolo</option>
                                                                <option value="Leendon Gelborion" {{ old('coordination_for_venue_colink') == 'Leendon Gelborion' ? 'selected' : '' }}>Leendon Gelborion</option>
                                                                <option value="Marianne Anselm Dela Cruz" {{ old('coordination_for_venue_colink') == 'Marianne Anselm Dela Cruz' ? 'selected' : '' }}>Marianne Anselm Dela Cruz</option>
                                                                <option value="Mariella Mamalias" {{ old('coordination_for_venue_colink') == 'Mariella Mamalias' ? 'selected' : '' }}>Mariella Mamalias</option>
                                                                <option value="Mary Jedde Ampolitod-Busa" {{ old('coordination_for_venue_colink') == 'Mary Jedde Ampolitod-Busa' ? 'selected' : '' }}>Mary Jedde Ampolitod-Busa</option>
                                                                <option value="Mayell Mamalias" {{ old('coordination_for_venue_colink') == 'Mayell Mamalias' ? 'selected' : '' }}>Mayell Mamalias</option>
                                                                <option value="Michelle Alcain" {{ old('coordination_for_venue_colink') == 'Michelle Alcain' ? 'selected' : '' }}>Michelle Alcain</option>
                                                                <option value="Nheil Stephen Dela Cruz" {{ old('coordination_for_venue_colink') == 'Nheil Stephen Dela Cruz' ? 'selected' : '' }}>Nheil Stephen Dela Cruz</option>
                                                                <option value="Paul Benedict Sariana" {{ old('coordination_for_venue_colink') == 'Paul Benedict Sariana' ? 'selected' : '' }}>Paul Benedict Sariana</option>
                                                                <option value="Peter Cris Rufo" {{ old('coordination_for_venue_colink') == 'Peter Cris Rufo' ? 'selected' : '' }}>Peter Cris Rufo</option>
                                                                <option value="Raden Remolino" {{ old('coordination_for_venue_colink') == 'Raden Remolino' ? 'selected' : '' }}>Raden Remolino</option>
                                                                <option value="Rica Jane Camello" {{ old('coordination_for_venue_colink') == 'Rica Jane Camello' ? 'selected' : '' }}>Rica Jane Camello</option>
                                                                <option value="Richard De Los Reyes" {{ old('coordination_for_venue_colink') == 'Richard De Los Reyes' ? 'selected' : '' }}>Richard De Los Reyes</option>
                                                                <option value="Shaine Birondo" {{ old('coordination_for_venue_colink') == 'Shaine Birondo' ? 'selected' : '' }}>Shaine Birondo</option>
                                                                <option value="Zaire Nathaniel Almirante" {{ old('coordination_for_venue_colink') == 'Zaire Nathaniel Almirante' ? 'selected' : '' }}>Zaire Nathaniel Almirante</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            @error('coordination_for_venue_timeline')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <input type="date" value="{{ old('coordination_for_venue_timeline') }}" name="coordination_for_venue_timeline" class="w-full p-2 border rounded">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="coordination_for_participants" class="block text-sm font-medium text-gray-700">Coordination for Participants</label>
                                                        </td>
                                                        <td>
                                                            @error('coordination_for_participants_cost')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <input type="text" name="coordination_for_participants_cost" value="{{ old('coordination_for_participants_cost') }}" placeholder="Costing" class="w-full p-2 border rounded">
                                                        </td>
                                                        <td>
                                                            @error('coordination_for_participants_partner')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <input type="text" name="coordination_for_participants_partner" value="{{ old('coordination_for_participants_partner') }}" placeholder="Partner" class="w-full p-2 border rounded">
                                                        </td>
                                                        <td>
                                                            @error('coordination_for_participants_colink')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <select name="coordination_for_participants_colink" class="w-full p-2 border rounded">
                                                                <option value="" disabled selected>Select CoLink IC</option>
                                                                <option value="Aimie Rumaguera" {{ old('coordination_for_participants_colink') == 'Aimie Rumaguera' ? 'selected' : '' }}>Aimie Rumaguera</option>
                                                                <option value="Andrey Gel Bajenting" {{ old('coordination_for_participants_colink') == 'Andrey Gel Bajenting' ? 'selected' : '' }}>Andrey Gel Bajenting</option>
                                                                <option value="Berminie Albacite" {{ old('coordination_for_participants_colink') == 'Berminie Albacite' ? 'selected' : '' }}>Berminie Albacite</option>
                                                                <option value="Fritzie Rama" {{ old('coordination_for_participants_colink') == 'Fritzie Rama' ? 'selected' : '' }}>Fritzie Rama</option>
                                                                <option value="Jerson Cabunilas" {{ old('coordination_for_participants_colink') == 'Jerson Cabunilas' ? 'selected' : '' }}>Jerson Cabunilas</option>
                                                                <option value="Jhiezel Jane Camarillo" {{ old('coordination_for_participants_colink') == 'Jhiezel Jane Camarillo' ? 'selected' : '' }}>Jhiezel Jane Camarillo</option>
                                                                <option value="John Adrian Anonat" {{ old('coordination_for_participants_colink') == 'John Adrian Anonat' ? 'selected' : '' }}>John Adrian Anonat</option>
                                                                <option value="Kathlyn Baclayon" {{ old('coordination_for_participants_colink') == 'Kathlyn Baclayon' ? 'selected' : '' }}>Kathlyn Baclayon</option>
                                                                <option value="Kent John Gella" {{ old('coordination_for_participants_colink') == 'Kent John Gella' ? 'selected' : '' }}>Kent John Gella</option>
                                                                <option value="Khevin Mamolo" {{ old('coordination_for_participants_colink') == 'Khevin Mamolo' ? 'selected' : '' }}>Khevin Mamolo</option>
                                                                <option value="Leendon Gelborion" {{ old('coordination_for_participants_colink') == 'Leendon Gelborion' ? 'selected' : '' }}>Leendon Gelborion</option>
                                                                <option value="Marianne Anselm Dela Cruz" {{ old('coordination_for_participants_colink') == 'Marianne Anselm Dela Cruz' ? 'selected' : '' }}>Marianne Anselm Dela Cruz</option>
                                                                <option value="Mariella Mamalias" {{ old('coordination_for_participants_colink') == 'Mariella Mamalias' ? 'selected' : '' }}>Mariella Mamalias</option>
                                                                <option value="Mary Jedde Ampolitod-Busa" {{ old('coordination_for_participants_colink') == 'Mary Jedde Ampolitod-Busa' ? 'selected' : '' }}>Mary Jedde Ampolitod-Busa</option>
                                                                <option value="Mayell Mamalias" {{ old('coordination_for_participants_colink') == 'Mayell Mamalias' ? 'selected' : '' }}>Mayell Mamalias</option>
                                                                <option value="Michelle Alcain" {{ old('coordination_for_participants_colink') == 'Michelle Alcain' ? 'selected' : '' }}>Michelle Alcain</option>
                                                                <option value="Nheil Stephen Dela Cruz" {{ old('coordination_for_participants_colink') == 'Nheil Stephen Dela Cruz' ? 'selected' : '' }}>Nheil Stephen Dela Cruz</option>
                                                                <option value="Paul Benedict Sariana" {{ old('coordination_for_participants_colink') == 'Paul Benedict Sariana' ? 'selected' : '' }}>Paul Benedict Sariana</option>
                                                                <option value="Peter Cris Rufo" {{ old('coordination_for_participants_colink') == 'Peter Cris Rufo' ? 'selected' : '' }}>Peter Cris Rufo</option>
                                                                <option value="Raden Remolino" {{ old('coordination_for_participants_colink') == 'Raden Remolino' ? 'selected' : '' }}>Raden Remolino</option>
                                                                <option value="Rica Jane Camello" {{ old('coordination_for_participants_colink') == 'Rica Jane Camello' ? 'selected' : '' }}>Rica Jane Camello</option>
                                                                <option value="Richard De Los Reyes" {{ old('coordination_for_participants_colink') == 'Richard De Los Reyes' ? 'selected' : '' }}>Richard De Los Reyes</option>
                                                                <option value="Shaine Birondo" {{ old('coordination_for_participants_colink') == 'Shaine Birondo' ? 'selected' : '' }}>Shaine Birondo</option>
                                                                <option value="Zaire Nathaniel Almirante" {{ old('coordination_for_participants_colink') == 'Zaire Nathaniel Almirante' ? 'selected' : '' }}>Zaire Nathaniel Almirante</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            @error('coordination_for_participants_timeline')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <input type="date" value="{{ old('coordination_for_participants_timeline') }}" name="coordination_for_participants_timeline" class="w-full p-2 border rounded">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="coordination_food_concession" class="block text-sm font-medium text-gray-700">Coordination with food concessioners</label>
                                                        </td>
                                                        <td>
                                                            @error('coordination_food_concession_cost')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <input type="text" name="coordination_food_concession_cost" value="{{ old('coordination_food_concession_cost') }}" placeholder="Costing" class="w-full p-2 border rounded">
                                                        </td>
                                                        <td>
                                                            @error('coordination_food_concession_partner')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <input type="text" name="coordination_food_concession_partner" value="{{ old('coordination_food_concession_partner') }}" placeholder="Partner" class="w-full p-2 border rounded">
                                                        </td>
                                                        <td>
                                                            @error('coordination_food_concession_colink')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <select name="coordination_food_concession_colink" class="w-full p-2 border rounded">
                                                                <option value="" disabled selected>Select CoLink IC</option>
                                                                <option value="Aimie Rumaguera" {{ old('coordination_food_concession_colink') == 'Aimie Rumaguera' ? 'selected' : '' }}>Aimie Rumaguera</option>
                                                                <option value="Andrey Gel Bajenting" {{ old('coordination_food_concession_colink') == 'Andrey Gel Bajenting' ? 'selected' : '' }}>Andrey Gel Bajenting</option>
                                                                <option value="Berminie Albacite" {{ old('coordination_food_concession_colink') == 'Berminie Albacite' ? 'selected' : '' }}>Berminie Albacite</option>
                                                                <option value="Fritzie Rama" {{ old('coordination_food_concession_colink') == 'Fritzie Rama' ? 'selected' : '' }}>Fritzie Rama</option>
                                                                <option value="Jerson Cabunilas" {{ old('coordination_food_concession_colink') == 'Jerson Cabunilas' ? 'selected' : '' }}>Jerson Cabunilas</option>
                                                                <option value="Jhiezel Jane Camarillo" {{ old('coordination_food_concession_colink') == 'Jhiezel Jane Camarillo' ? 'selected' : '' }}>Jhiezel Jane Camarillo</option>
                                                                <option value="John Adrian Anonat" {{ old('coordination_food_concession_colink') == 'John Adrian Anonat' ? 'selected' : '' }}>John Adrian Anonat</option>
                                                                <option value="Kathlyn Baclayon" {{ old('coordination_food_concession_colink') == 'Kathlyn Baclayon' ? 'selected' : '' }}>Kathlyn Baclayon</option>
                                                                <option value="Kent John Gella" {{ old('coordination_food_concession_colink') == 'Kent John Gella' ? 'selected' : '' }}>Kent John Gella</option>
                                                                <option value="Khevin Mamolo" {{ old('coordination_food_concession_colink') == 'Khevin Mamolo' ? 'selected' : '' }}>Khevin Mamolo</option>
                                                                <option value="Leendon Gelborion" {{ old('coordination_food_concession_colink') == 'Leendon Gelborion' ? 'selected' : '' }}>Leendon Gelborion</option>
                                                                <option value="Marianne Anselm Dela Cruz" {{ old('coordination_food_concession_colink') == 'Marianne Anselm Dela Cruz' ? 'selected' : '' }}>Marianne Anselm Dela Cruz</option>
                                                                <option value="Mariella Mamalias" {{ old('coordination_food_concession_colink') == 'Mariella Mamalias' ? 'selected' : '' }}>Mariella Mamalias</option>
                                                                <option value="Mary Jedde Ampolitod-Busa" {{ old('coordination_food_concession_colink') == 'Mary Jedde Ampolitod-Busa' ? 'selected' : '' }}>Mary Jedde Ampolitod-Busa</option>
                                                                <option value="Mayell Mamalias" {{ old('coordination_food_concession_colink') == 'Mayell Mamalias' ? 'selected' : '' }}>Mayell Mamalias</option>
                                                                <option value="Michelle Alcain" {{ old('coordination_food_concession_colink') == 'Michelle Alcain' ? 'selected' : '' }}>Michelle Alcain</option>
                                                                <option value="Nheil Stephen Dela Cruz" {{ old('coordination_food_concession_colink') == 'Nheil Stephen Dela Cruz' ? 'selected' : '' }}>Nheil Stephen Dela Cruz</option>
                                                                <option value="Paul Benedict Sariana" {{ old('coordination_food_concession_colink') == 'Paul Benedict Sariana' ? 'selected' : '' }}>Paul Benedict Sariana</option>
                                                                <option value="Peter Cris Rufo" {{ old('coordination_food_concession_colink') == 'Peter Cris Rufo' ? 'selected' : '' }}>Peter Cris Rufo</option>
                                                                <option value="Raden Remolino" {{ old('coordination_food_concession_colink') == 'Raden Remolino' ? 'selected' : '' }}>Raden Remolino</option>
                                                                <option value="Rica Jane Camello" {{ old('coordination_food_concession_colink') == 'Rica Jane Camello' ? 'selected' : '' }}>Rica Jane Camello</option>
                                                                <option value="Richard De Los Reyes" {{ old('coordination_food_concession_colink') == 'Richard De Los Reyes' ? 'selected' : '' }}>Richard De Los Reyes</option>
                                                                <option value="Shaine Birondo" {{ old('coordination_food_concession_colink') == 'Shaine Birondo' ? 'selected' : '' }}>Shaine Birondo</option>
                                                                <option value="Zaire Nathaniel Almirante" {{ old('coordination_food_concession_colink') == 'Zaire Nathaniel Almirante' ? 'selected' : '' }}>Zaire Nathaniel Almirante</option>
                                                            </select>
                                                        </td>

                                                        <td>
                                                            @error('coordination_food_concession_timeline')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <input type="date" value="{{ old('coordination_food_concession_timeline') }}" name="coordination_food_concession_timeline" class="w-full p-2 border rounded">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="coordination_with_speakers" class="block text-sm font-medium text-gray-700">Coordination with Speakers</label>
                                                        </td>
                                                        <td>
                                                            @error('coordination_with_speakers_cost')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <input type="text" name="coordination_with_speakers_cost" value="{{ old('coordination_with_speakers_cost') }}" placeholder="Costing" class="w-full p-2 border rounded">
                                                        </td>
                                                        <td>
                                                            @error('coordination_with_speakers_partner')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <input type="text" name="coordination_with_speakers_partner" value="{{ old('coordination_with_speakers_partner') }}" placeholder="Partner" class="w-full p-2 border rounded">
                                                        </td>
                                                        <td>
                                                            @error('coordination_with_speakers_colink')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <select name="coordination_with_speakers_colink" class="w-full p-2 border rounded">
                                                                <option value="" disabled selected>Select CoLink IC</option>
                                                                <option value="Aimie Rumaguera" {{ old('coordination_with_speakers_colink') == 'Aimie Rumaguera' ? 'selected' : '' }}>Aimie Rumaguera</option>
                                                                <option value="Andrey Gel Bajenting" {{ old('coordination_with_speakers_colink') == 'Andrey Gel Bajenting' ? 'selected' : '' }}>Andrey Gel Bajenting</option>
                                                                <option value="Berminie Albacite" {{ old('coordination_with_speakers_colink') == 'Berminie Albacite' ? 'selected' : '' }}>Berminie Albacite</option>
                                                                <option value="Fritzie Rama" {{ old('coordination_with_speakers_colink') == 'Fritzie Rama' ? 'selected' : '' }}>Fritzie Rama</option>
                                                                <option value="Jerson Cabunilas" {{ old('coordination_with_speakers_colink') == 'Jerson Cabunilas' ? 'selected' : '' }}>Jerson Cabunilas</option>
                                                                <option value="Jhiezel Jane Camarillo" {{ old('coordination_with_speakers_colink') == 'Jhiezel Jane Camarillo' ? 'selected' : '' }}>Jhiezel Jane Camarillo</option>
                                                                <option value="John Adrian Anonat" {{ old('coordination_with_speakers_colink') == 'John Adrian Anonat' ? 'selected' : '' }}>John Adrian Anonat</option>
                                                                <option value="Kathlyn Baclayon" {{ old('coordination_with_speakers_colink') == 'Kathlyn Baclayon' ? 'selected' : '' }}>Kathlyn Baclayon</option>
                                                                <option value="Kent John Gella" {{ old('coordination_with_speakers_colink') == 'Kent John Gella' ? 'selected' : '' }}>Kent John Gella</option>
                                                                <option value="Khevin Mamolo" {{ old('coordination_with_speakers_colink') == 'Khevin Mamolo' ? 'selected' : '' }}>Khevin Mamolo</option>
                                                                <option value="Leendon Gelborion" {{ old('coordination_with_speakers_colink') == 'Leendon Gelborion' ? 'selected' : '' }}>Leendon Gelborion</option>
                                                                <option value="Marianne Anselm Dela Cruz" {{ old('coordination_with_speakers_colink') == 'Marianne Anselm Dela Cruz' ? 'selected' : '' }}>Marianne Anselm Dela Cruz</option>
                                                                <option value="Mariella Mamalias" {{ old('coordination_with_speakers_colink') == 'Mariella Mamalias' ? 'selected' : '' }}>Mariella Mamalias</option>
                                                                <option value="Mary Jedde Ampolitod-Busa" {{ old('coordination_with_speakers_colink') == 'Mary Jedde Ampolitod-Busa' ? 'selected' : '' }}>Mary Jedde Ampolitod-Busa</option>
                                                                <option value="Mayell Mamalias" {{ old('coordination_with_speakers_colink') == 'Mayell Mamalias' ? 'selected' : '' }}>Mayell Mamalias</option>
                                                                <option value="Michelle Alcain" {{ old('coordination_with_speakers_colink') == 'Michelle Alcain' ? 'selected' : '' }}>Michelle Alcain</option>
                                                                <option value="Nheil Stephen Dela Cruz" {{ old('coordination_with_speakers_colink') == 'Nheil Stephen Dela Cruz' ? 'selected' : '' }}>Nheil Stephen Dela Cruz</option>
                                                                <option value="Paul Benedict Sariana" {{ old('coordination_with_speakers_colink') == 'Paul Benedict Sariana' ? 'selected' : '' }}>Paul Benedict Sariana</option>
                                                                <option value="Peter Cris Rufo" {{ old('coordination_with_speakers_colink') == 'Peter Cris Rufo' ? 'selected' : '' }}>Peter Cris Rufo</option>
                                                                <option value="Raden Remolino" {{ old('coordination_with_speakers_colink') == 'Raden Remolino' ? 'selected' : '' }}>Raden Remolino</option>
                                                                <option value="Rica Jane Camello" {{ old('coordination_with_speakers_colink') == 'Rica Jane Camello' ? 'selected' : '' }}>Rica Jane Camello</option>
                                                                <option value="Richard De Los Reyes" {{ old('coordination_with_speakers_colink') == 'Richard De Los Reyes' ? 'selected' : '' }}>Richard De Los Reyes</option>
                                                                <option value="Shaine Birondo" {{ old('coordination_with_speakers_colink') == 'Shaine Birondo' ? 'selected' : '' }}>Shaine Birondo</option>
                                                                <option value="Zaire Nathaniel Almirante" {{ old('coordination_with_speakers_colink') == 'Zaire Nathaniel Almirante' ? 'selected' : '' }}>Zaire Nathaniel Almirante</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            @error('coordination_with_speakers_timeline')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <input type="date" value="{{ old('coordination_with_speakers_timeline') }}" name="coordination_with_speakers_timeline" class="w-full p-2 border rounded">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="slide">
                                        <h3>V. Accountabilities (part 4)</h3>
                                        <div class="table-container">
                                            <table>
                                                <thead>
                                                    <tr>
                                                        <th>Tasking</th>
                                                        <th>Costing</th>
                                                        <th>Partner</th>
                                                        <th>CoLink IC</th>
                                                        <th>Timeline</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <label for="supporting_coordination" class="block text-sm font-medium text-gray-700">Supporting Documents Coordination</label>
                                                        </td>
                                                        <td>
                                                            @error('supporting_coordination_cost')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <input type="text" name="supporting_coordination_cost" value="{{ old('supporting_coordination_cost') }}" placeholder="Costing" class="w-full p-2 border rounded">
                                                        </td>
                                                        <td>
                                                            @error('supporting_coordination_partner')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <input type="text" name="supporting_coordination_partner" value="{{ old('supporting_coordination_partner') }}" placeholder="Partner" class="w-full p-2 border rounded">
                                                        </td>
                                                        <td>
                                                            @error('supporting_coordination_colink')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <select name="supporting_coordination_colink" class="w-full p-2 border rounded">
                                                                <option value="" disabled selected>Select CoLink IC</option>
                                                                <option value="Aimie Rumaguera" {{ old('supporting_coordination_colink') == 'Aimie Rumaguera' ? 'selected' : '' }}>Aimie Rumaguera</option>
                                                                <option value="Andrey Gel Bajenting" {{ old('supporting_coordination_colink') == 'Andrey Gel Bajenting' ? 'selected' : '' }}>Andrey Gel Bajenting</option>
                                                                <option value="Berminie Albacite" {{ old('supporting_coordination_colink') == 'Berminie Albacite' ? 'selected' : '' }}>Berminie Albacite</option>
                                                                <option value="Fritzie Rama" {{ old('supporting_coordination_colink') == 'Fritzie Rama' ? 'selected' : '' }}>Fritzie Rama</option>
                                                                <option value="Jerson Cabunilas" {{ old('supporting_coordination_colink') == 'Jerson Cabunilas' ? 'selected' : '' }}>Jerson Cabunilas</option>
                                                                <option value="Jhiezel Jane Camarillo" {{ old('supporting_coordination_colink') == 'Jhiezel Jane Camarillo' ? 'selected' : '' }}>Jhiezel Jane Camarillo</option>
                                                                <option value="John Adrian Anonat" {{ old('supporting_coordination_colink') == 'John Adrian Anonat' ? 'selected' : '' }}>John Adrian Anonat</option>
                                                                <option value="Kathlyn Baclayon" {{ old('supporting_coordination_colink') == 'Kathlyn Baclayon' ? 'selected' : '' }}>Kathlyn Baclayon</option>
                                                                <option value="Kent John Gella" {{ old('supporting_coordination_colink') == 'Kent John Gella' ? 'selected' : '' }}>Kent John Gella</option>
                                                                <option value="Khevin Mamolo" {{ old('supporting_coordination_colink') == 'Khevin Mamolo' ? 'selected' : '' }}>Khevin Mamolo</option>
                                                                <option value="Leendon Gelborion" {{ old('supporting_coordination_colink') == 'Leendon Gelborion' ? 'selected' : '' }}>Leendon Gelborion</option>
                                                                <option value="Marianne Anselm Dela Cruz" {{ old('supporting_coordination_colink') == 'Marianne Anselm Dela Cruz' ? 'selected' : '' }}>Marianne Anselm Dela Cruz</option>
                                                                <option value="Mariella Mamalias" {{ old('supporting_coordination_colink') == 'Mariella Mamalias' ? 'selected' : '' }}>Mariella Mamalias</option>
                                                                <option value="Mary Jedde Ampolitod-Busa" {{ old('supporting_coordination_colink') == 'Mary Jedde Ampolitod-Busa' ? 'selected' : '' }}>Mary Jedde Ampolitod-Busa</option>
                                                                <option value="Mayell Mamalias" {{ old('supporting_coordination_colink') == 'Mayell Mamalias' ? 'selected' : '' }}>Mayell Mamalias</option>
                                                                <option value="Michelle Alcain" {{ old('supporting_coordination_colink') == 'Michelle Alcain' ? 'selected' : '' }}>Michelle Alcain</option>
                                                                <option value="Nheil Stephen Dela Cruz" {{ old('supporting_coordination_colink') == 'Nheil Stephen Dela Cruz' ? 'selected' : '' }}>Nheil Stephen Dela Cruz</option>
                                                                <option value="Paul Benedict Sariana" {{ old('supporting_coordination_colink') == 'Paul Benedict Sariana' ? 'selected' : '' }}>Paul Benedict Sariana</option>
                                                                <option value="Peter Cris Rufo" {{ old('supporting_coordination_colink') == 'Peter Cris Rufo' ? 'selected' : '' }}>Peter Cris Rufo</option>
                                                                <option value="Raden Remolino" {{ old('supporting_coordination_colink') == 'Raden Remolino' ? 'selected' : '' }}>Raden Remolino</option>
                                                                <option value="Rica Jane Camello" {{ old('supporting_coordination_colink') == 'Rica Jane Camello' ? 'selected' : '' }}>Rica Jane Camello</option>
                                                                <option value="Richard De Los Reyes" {{ old('supporting_coordination_colink') == 'Richard De Los Reyes' ? 'selected' : '' }}>Richard De Los Reyes</option>
                                                                <option value="Shaine Birondo" {{ old('supporting_coordination_colink') == 'Shaine Birondo' ? 'selected' : '' }}>Shaine Birondo</option>
                                                                <option value="Zaire Nathaniel Almirante" {{ old('supporting_coordination_colink') == 'Zaire Nathaniel Almirante' ? 'selected' : '' }}>Zaire Nathaniel Almirante</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            @error('supporting_coordination_timeline')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <input type="date" value="{{ old('supporting_coordination_timeline') }}" name="supporting_coordination_timeline" class="w-full p-2 border rounded">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="insurance" class="block text-sm font-medium text-gray-700">Insurance</label>
                                                        </td>
                                                        <td>
                                                            @error('insurance_cost')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <input type="text" name="insurance_cost" value="{{ old('insurance_cost') }}" placeholder="Costing" class="w-full p-2 border rounded">
                                                        </td>
                                                        <td>
                                                            @error('insurance_partner')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <input type="text" name="insurance_partner" value="{{ old('insurance_partner') }}" placeholder="Partner" class="w-full p-2 border rounded">
                                                        </td>
                                                        <td>
                                                            @error('insurance_colink')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <select name="insurance_colink" class="w-full p-2 border rounded">
                                                                <option value="" disabled selected>Select CoLink IC</option>
                                                                <option value="Aimie Rumaguera" {{ old('insurance_colink') == 'Aimie Rumaguera' ? 'selected' : '' }}>Aimie Rumaguera</option>
                                                                <option value="Andrey Gel Bajenting" {{ old('insurance_colink') == 'Andrey Gel Bajenting' ? 'selected' : '' }}>Andrey Gel Bajenting</option>
                                                                <option value="Berminie Albacite" {{ old('insurance_colink') == 'Berminie Albacite' ? 'selected' : '' }}>Berminie Albacite</option>
                                                                <option value="Fritzie Rama" {{ old('insurance_colink') == 'Fritzie Rama' ? 'selected' : '' }}>Fritzie Rama</option>
                                                                <option value="Jerson Cabunilas" {{ old('insurance_colink') == 'Jerson Cabunilas' ? 'selected' : '' }}>Jerson Cabunilas</option>
                                                                <option value="Jhiezel Jane Camarillo" {{ old('insurance_colink') == 'Jhiezel Jane Camarillo' ? 'selected' : '' }}>Jhiezel Jane Camarillo</option>
                                                                <option value="John Adrian Anonat" {{ old('insurance_colink') == 'John Adrian Anonat' ? 'selected' : '' }}>John Adrian Anonat</option>
                                                                <option value="Kathlyn Baclayon" {{ old('insurance_colink') == 'Kathlyn Baclayon' ? 'selected' : '' }}>Kathlyn Baclayon</option>
                                                                <option value="Kent John Gella" {{ old('insurance_colink') == 'Kent John Gella' ? 'selected' : '' }}>Kent John Gella</option>
                                                                <option value="Khevin Mamolo" {{ old('insurance_colink') == 'Khevin Mamolo' ? 'selected' : '' }}>Khevin Mamolo</option>
                                                                <option value="Leendon Gelborion" {{ old('insurance_colink') == 'Leendon Gelborion' ? 'selected' : '' }}>Leendon Gelborion</option>
                                                                <option value="Marianne Anselm Dela Cruz" {{ old('insurance_colink') == 'Marianne Anselm Dela Cruz' ? 'selected' : '' }}>Marianne Anselm Dela Cruz</option>
                                                                <option value="Mariella Mamalias" {{ old('insurance_colink') == 'Mariella Mamalias' ? 'selected' : '' }}>Mariella Mamalias</option>
                                                                <option value="Mary Jedde Ampolitod-Busa" {{ old('insurance_colink') == 'Mary Jedde Ampolitod-Busa' ? 'selected' : '' }}>Mary Jedde Ampolitod-Busa</option>
                                                                <option value="Mayell Mamalias" {{ old('insurance_colink') == 'Mayell Mamalias' ? 'selected' : '' }}>Mayell Mamalias</option>
                                                                <option value="Michelle Alcain" {{ old('insurance_colink') == 'Michelle Alcain' ? 'selected' : '' }}>Michelle Alcain</option>
                                                                <option value="Nheil Stephen Dela Cruz" {{ old('insurance_colink') == 'Nheil Stephen Dela Cruz' ? 'selected' : '' }}>Nheil Stephen Dela Cruz</option>
                                                                <option value="Paul Benedict Sariana" {{ old('insurance_colink') == 'Paul Benedict Sariana' ? 'selected' : '' }}>Paul Benedict Sariana</option>
                                                                <option value="Peter Cris Rufo" {{ old('insurance_colink') == 'Peter Cris Rufo' ? 'selected' : '' }}>Peter Cris Rufo</option>
                                                                <option value="Raden Remolino" {{ old('insurance_colink') == 'Raden Remolino' ? 'selected' : '' }}>Raden Remolino</option>
                                                                <option value="Rica Jane Camello" {{ old('insurance_colink') == 'Rica Jane Camello' ? 'selected' : '' }}>Rica Jane Camello</option>
                                                                <option value="Richard De Los Reyes" {{ old('insurance_colink') == 'Richard De Los Reyes' ? 'selected' : '' }}>Richard De Los Reyes</option>
                                                                <option value="Shaine Birondo" {{ old('insurance_colink') == 'Shaine Birondo' ? 'selected' : '' }}>Shaine Birondo</option>
                                                                <option value="Zaire Nathaniel Almirante" {{ old('insurance_colink') == 'Zaire Nathaniel Almirante' ? 'selected' : '' }}>Zaire Nathaniel Almirante</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            @error('insurance_timeline')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <input type="date" value="{{ old('insurance_timeline') }}" name="insurance_timeline" class="w-full p-2 border rounded">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="venue_recce" class="block text-sm font-medium text-gray-700">Venue Recce</label>
                                                        </td>
                                                        <td>
                                                            @error('venue_recce_cost')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <input type="text" name="venue_recce_cost" value="{{ old('venue_recce_cost') }}" placeholder="Costing" class="w-full p-2 border rounded">
                                                        </td>
                                                        <td>
                                                            @error('venue_recce_partner')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <input type="text" name="venue_recce_partner" value="{{ old('venue_recce_partner') }}" placeholder="Partner" class="w-full p-2 border rounded">
                                                        </td>
                                                        <td>
                                                            @error('venue_recce_colink')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <select name="venue_recce_colink" class="w-full p-2 border rounded">
                                                                <option value="" disabled selected>Select CoLink IC</option>
                                                                <option value="Aimie Rumaguera" {{ old('venue_recce_colink') == 'Aimie Rumaguera' ? 'selected' : '' }}>Aimie Rumaguera</option>
                                                                <option value="Andrey Gel Bajenting" {{ old('venue_recce_colink') == 'Andrey Gel Bajenting' ? 'selected' : '' }}>Andrey Gel Bajenting</option>
                                                                <option value="Berminie Albacite" {{ old('venue_recce_colink') == 'Berminie Albacite' ? 'selected' : '' }}>Berminie Albacite</option>
                                                                <option value="Fritzie Rama" {{ old('venue_recce_colink') == 'Fritzie Rama' ? 'selected' : '' }}>Fritzie Rama</option>
                                                                <option value="Jerson Cabunilas" {{ old('venue_recce_colink') == 'Jerson Cabunilas' ? 'selected' : '' }}>Jerson Cabunilas</option>
                                                                <option value="Jhiezel Jane Camarillo" {{ old('venue_recce_colink') == 'Jhiezel Jane Camarillo' ? 'selected' : '' }}>Jhiezel Jane Camarillo</option>
                                                                <option value="John Adrian Anonat" {{ old('venue_recce_colink') == 'John Adrian Anonat' ? 'selected' : '' }}>John Adrian Anonat</option>
                                                                <option value="Kathlyn Baclayon" {{ old('venue_recce_colink') == 'Kathlyn Baclayon' ? 'selected' : '' }}>Kathlyn Baclayon</option>
                                                                <option value="Kent John Gella" {{ old('venue_recce_colink') == 'Kent John Gella' ? 'selected' : '' }}>Kent John Gella</option>
                                                                <option value="Khevin Mamolo" {{ old('venue_recce_colink') == 'Khevin Mamolo' ? 'selected' : '' }}>Khevin Mamolo</option>
                                                                <option value="Leendon Gelborion" {{ old('venue_recce_colink') == 'Leendon Gelborion' ? 'selected' : '' }}>Leendon Gelborion</option>
                                                                <option value="Marianne Anselm Dela Cruz" {{ old('venue_recce_colink') == 'Marianne Anselm Dela Cruz' ? 'selected' : '' }}>Marianne Anselm Dela Cruz</option>
                                                                <option value="Mariella Mamalias" {{ old('venue_recce_colink') == 'Mariella Mamalias' ? 'selected' : '' }}>Mariella Mamalias</option>
                                                                <option value="Mary Jedde Ampolitod-Busa" {{ old('venue_recce_colink') == 'Mary Jedde Ampolitod-Busa' ? 'selected' : '' }}>Mary Jedde Ampolitod-Busa</option>
                                                                <option value="Mayell Mamalias" {{ old('venue_recce_colink') == 'Mayell Mamalias' ? 'selected' : '' }}>Mayell Mamalias</option>
                                                                <option value="Michelle Alcain" {{ old('venue_recce_colink') == 'Michelle Alcain' ? 'selected' : '' }}>Michelle Alcain</option>
                                                                <option value="Nheil Stephen Dela Cruz" {{ old('venue_recce_colink') == 'Nheil Stephen Dela Cruz' ? 'selected' : '' }}>Nheil Stephen Dela Cruz</option>
                                                                <option value="Paul Benedict Sariana" {{ old('venue_recce_colink') == 'Paul Benedict Sariana' ? 'selected' : '' }}>Paul Benedict Sariana</option>
                                                                <option value="Peter Cris Rufo" {{ old('venue_recce_colink') == 'Peter Cris Rufo' ? 'selected' : '' }}>Peter Cris Rufo</option>
                                                                <option value="Raden Remolino" {{ old('venue_recce_colink') == 'Raden Remolino' ? 'selected' : '' }}>Raden Remolino</option>
                                                                <option value="Rica Jane Camello" {{ old('venue_recce_colink') == 'Rica Jane Camello' ? 'selected' : '' }}>Rica Jane Camello</option>
                                                                <option value="Richard De Los Reyes" {{ old('venue_recce_colink') == 'Richard De Los Reyes' ? 'selected' : '' }}>Richard De Los Reyes</option>
                                                                <option value="Shaine Birondo" {{ old('venue_recce_colink') == 'Shaine Birondo' ? 'selected' : '' }}>Shaine Birondo</option>
                                                                <option value="Zaire Nathaniel Almirante" {{ old('venue_recce_colink') == 'Zaire Nathaniel Almirante' ? 'selected' : '' }}>Zaire Nathaniel Almirante</option>
                                                            </select>
                                                        </td>

                                                        <td>
                                                            @error('venue_recce_timeline')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <input type="date" value="{{ old('venue_recce_timeline') }}" name="venue_recce_timeline" class="w-full p-2 border rounded">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="documentation" class="block text-sm font-medium text-gray-700">Documentation (Pictures and Videos)</label>
                                                        </td>
                                                        <td>
                                                            @error('documentation_cost')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <input type="text" name="documentation_cost" value="{{ old('documentation_cost') }}" placeholder="250 per design" class="w-full p-2 border rounded">
                                                        </td>
                                                        <td>
                                                            @error('documentation_partner')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <input type="text" name="documentation_partner" value="{{ old('documentation_partner') }}" placeholder="Partner" class="w-full p-2 border rounded">
                                                        </td>
                                                        <td>
                                                            @error('documentation_colink')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <select name="documentation_colink" class="w-full p-2 border rounded">
                                                                <option value="" disabled selected>Select CoLink IC</option>
                                                                <option value="Aimie Rumaguera" {{ old('documentation_colink') == 'Aimie Rumaguera' ? 'selected' : '' }}>Aimie Rumaguera</option>
                                                                <option value="Andrey Gel Bajenting" {{ old('documentation_colink') == 'Andrey Gel Bajenting' ? 'selected' : '' }}>Andrey Gel Bajenting</option>
                                                                <option value="Berminie Albacite" {{ old('documentation_colink') == 'Berminie Albacite' ? 'selected' : '' }}>Berminie Albacite</option>
                                                                <option value="Fritzie Rama" {{ old('documentation_colink') == 'Fritzie Rama' ? 'selected' : '' }}>Fritzie Rama</option>
                                                                <option value="Jerson Cabunilas" {{ old('documentation_colink') == 'Jerson Cabunilas' ? 'selected' : '' }}>Jerson Cabunilas</option>
                                                                <option value="Jhiezel Jane Camarillo" {{ old('documentation_colink') == 'Jhiezel Jane Camarillo' ? 'selected' : '' }}>Jhiezel Jane Camarillo</option>
                                                                <option value="John Adrian Anonat" {{ old('documentation_colink') == 'John Adrian Anonat' ? 'selected' : '' }}>John Adrian Anonat</option>
                                                                <option value="Kathlyn Baclayon" {{ old('documentation_colink') == 'Kathlyn Baclayon' ? 'selected' : '' }}>Kathlyn Baclayon</option>
                                                                <option value="Kent John Gella" {{ old('documentation_colink') == 'Kent John Gella' ? 'selected' : '' }}>Kent John Gella</option>
                                                                <option value="Khevin Mamolo" {{ old('documentation_colink') == 'Khevin Mamolo' ? 'selected' : '' }}>Khevin Mamolo</option>
                                                                <option value="Leendon Gelborion" {{ old('documentation_colink') == 'Leendon Gelborion' ? 'selected' : '' }}>Leendon Gelborion</option>
                                                                <option value="Marianne Anselm Dela Cruz" {{ old('documentation_colink') == 'Marianne Anselm Dela Cruz' ? 'selected' : '' }}>Marianne Anselm Dela Cruz</option>
                                                                <option value="Mariella Mamalias" {{ old('documentation_colink') == 'Mariella Mamalias' ? 'selected' : '' }}>Mariella Mamalias</option>
                                                                <option value="Mary Jedde Ampolitod-Busa" {{ old('documentation_colink') == 'Mary Jedde Ampolitod-Busa' ? 'selected' : '' }}>Mary Jedde Ampolitod-Busa</option>
                                                                <option value="Mayell Mamalias" {{ old('documentation_colink') == 'Mayell Mamalias' ? 'selected' : '' }}>Mayell Mamalias</option>
                                                                <option value="Michelle Alcain" {{ old('documentation_colink') == 'Michelle Alcain' ? 'selected' : '' }}>Michelle Alcain</option>
                                                                <option value="Nheil Stephen Dela Cruz" {{ old('documentation_colink') == 'Nheil Stephen Dela Cruz' ? 'selected' : '' }}>Nheil Stephen Dela Cruz</option>
                                                                <option value="Paul Benedict Sariana" {{ old('documentation_colink') == 'Paul Benedict Sariana' ? 'selected' : '' }}>Paul Benedict Sariana</option>
                                                                <option value="Peter Cris Rufo" {{ old('documentation_colink') == 'Peter Cris Rufo' ? 'selected' : '' }}>Peter Cris Rufo</option>
                                                                <option value="Raden Remolino" {{ old('documentation_colink') == 'Raden Remolino' ? 'selected' : '' }}>Raden Remolino</option>
                                                                <option value="Rica Jane Camello" {{ old('documentation_colink') == 'Rica Jane Camello' ? 'selected' : '' }}>Rica Jane Camello</option>
                                                                <option value="Richard De Los Reyes" {{ old('documentation_colink') == 'Richard De Los Reyes' ? 'selected' : '' }}>Richard De Los Reyes</option>
                                                                <option value="Shaine Birondo" {{ old('documentation_colink') == 'Shaine Birondo' ? 'selected' : '' }}>Shaine Birondo</option>
                                                                <option value="Zaire Nathaniel Almirante" {{ old('documentation_colink') == 'Zaire Nathaniel Almirante' ? 'selected' : '' }}>Zaire Nathaniel Almirante</option>
                                                            </select>
                                                        <td>
                                                            @error('documentation_timeline')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <input type="date" value="{{ old('documentation_timeline') }}" name="documentation_timeline" class="w-full p-2 border rounded">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="video_teaser" class="block text-sm font-medium text-gray-700">Video Teaser</label>
                                                        </td>
                                                        <td>
                                                            @error('video_teaser_cost')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <input type="text" name="video_teaser_cost" value="{{ old('video_teaser_cost') }}" placeholder="Costing" class="w-full p-2 border rounded">
                                                        </td>
                                                        <td>
                                                            @error('video_teaser_partner')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <input type="text" name="video_teaser_partner" value="{{ old('video_teaser_partner') }}" placeholder="Partner" class="w-full p-2 border rounded">
                                                        </td>
                                                        <td>
                                                            @error('video_teaser_colink')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <select name="video_teaser_colink" class="w-full p-2 border rounded">
                                                                <option value="" disabled selected>Select CoLink IC</option>
                                                                <option value="Aimie Rumaguera" {{ old('video_teaser_colink') == 'Aimie Rumaguera' ? 'selected' : '' }}>Aimie Rumaguera</option>
                                                                <option value="Andrey Gel Bajenting" {{ old('video_teaser_colink') == 'Andrey Gel Bajenting' ? 'selected' : '' }}>Andrey Gel Bajenting</option>
                                                                <option value="Berminie Albacite" {{ old('video_teaser_colink') == 'Berminie Albacite' ? 'selected' : '' }}>Berminie Albacite</option>
                                                                <option value="Fritzie Rama" {{ old('video_teaser_colink') == 'Fritzie Rama' ? 'selected' : '' }}>Fritzie Rama</option>
                                                                <option value="Jerson Cabunilas" {{ old('video_teaser_colink') == 'Jerson Cabunilas' ? 'selected' : '' }}>Jerson Cabunilas</option>
                                                                <option value="Jhiezel Jane Camarillo" {{ old('video_teaser_colink') == 'Jhiezel Jane Camarillo' ? 'selected' : '' }}>Jhiezel Jane Camarillo</option>
                                                                <option value="John Adrian Anonat" {{ old('video_teaser_colink') == 'John Adrian Anonat' ? 'selected' : '' }}>John Adrian Anonat</option>
                                                                <option value="Kathlyn Baclayon" {{ old('video_teaser_colink') == 'Kathlyn Baclayon' ? 'selected' : '' }}>Kathlyn Baclayon</option>
                                                                <option value="Kent John Gella" {{ old('video_teaser_colink') == 'Kent John Gella' ? 'selected' : '' }}>Kent John Gella</option>
                                                                <option value="Khevin Mamolo" {{ old('video_teaser_colink') == 'Khevin Mamolo' ? 'selected' : '' }}>Khevin Mamolo</option>
                                                                <option value="Leendon Gelborion" {{ old('video_teaser_colink') == 'Leendon Gelborion' ? 'selected' : '' }}>Leendon Gelborion</option>
                                                                <option value="Marianne Anselm Dela Cruz" {{ old('video_teaser_colink') == 'Marianne Anselm Dela Cruz' ? 'selected' : '' }}>Marianne Anselm Dela Cruz</option>
                                                                <option value="Mariella Mamalias" {{ old('video_teaser_colink') == 'Mariella Mamalias' ? 'selected' : '' }}>Mariella Mamalias</option>
                                                                <option value="Mary Jedde Ampolitod-Busa" {{ old('video_teaser_colink') == 'Mary Jedde Ampolitod-Busa' ? 'selected' : '' }}>Mary Jedde Ampolitod-Busa</option>
                                                                <option value="Mayell Mamalias" {{ old('video_teaser_colink') == 'Mayell Mamalias' ? 'selected' : '' }}>Mayell Mamalias</option>
                                                                <option value="Michelle Alcain" {{ old('video_teaser_colink') == 'Michelle Alcain' ? 'selected' : '' }}>Michelle Alcain</option>
                                                                <option value="Nheil Stephen Dela Cruz" {{ old('video_teaser_colink') == 'Nheil Stephen Dela Cruz' ? 'selected' : '' }}>Nheil Stephen Dela Cruz</option>
                                                                <option value="Paul Benedict Sariana" {{ old('video_teaser_colink') == 'Paul Benedict Sariana' ? 'selected' : '' }}>Paul Benedict Sariana</option>
                                                                <option value="Peter Cris Rufo" {{ old('video_teaser_colink') == 'Peter Cris Rufo' ? 'selected' : '' }}>Peter Cris Rufo</option>
                                                                <option value="Raden Remolino" {{ old('video_teaser_colink') == 'Raden Remolino' ? 'selected' : '' }}>Raden Remolino</option>
                                                                <option value="Rica Jane Camello" {{ old('video_teaser_colink') == 'Rica Jane Camello' ? 'selected' : '' }}>Rica Jane Camello</option>
                                                                <option value="Richard De Los Reyes" {{ old('video_teaser_colink') == 'Richard De Los Reyes' ? 'selected' : '' }}>Richard De Los Reyes</option>
                                                                <option value="Shaine Birondo" {{ old('video_teaser_colink') == 'Shaine Birondo' ? 'selected' : '' }}>Shaine Birondo</option>
                                                                <option value="Zaire Nathaniel Almirante" {{ old('video_teaser_colink') == 'Zaire Nathaniel Almirante' ? 'selected' : '' }}>Zaire Nathaniel Almirante</option>
                                                            </select>
                                                        </td>

                                                        <td>
                                                            @error('video_teaser_timeline')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                            <input type="date" value="{{ old('video_teaser_timeline') }}" name="video_teaser_timeline" class="w-full p-2 border rounded">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!--MARK: Slide 6 -->
                                    <div class="slide">
                                        <h3>VI. People Involved</h3>
                                        <div class="space-y-4">
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div>
                                                    <label for="lead_faci" class="block text-sm font-medium text-gray-700 mb-1">Lead Facilitator</label>
                                                    <select id="lead_faci" name="lead_faci" class="w-full border border-gray-300 rounded-md p-2">
                                                        <option value="">Select Lead Facilitator</option>
                                                        <option value="Aimie Rumaguera" {{ old('lead_faci') == 'Aimie Rumaguera' ? 'selected' : '' }}>Aimie Rumaguera</option>
                                                        <option value="Andrey Gel Bajenting" {{ old('lead_faci') == 'Andrey Gel Bajenting' ? 'selected' : '' }}>Andrey Gel Bajenting</option>
                                                        <option value="Berminie Albacite" {{ old('lead_faci') == 'Berminie Albacite' ? 'selected' : '' }}>Berminie Albacite</option>
                                                        <option value="Fritzie Rama" {{ old('lead_faci') == 'Fritzie Rama' ? 'selected' : '' }}>Fritzie Rama</option>
                                                        <option value="Jerson Cabunilas" {{ old('lead_faci') == 'Jerson Cabunilas' ? 'selected' : '' }}>Jerson Cabunilas</option>
                                                        <option value="Jhiezel Jane Camarillo" {{ old('lead_faci') == 'Jhiezel Jane Camarillo' ? 'selected' : '' }}>Jhiezel Jane Camarillo</option>
                                                        <option value="John Adrian Anonat" {{ old('lead_faci') == 'John Adrian Anonat' ? 'selected' : '' }}>John Adrian Anonat</option>
                                                        <option value="Kathlyn Baclayon" {{ old('lead_faci') == 'Kathlyn Baclayon' ? 'selected' : '' }}>Kathlyn Baclayon</option>
                                                        <option value="Kent John Gella" {{ old('lead_faci') == 'Kent John Gella' ? 'selected' : '' }}>Kent John Gella</option>
                                                        <option value="Khevin Mamolo" {{ old('lead_faci') == 'Khevin Mamolo' ? 'selected' : '' }}>Khevin Mamolo</option>
                                                        <option value="Leendon Gelborion" {{ old('lead_faci') == 'Leendon Gelborion' ? 'selected' : '' }}>Leendon Gelborion</option>
                                                        <option value="Marianne Anselm Dela Cruz" {{ old('lead_faci') == 'Marianne Anselm Dela Cruz' ? 'selected' : '' }}>Marianne Anselm Dela Cruz</option>
                                                        <option value="Mariella Mamalias" {{ old('lead_faci') == 'Mariella Mamalias' ? 'selected' : '' }}>Mariella Mamalias</option>
                                                        <option value="Mary Jedde Ampolitod-Busa" {{ old('lead_faci') == 'Mary Jedde Ampolitod-Busa' ? 'selected' : '' }}>Mary Jedde Ampolitod-Busa</option>
                                                        <option value="Mayell Mamalias" {{ old('lead_faci') == 'Mayell Mamalias' ? 'selected' : '' }}>Mayell Mamalias</option>
                                                        <option value="Michelle Alcain" {{ old('lead_faci') == 'Michelle Alcain' ? 'selected' : '' }}>Michelle Alcain</option>
                                                        <option value="Nheil Stephen Dela Cruz" {{ old('lead_faci') == 'Nheil Stephen Dela Cruz' ? 'selected' : '' }}>Nheil Stephen Dela Cruz</option>
                                                        <option value="Paul Benedict Sariana" {{ old('lead_faci') == 'Paul Benedict Sariana' ? 'selected' : '' }}>Paul Benedict Sariana</option>
                                                        <option value="Peter Cris Rufo" {{ old('lead_faci') == 'Peter Cris Rufo' ? 'selected' : '' }}>Peter Cris Rufo</option>
                                                        <option value="Raden Remolino" {{ old('lead_faci') == 'Raden Remolino' ? 'selected' : '' }}>Raden Remolino</option>
                                                        <option value="Rica Jane Camello" {{ old('lead_faci') == 'Rica Jane Camello' ? 'selected' : '' }}>Rica Jane Camello</option>
                                                        <option value="Richard De Los Reyes" {{ old('lead_faci') == 'Richard De Los Reyes' ? 'selected' : '' }}>Richard De Los Reyes</option>
                                                        <option value="Shaine Birondo" {{ old('lead_faci') == 'Shaine Birondo' ? 'selected' : '' }}>Shaine Birondo</option>
                                                        <option value="Zaire Nathaniel Almirante" {{ old('lead_faci') == 'Zaire Nathaniel Almirante' ? 'selected' : '' }}>Zaire Nathaniel Almirante</option>
                                                    </select>
                                                    @error('lead_faci')
                                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div>
                                                    <label for="second_faci" class="block text-sm font-medium text-gray-700 mb-1">Second Facilitator</label>
                                                    <select id="second_faci" name="second_faci" value="{{ old('insurance_partner') }}" class="w-full border border-gray-300 rounded-md p-2">
                                                        <option value="">Select Second Facilitator</option>
                                                        <option value="Aimie Rumaguera" {{ old('second_faci') == 'Aimie Rumaguera' ? 'selected' : '' }}>Aimie Rumaguera</option>
                                                        <option value="Andrey Gel Bajenting" {{ old('second_faci') == 'Andrey Gel Bajenting' ? 'selected' : '' }}>Andrey Gel Bajenting</option>
                                                        <option value="Berminie Albacite" {{ old('second_faci') == 'Berminie Albacite' ? 'selected' : '' }}>Berminie Albacite</option>
                                                        <option value="Fritzie Rama" {{ old('second_faci') == 'Fritzie Rama' ? 'selected' : '' }}>Fritzie Rama</option>
                                                        <option value="Jerson Cabunilas" {{ old('second_faci') == 'Jerson Cabunilas' ? 'selected' : '' }}>Jerson Cabunilas</option>
                                                        <option value="Jhiezel Jane Camarillo" {{ old('second_faci') == 'Jhiezel Jane Camarillo' ? 'selected' : '' }}>Jhiezel Jane Camarillo</option>
                                                        <option value="John Adrian Anonat" {{ old('second_faci') == 'John Adrian Anonat' ? 'selected' : '' }}>John Adrian Anonat</option>
                                                        <option value="Kathlyn Baclayon" {{ old('second_faci') == 'Kathlyn Baclayon' ? 'selected' : '' }}>Kathlyn Baclayon</option>
                                                        <option value="Kent John Gella" {{ old('second_faci') == 'Kent John Gella' ? 'selected' : '' }}>Kent John Gella</option>
                                                        <option value="Khevin Mamolo" {{ old('second_faci') == 'Khevin Mamolo' ? 'selected' : '' }}>Khevin Mamolo</option>
                                                        <option value="Leendon Gelborion" {{ old('second_faci') == 'Leendon Gelborion' ? 'selected' : '' }}>Leendon Gelborion</option>
                                                        <option value="Marianne Anselm Dela Cruz" {{ old('second_faci') == 'Marianne Anselm Dela Cruz' ? 'selected' : '' }}>Marianne Anselm Dela Cruz</option>
                                                        <option value="Mariella Mamalias" {{ old('second_faci') == 'Mariella Mamalias' ? 'selected' : '' }}>Mariella Mamalias</option>
                                                        <option value="Mary Jedde Ampolitod-Busa" {{ old('second_faci') == 'Mary Jedde Ampolitod-Busa' ? 'selected' : '' }}>Mary Jedde Ampolitod-Busa</option>
                                                        <option value="Mayell Mamalias" {{ old('second_faci') == 'Mayell Mamalias' ? 'selected' : '' }}>Mayell Mamalias</option>
                                                        <option value="Michelle Alcain" {{ old('second_faci') == 'Michelle Alcain' ? 'selected' : '' }}>Michelle Alcain</option>
                                                        <option value="Nheil Stephen Dela Cruz" {{ old('second_faci') == 'Nheil Stephen Dela Cruz' ? 'selected' : '' }}>Nheil Stephen Dela Cruz</option>
                                                        <option value="Paul Benedict Sariana" {{ old('second_faci') == 'Paul Benedict Sariana' ? 'selected' : '' }}>Paul Benedict Sariana</option>
                                                        <option value="Peter Cris Rufo" {{ old('second_faci') == 'Peter Cris Rufo' ? 'selected' : '' }}>Peter Cris Rufo</option>
                                                        <option value="Raden Remolino" {{ old('second_faci') == 'Raden Remolino' ? 'selected' : '' }}>Raden Remolino</option>
                                                        <option value="Rica Jane Camello" {{ old('second_faci') == 'Rica Jane Camello' ? 'selected' : '' }}>Rica Jane Camello</option>
                                                        <option value="Richard De Los Reyes" {{ old('second_faci') == 'Richard De Los Reyes' ? 'selected' : '' }}>Richard De Los Reyes</option>
                                                        <option value="Shaine Birondo" {{ old('second_faci') == 'Shaine Birondo' ? 'selected' : '' }}>Shaine Birondo</option>
                                                        <option value="Zaire Nathaniel Almirante" {{ old('second_faci') == 'Zaire Nathaniel Almirante' ? 'selected' : '' }}>Zaire Nathaniel Almirante</option>
                                                    </select>
                                                    @error('second_faci')
                                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div>
                                                    <label for="third_faci" class="block text-sm font-medium text-gray-700 mb-1">Third Facilitator</label>
                                                    <select id="third_faci" name="third_faci" class="w-full border border-gray-300 rounded-md p-2">
                                                        <option value="">Select Third Facilitator</option>
                                                        <option value="Aimie Rumaguera" {{ old('third_faci') == 'Aimie Rumaguera' ? 'selected' : '' }}>Aimie Rumaguera</option>
                                                        <option value="Andrey Gel Bajenting" {{ old('third_faci') == 'Andrey Gel Bajenting' ? 'selected' : '' }}>Andrey Gel Bajenting</option>
                                                        <option value="Berminie Albacite" {{ old('third_faci') == 'Berminie Albacite' ? 'selected' : '' }}>Berminie Albacite</option>
                                                        <option value="Fritzie Rama" {{ old('third_faci') == 'Fritzie Rama' ? 'selected' : '' }}>Fritzie Rama</option>
                                                        <option value="Jerson Cabunilas" {{ old('third_faci') == 'Jerson Cabunilas' ? 'selected' : '' }}>Jerson Cabunilas</option>
                                                        <option value="Jhiezel Jane Camarillo" {{ old('third_faci') == 'Jhiezel Jane Camarillo' ? 'selected' : '' }}>Jhiezel Jane Camarillo</option>
                                                        <option value="John Adrian Anonat" {{ old('third_faci') == 'John Adrian Anonat' ? 'selected' : '' }}>John Adrian Anonat</option>
                                                        <option value="Kathlyn Baclayon" {{ old('third_faci') == 'Kathlyn Baclayon' ? 'selected' : '' }}>Kathlyn Baclayon</option>
                                                        <option value="Kent John Gella" {{ old('third_faci') == 'Kent John Gella' ? 'selected' : '' }}>Kent John Gella</option>
                                                        <option value="Khevin Mamolo" {{ old('third_faci') == 'Khevin Mamolo' ? 'selected' : '' }}>Khevin Mamolo</option>
                                                        <option value="Leendon Gelborion" {{ old('third_faci') == 'Leendon Gelborion' ? 'selected' : '' }}>Leendon Gelborion</option>
                                                        <option value="Marianne Anselm Dela Cruz" {{ old('third_faci') == 'Marianne Anselm Dela Cruz' ? 'selected' : '' }}>Marianne Anselm Dela Cruz</option>
                                                        <option value="Mariella Mamalias" {{ old('third_faci') == 'Mariella Mamalias' ? 'selected' : '' }}>Mariella Mamalias</option>
                                                        <option value="Mary Jedde Ampolitod-Busa" {{ old('third_faci') == 'Mary Jedde Ampolitod-Busa' ? 'selected' : '' }}>Mary Jedde Ampolitod-Busa</option>
                                                        <option value="Mayell Mamalias" {{ old('third_faci') == 'Mayell Mamalias' ? 'selected' : '' }}>Mayell Mamalias</option>
                                                        <option value="Michelle Alcain" {{ old('third_faci') == 'Michelle Alcain' ? 'selected' : '' }}>Michelle Alcain</option>
                                                        <option value="Nheil Stephen Dela Cruz" {{ old('third_faci') == 'Nheil Stephen Dela Cruz' ? 'selected' : '' }}>Nheil Stephen Dela Cruz</option>
                                                        <option value="Paul Benedict Sariana" {{ old('third_faci') == 'Paul Benedict Sariana' ? 'selected' : '' }}>Paul Benedict Sariana</option>
                                                        <option value="Peter Cris Rufo" {{ old('third_faci') == 'Peter Cris Rufo' ? 'selected' : '' }}>Peter Cris Rufo</option>
                                                        <option value="Raden Remolino" {{ old('third_faci') == 'Raden Remolino' ? 'selected' : '' }}>Raden Remolino</option>
                                                        <option value="Rica Jane Camello" {{ old('third_faci') == 'Rica Jane Camello' ? 'selected' : '' }}>Rica Jane Camello</option>
                                                        <option value="Richard De Los Reyes" {{ old('third_faci') == 'Richard De Los Reyes' ? 'selected' : '' }}>Richard De Los Reyes</option>
                                                        <option value="Shaine Birondo" {{ old('third_faci') == 'Shaine Birondo' ? 'selected' : '' }}>Shaine Birondo</option>
                                                        <option value="Zaire Nathaniel Almirante" {{ old('third_faci') == 'Zaire Nathaniel Almirante' ? 'selected' : '' }}>Zaire Nathaniel Almirante</option>
                                                    </select>
                                                    @error('third_faci')
                                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div>
                                                    <label for="sponsor" class="block text-sm font-medium text-gray-700 mb-1">Sponsor</label>
                                                    <input type="text" id="sponsor" name="sponsor" value="{{ old('sponsor') }}" placeholder="Enter sponsor" class="w-full border border-gray-300 rounded-md p-2">
                                                    @error('sponsor')
                                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div>
                                                <label for="vip" class="block text-sm font-medium text-gray-700 mb-1">VIPs</label>
                                                <input type="text" id="vip" name="vip" value="{{ old('vip') }}" placeholder="Enter VIPs" class="w-full border border-gray-300 rounded-md p-2">
                                                @error('vip')
                                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div>
                                                <label for="working_com" class="block text-sm font-medium text-gray-700 mb-1">Working Committee</label>
                                                <input type="text" id="working_com" name="working_com" value="{{ old('working_com') }}" placeholder="Enter working committee" class="w-full border border-gray-300 rounded-md p-2">
                                                @error('working_com')
                                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div>
                                                <label for="observers" class="block text-sm font-medium text-gray-700 mb-1">Observers</label>
                                                <input type="text" id="observers" name="observers" value="{{ old('observers') }}" placeholder="Enter observers" class="w-full border border-gray-300 rounded-md p-2">
                                                @error('observers')
                                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div class="mt-6">
                                                <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition duration-300">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    @else
        <script>
            window.location.href = "{{ route('login') }}";
        </script>
    @endif

    <script>
        lucide.createIcons();
        let currentSlide = 0;
        const totalSlides = document.querySelectorAll('.slide').length;

        function showSlide() {
            const slider = document.querySelector('.slider');
            slider.style.transform = `translateX(-${currentSlide * 100}%)`;
            updateButtons();
        }

        function nextSlide() {
            if (currentSlide < totalSlides - 1) {
                currentSlide++;
                showSlide();
            }
        }

        function prevSlide() {
            if (currentSlide > 0) {
                currentSlide--;
                showSlide();
            }
        }

        function updateButtons() {
            const leftButton = document.getElementById('leftButton');
            const rightButton = document.getElementById('rightButton');

            leftButton.disabled = currentSlide === 0;
            rightButton.disabled = currentSlide === totalSlides - 1;

            if (currentSlide === totalSlides - 1) {
                rightButton.style.display = 'none';
            } else {
                rightButton.style.display = 'block';
            }
        }

        // Initialize the first slide
        showSlide();

        // Facilitator selection logic
        const leadFaci = document.getElementById('lead_faci');
        const secondFaci = document.getElementById('second_faci');
        const thirdFaci = document.getElementById('third_faci');

        function updateFacilitatorOptions() {
            const selectedValues = [leadFaci.value, secondFaci.value, thirdFaci.value];

            [leadFaci, secondFaci, thirdFaci].forEach(select => {
                Array.from(select.options).forEach(option => {
                    if (option.value) {
                        option.disabled = selectedValues.includes(option.value) && option.value !== select.value;
                    }
                });
            });
        }

        leadFaci.addEventListener('change', updateFacilitatorOptions);
        secondFaci.addEventListener('change', updateFacilitatorOptions);
        thirdFaci.addEventListener('change', updateFacilitatorOptions);

        //For the calculating how many days in Proposed Intervention slide 4
            function calculateDays() {
            const startDate = new Date(document.getElementById('intervention_start_date').value);
            const endDate = new Date(document.getElementById('intervention_end_date').value);

            if (startDate && endDate) {
                const diffTime = Math.abs(endDate - startDate);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1; // Add 1 to include both start and end dates
                document.getElementById('intervention_days').value = diffDays;
            }
        }

        document.getElementById('intervention_start_date').addEventListener('change', calculateDays);
        document.getElementById('intervention_end_date').addEventListener('change', calculateDays);
    </script>
</body>
</html>