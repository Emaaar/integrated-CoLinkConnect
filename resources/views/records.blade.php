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
            margin: 0;
            font-family: 'Inter', sans-serif;
            background-color: #f5f5f5;
        }

        .header {
            background-color: #1a1a1a;
            color: white;
            padding: 1rem 2rem;
        }

        .header h1 {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 500;
        }

        .content {
            padding: 2rem;
        }

        .content h2 {
            margin: 0 0 1rem 0;
            font-size: 1.8rem;
            color: #1a1a1a;
        }

        .records-info {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
        }

        .controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .filter-section {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .filter-label {
            color: #666;
        }

        .filter-dropdown {
            padding: 0.5rem 1rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: white;
            font-size: 0.875rem;
            cursor: pointer;
        }

        .filter-dropdown:hover {
            border-color: #bbb;
        }

        .filter-dropdown:focus {
            outline: none;
            border-color: #4F46E5;
            box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.2);
        }

        .search-section {
            display: flex;
            gap: 1rem;
        }

        .search-input {
            padding: 0.5rem 1rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: 300px;
        }

        .create-button {
            background-color: #4F46E5;
            color: white;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
            text-decoration: none;
        }

        .create-button:hover {
            background-color: #4338CA;
        }

        .records-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }

        .record-card {
            background: white;
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .record-header {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }

        .record-avatar {
            width: 48px;
            height: 48px;
            background-color: #e5e7eb;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 500;
            font-size: 1.125rem;
            margin-right: 1rem;
        }

        .record-title {
            flex-grow: 1;
        }

        .record-name {
            font-weight: 500;
            margin-bottom: 0.25rem;
        }

        .record-category {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            background-color: #EEF2FF;
            color: #4F46E5;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .record-details {
            margin-top: 1rem;
            font-size: 0.875rem;
        }

        .record-details h3 {
            font-size: 1rem;
            margin: 1rem 0 0.5rem;
        }

        .record-details p {
            margin: 0.25rem 0;
            color: #4B5563;
        }

        .record-actions {
            margin-top: 1rem;
            display: flex;
            gap: 0.5rem;
        }

        .action-button {
            padding: 0.5rem 1rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            background: white;
            cursor: pointer;
            font-size: 0.875rem;
        }

        .action-button:hover {
            background-color: #f5f5f5;
        }
        .delete-button {
            background: none;
            border: none;
            cursor: pointer;
            color: #ef4444;
            padding: 5px;
            border-radius: 50%;
            transition: background-color 0.3s;
        }

        .delete-button:hover {
            background-color: #fee2e2;
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
        <aside class="bg-white shadow-md w-64 flex flex-col h-screen">
    <div class="p-6">
        <h1 class="text-2xl font-bold text-blue-700">Dashboard</h1>
    </div>
    <nav class="flex-grow mt-4 px-4">
        @php
        $sidebarLinks = [
            ['icon' => 'home', 'label' => 'Data Analysis', 'route' => 'dashboard'],
            ['icon' => 'file-text', 'label' => 'Contracting', 'route' => 'contracting'],
            ['icon' => 'file-text', 'label' => 'Records', 'route' => 'records'],
            ['icon' => 'mail', 'label' => 'Messages', 'route' => 'admin.chat'],
            ['icon' => 'book-open', 'label' => 'Blog', 'route' => 'blog'],
        ];
        @endphp

        @foreach($sidebarLinks as $link)
        <a href="{{ route($link['route']) }}"
            class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors duration-200 hover:bg-blue-50 hover:text-blue-600 {{ request()->routeIs($link['route']) ? 'bg-blue-50 text-blue-600' : 'text-gray-700' }}">
            <i data-lucide="{{ $link['icon'] }}" class="w-5 h-5"></i>
            <span>{{ $link['label'] }}</span>
        </a>
        @endforeach
    </nav>
    <div class="p-4">
        <form id="logout-form" action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                class="w-full flex items-center space-x-3 px-4 py-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors duration-200">
                <i data-lucide="log-out" class="w-5 h-5"></i>
                <span>Logout</span>
            </button>
        </form>
    </div>
</aside>


        <!-- Main Content -->
        <div class="flex-grow p-6 overflow-y-auto">
        <div class="content">
        <h2>Manage Records</h2>
        <div class="records-info">Showing {{ count($records) }} records</div>

        <div class="controls">
            <div class="filter-section">
                <label for="category-filter" class="filter-label">Filter by progress:</label>
                <select id="category-filter" class="filter-dropdown">
                    <option value="all" selected>All</option>
                    <option value="processing">Processing</option>
                    <option value="pending">Pending</option>
                    <option value="done">Done</option>
                </select>
            </div>

            <div class="search-section">
                <input type="text" class="search-input" placeholder="Search records...">
                <a href="{{ route('contracting') }}" class="create-button">Create Contract</a>
            </div>
        </div>

        <div class="records-grid">
            @foreach($records as $record)
            <div class="record-card" data-contract-num="{{ $record->contract_num }}">
                <div class="record-header">
                    <div class="record-avatar">
                        {{ strtoupper(substr($record->org_name, 0, 2)) }}
                    </div>
                    <div class="record-title">
                        <div class="record-name">{{ $record->org_name }}</div>
                        <span class="record-category">{{ $record->category }}</span>
                    </div>
                    <button
                        class="delete-button"
                        onclick="deleteRecord('{{ $record->contract_num }}')"
                        aria-label="Delete record"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 6h18"></path>
                            <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                            <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                        </svg>
                    </button>
                </div>

                <div class="record-details">
                    <p><strong>Date created:</strong> {{ $record->date_recorded }}</p>
                    <p><strong>Partner:</strong> {{ $record->org_name }}</p>
                    <p><strong>Coordinator:</strong> {{ $record->coor_name }}</p>

                    @if($record->proposed_intervention->isNotEmpty())
                        <h3>Intervention Details</h3>
                        <p>Type: {{ $record->proposed_intervention->first()->type_intervention }}</p>
                        <p>Start: {{ $record->proposed_intervention->first()->startdate }}</p>
                        <p>Duration: {{ $record->proposed_intervention->first()->days }} days</p>
                    @endif

                    @if($record->people_involve->isNotEmpty())
                        <h3>Lead Facilitator</h3>
                        <p>{{ $record->people_involve->first()->leadfaci }}</p>
                    @endif
                </div>

                <div class="record-actions">
                    <a href="{{ route('records.show', $record->contract_num) }}" class="action-button">
                        View Details
                    </a>
                    {{-- <button class="action-button" onclick="window.location.href='/records/{{ $record->contract_num }}'">
                        View Details
                    </button> --}}
                    {{-- <button class="action-button">Edit</button> --}}
                    {{-- MARK: diri e butang status sa contract --}}
                    @if($record->is_done)
                        <span class="record-category">Done</span>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <script>
        // Add your JavaScript functionality here
        document.getElementById('category-filter').addEventListener('change', function() {
            // Add filtering logic here
            console.log('Selected category:', this.value);
        });

        function deleteRecord(contractNum) {
            if (confirm('Are you sure you want to delete this record?')) {
                fetch(`/records/${contractNum}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const card = document.querySelector(`[data-contract-num="${contractNum}"]`);
                        if (card) {
                            card.remove();
                            // Update the record count
                            const recordsInfo = document.querySelector('.records-info');
                            const currentCount = parseInt(recordsInfo.textContent.match(/\d+/)[0]);
                            recordsInfo.textContent = `Showing ${currentCount - 1} records`;
                            alert('Record deleted successfully');
                        } else {
                            console.error('Card element not found');
                            alert('Record deleted successfully, but UI update failed. Please refresh the page.');
                        }
                    } else {
                        throw new Error(data.message || 'Failed to delete record');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while deleting the record: ' + error.message);
                });
            }
        }
    </script>
</body>
</html>