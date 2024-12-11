<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="min-h-screen bg-blue-900">
    <div class="p-4 flex justify-end">
    <a href="/logout" class="text-yellow-500 hover:text-yellow-400">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H3"></path>
        </svg>
    </a>
    </div>
    <div class="container mx-auto px-4">
        <div class="bg-yellow-100 rounded-lg shadow-lg overflow-hidden">
            
            <div class="md:flex">
                <!-- Left column - User info -->
                <div class="md:w-1/4 p-6 bg-yellow-200">
                    <div class="flex items-center mb-4">
                        <div class="bg-yellow-300 rounded-full w-16 h-16 flex items-center justify-center mr-4">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-blue-900">{{ $user->name }}</h2>
                            <p class="text-sm text-blue-800">{{ $user->location }}</p>
                        </div>
                    </div>
                </div>

                <!-- Right column - Main content -->
                <div class="md:w-3/4 p-6">
                    <h1 class="text-4xl font-bold text-blue-900 mb-4">Hi {{ $user->first_name }}!</h1>
                    <p class="text-xl mb-8 text-blue-800">Thank you for joining forces to help build a community full of young leaders!</p>

                   <!-- Progress tracker -->
<div class="bg-white rounded-lg p-6 shadow-inner">
    <div class="flex justify-between items-center">
        @php
            $stages = ['Contracting', 'Needs Assessment', 'Activity design', 'Intervention', 'Evaluation'];
            $currentStage = $user->current_stage;
        @endphp
        @foreach($stages as $index => $stage)
            <div class="flex flex-col items-center">
                <div class="w-8 h-8 rounded-full {{ $index < $currentStage ? 'bg-yellow-500' : 'border-2 border-gray-300' }} flex items-center justify-center mb-2">
                    @if($index < $currentStage)
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    @endif
                </div>
                <span class="text-sm text-blue-900 font-medium">{{ $stage }}</span>

                <!-- Button Container -->
                <div class="mt-2">
                    @if($index == 1)
                        <a href="/path-to-answer" class="text-blue-900 font-bold bg-yellow-500 text-white py-1 px-3 rounded hover:bg-yellow-600">ANSWER</a>
                    @elseif($index == 2)
                        <a href="/path-to-view" class="text-blue-900 font-bold bg-yellow-500 text-white py-1 px-3 rounded hover:bg-yellow-600">VIEW</a>
                    @elseif($index == 4)
                        <a href="/path-to-fillout" class="text-blue-900 font-bold bg-yellow-500 text-white py-1 px-3 rounded hover:bg-yellow-600">FILLOUT</a>
                    @endif
                </div>
            </div>

            @if($index < 4)
                <div class="flex-grow border-t-2 border-yellow-500 mx-2 mt-4"></div>
            @endif
        @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
