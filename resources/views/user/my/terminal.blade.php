<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-...." crossorigin="anonymous" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    @vite(['resources/css/user.css','resources/js/user.js'])
    <title>Tagged as Terminal</title>
</head>

<body class="bg-slate-100">
<!-- Top-bar Navigation -->
<div class="bg-white h-16 p-5 md:p-2 flex flex-row md:flex-row items-center justify-between">
    <!-- Logo and Home Container -->
    <div class="flex flex-row md:flex-row items-center">
        <img src="{{ asset('images/PLM_LOGO.png') }}" alt="PLM Logo" class="ml-4 w-14 h-14">
        <h2 class="text-4xl md:text-4xl font-bold text-indigo-800 mr-20">
            <a href="{{route('user-dashboard')}}" class="ml-4">DRS</a>
        </h2>
    </div>

    <!-- Date and Time -->
    <div class="flex items-center">
        <h2 id="realTime" class="text-xl font-bold text-indigo-800"></h2>
    </div>

    <!-- Notifications -->
    <div class="notification-container relative inline-block">
        @php
            $unreadCount = \App\Models\Notification::where('user_id', auth()->id())
                ->whereNull('read_at')
                ->count();
            $notifications = \App\Models\Notification::where('user_id', auth()->id())
                ->orderBy('triggered_at', 'desc')
                ->take(5)
                ->get();
        @endphp
        <button class="notification-button relative" onclick="toggleDropdown()">
            <span class="material-icons-sharp text-2xl">notifications</span>
            @if ($unreadCount > 0)
                <span class="notification-dot absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
            @endif
        </button>
        <div class="notification-dropdown overflow-auto hidden absolute w-64 rounded-lg border-2 bg-white shadow-lg min-w-max z-10">
            <!-- Mark as Read Button -->
            <div class="text-right px-4 hover:bg-zinc-200">
                <form id="mark-as-read-form" action="{{ route('notifications.markAsRead') }}" method="POST">
                    @csrf
                    @foreach ($notifications as $notification)
                        <input type="hidden" name="notification_ids[]" value="{{ $notification->id }}">
                    @endforeach
                    <button type="submit" class="text-xs text-blue-600 hover:underline focus:outline-none">Mark all as Read</button>
                </form>
            </div>
            <div class="py-1 divide-y divide-dotted" id="notification-list">
                @foreach ($notifications as $notification)
                    <!-- Notification Content -->
                    <div class="px-4 py-2 text-sm text-gray-700 hover:bg-zinc-200 {{ is_null($notification->read_at) ? 'text-red-600' : 'text-indigo-600' }}">
                        <form id="mark-as-read-form" action="{{ route('notifications.markRead') }}" method="POST">
                            @csrf
                            <input type="hidden" name="notification_ids[]" value="{{ $notification->id }}">
                        <!-- Notification Text -->
                        <p class="text-xs text-right">{{ $notification->triggered_at->diffForHumans() }}</p>
                        @php
                            $notificationData = is_array($notification->data) ? $notification->data : json_decode($notification->data, true);
                        @endphp
                        <p>{{ $notificationData['tracking_number'] }} - {{ $notificationData['title'] }}</p>
                        <p>{{ $notification->type}} - {{ $notification->action }}</p>
                        <div class="text-center px-4">
                        <button type="submit" class="text-xs text-blue-600 hover:underline focus:outline-none">Mark as read</button>
                        </div>
                        </form>
                    </div>
                @endforeach
                <!-- View Office Documents Link -->
                <a href="{{ route('user-office-docs') }}" class="block text-center px-4 py-1 text-sm text-gray-700 hover:bg-gray-100 hover:underline focus:outline-none">View Office Documents</a>
            </div>
        </div>
    </div>

    <!-- User Container -->
    <div class="ml-2 top-0 right-20 flex items-center">
        <span class="material-icons-sharp text-6xl">person_outline</span>
        <h2 class="text-xl md:text-2xl font-bold ml-2">{{ auth()->user()->name }}</h2>
    </div>

    <!-- Dropdown -->
    <div class="relative inline-block ml-10 top-0 right-0">
        <button class="dropbtn bg-white text-black p-3 text-sm border-none">
            <span class="material-icons-sharp">arrow_drop_down</span>
        </button>
        <div class="dropdown-content hidden absolute bg-gray-200 right-0 rounded-md w-32 text-right shadow-lg z-10">
            <h2 class="text-black p-2 block hover:bg-gray-300">{{ auth()->user()->email }}</h2>
            <h2 class="text-black p-2 block hover:bg-gray-300">{{ auth()->user()->office->code }}</h2>
            <h2 class="text-black p-2 block hover:bg-gray-300">Regular User</h2>
        </div>
    </div>
</div>
<!-- Side-bar Navigation -->
<div class="flex h-screen">
    <div class="bg-indigo-800 shadow-lg text-white w-[250px]">
        <div>
            <ul class="mt-8">
                <div class="flex bg-indigo-800 hover:bg-indigo-900 w-full">
                    <span class="material-icons-sharp mx-3">
                        folder_open
                    </span>
                    <h2 class="font-bold">
                    <a href="{{route('user-office-docs')}}" class="text-md ">Office Documents</a></h2>
                </div>
                <li class="relative text-xs px-12 py-1 bg-indigo-800 hover:bg-indigo-900 w-full">
                    <a href="{{route('user-for-receiving')}}">
                        <span class="flex items-center justify-between ">
                            <span>For receiving</span>
                            <span class="ml-2">
                                <svg class="h-5 w-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                    <path d="M9 5l7 7-7 7"></path>
                                </svg>
                            </span>
                        </span>
                    </a>
                </li>
                <li class="relative text-xs px-12 py-1 bg-indigo-800 hover:bg-indigo-900 w-full">
                    <a href="{{route('user-for-releasing')}}">
                        <span class="flex items-center justify-between ">
                            <span>For releasing</span>
                            <span class="ml-2">
                                <svg class="h-5 w-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                    <path d="M9 5l7 7-7 7"></path>
                                </svg>
                            </span>
                        </span>
                    </a>
                </li>
                <li class="relative text-xs px-12 py-1 bg-indigo-800 hover:bg-indigo-900 w-full">
                    <a href="{{route('user-office-terminal')}}">
                        <span class="flex items-center justify-between ">
                            <span>Tagged as Terminal</span>
                            <span class="ml-2">
                                <svg class="h-5 w-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                    <path d="M9 5l7 7-7 7"></path>
                                </svg>
                            </span>
                        </span>
                    </a>
                </li>
                <li class="relative text-xs px-12 py-1 bg-indigo-800 hover:bg-indigo-900 w-full">
                    <a href="{{route('user-office-reports')}}">
                        <span class="flex items-center justify-between ">
                            <span>Office Reports</span>
                            <span class="ml-2">
                                <svg class="h-5 w-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                    <path d="M9 5l7 7-7 7"></path>
                                </svg>
                            </span>
                        </span>
                    </a>
                </li>
                <li class="relative text-xs px-12 py-1 bg-indigo-800 hover:bg-indigo-900 w-full">
                    <a href="{{route('user-office-guides')}}">
                        <span class="flex items-center justify-between ">
                            <span>DRS Users</span>
                            <span class="ml-2">
                                <svg class="h-5 w-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                    <path d="M9 5l7 7-7 7"></path>
                                </svg>
                            </span>
                        </span>
                    </a>
                </li>
                <a href="{{route('user-my-docs')}}" class="flex mt-8 bg-indigo-800 hover:bg-indigo-900 w-full">
                    <span class="material-icons-sharp mx-3">
                        folder_shared
                    </span>
                    <h2 class="font-bold ml-0">My Documents</h2>
                </a>
                <li class="relative text-xs px-12 py-1 bg-indigo-800 hover:bg-indigo-900 w-full">
                    <a href="{{route('user-my-received')}}">
                        <span class="flex items-center justify-between ">
                            <span>Received</span>
                            <span class="ml-2">
                                <svg class="h-5 w-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                    <path d="M9 5l7 7-7 7"></path>
                                </svg>
                            </span>
                        </span>
                    </a>
                </li>
                <li class="relative text-xs px-12 py-1 bg-indigo-800 hover:bg-indigo-900 w-full">
                    <a href="{{route('user-my-released')}}">
                        <span class="flex items-center justify-between ">
                            <span>Released</span>
                            <span class="ml-2">
                                <svg class="h-5 w-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                    <path d="M9 5l7 7-7 7"></path>
                                </svg>
                            </span>
                        </span>
                    </a>
                </li>
                <li class="relative text-xs px-12 py-1 bg-indigo-900 w-full">
                    <a href="{{route('user-my-terminal')}}">
                        <span class="flex items-center justify-between ">
                            <span>Tagged as Terminal</span>
                            <span class="ml-2">
                                <svg class="h-5 w-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                    <path d="M9 5l7 7-7 7"></path>
                                </svg>
                            </span>
                        </span>
                    </a>
                </li>
                <li class="relative text-xs px-12 py-1 bg-indigo-800 hover:bg-indigo-900 w-full">
                    <a href="{{route('user-my-numbers')}}">
                        <span class="flex items-center justify-between ">
                            <span>My Tracking Numbers</span>
                            <span class="ml-2">
                                <svg class="h-5 w-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                    <path d="M9 5l7 7-7 7"></path>
                                </svg>
                            </span>
                        </span>
                    </a>
                </li>
                <li class="relative text-xs px-12 py-1 bg-indigo-800 hover:bg-indigo-900 w-full">
                    <a href="{{route('user-my-reports')}}">
                        <span class="flex items-center justify-between ">
                            <span>My Reports</span>
                            <span class="ml-2">
                                <svg class="h-5 w-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                    <path d="M9 5l7 7-7 7"></path>
                                </svg>
                            </span>
                        </span>
                    </a>
                </li>
                <li class="relative pt-32">
                    <a href="{{route('user-settings')}}" class="flex items-center gap-x-2 text-sm px-12 py-1 bg-indigo-800 hover:bg-indigo-900 w-full">
                        <span class="material-icons-sharp text-base">
                            settings
                        </span>
                        <span>Settings</span>
                    </a>
                </li>
                <li class="relative">
                    <a href="javascript:void(0);" onclick="confirmLogout('/logout')" class="flex items-center gap-x-2 text-sm px-12 py-1 bg-indigo-800 hover:bg-indigo-900 w-full">
                        <span class="material-icons-sharp text-base">
                            logout
                        </span>
                        <span>Logout</span>
                    </a>
                </li>
                <li class="relative">
                    <a href="{{route('user-guides')}}" class="flex items-center gap-x-2 text-sm px-12 py-1 bg-indigo-800 hover:bg-indigo-900 w-full">
                        <span class="material-icons-sharp text-base">
                            question_mark
                        </span>
                        <span>DRS Guide</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
<!-- Main Content -->
@if (session('messege'))
<div class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-2xl leading-6 font-medium text-green-600" id="modal-title">
                            Notifications
                        </h3>
                        <div class="mt-2">
                            <p class="text-md text-gray-500">{{ session('messege') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm" onclick="closeModal()">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>
@endif
        <div class="flex flex-auto flex-col">
            <div class="flex bg-white mt-8 rounded-md shadow-md shadow-slate-500 mx-10 w-[1200px]">
                <div class="flex px-2 m-4">
                    <div class="row-start-1 row-span-2">
                        <h2 class="text-indigo-800 font-bold text-4xl">Tagged as Terminal</h2>
                        <h4 class="text-indigo-800 font-semibold text-sm"><a href="{{route('user-my-docs')}}" class="text-sm text-black">My Documents </a><a href="{{route('user-my-terminal')}}"> > Tagged as Terminal</a></h4>
                    </div>
                    <form action="{{route('user-my-terminal')}}" method="GET" class="flex items-center ml-20">
                        <div class="relative">
                            <input class="rounded-full bg-slate-300 text-black h-8 w-64 px-10 pr-4 border border-black shadow-md shadow-slate-500" type="text" name="search" placeholder="Search for a ...">
                            <span class="material-icons-sharp absolute inset-y-0 left-1 ml-1 mt-1 text-black">
                                search
                            </span>
                        </div>
                        <select name="category" class="ml-6 p-1 h-8 w-auto border border-black rounded-r bg-slate-300 text-black shadow-md shadow-slate-500">
                            <option value="tracking_number" class="bg-slate-200 text-black">Tracking Number</option>
                            <option value="originating_office" class="bg-slate-200 text-black">Originating Office</option>
                            <option value="current_office" class="bg-slate-200 text-black">Last Office</option>
                            <option value="title" class="bg-slate-200 text-black">Document Title</option>
                            <option value="type" class="bg-slate-200 text-black">Document Type</option>
                            <option value="action" class="bg-slate-200 text-black">Latest Action</option>
                            <option value="remarks" class="bg-slate-200 text-black">Latest Remarks</option>
                        </select>
                        <select name="order" class="ml-6 p-1 h-8 w-auto border border-black rounded-r bg-slate-300 text-black shadow-md shadow-slate-500">
                            <option value="asc" class="bg-slate-200 text-black">Ascending</option>
                            <option value="desc" class="bg-slate-200 text-black">Descending</option>
                        </select>
                        <button type="submit" class="ml-12 p-1 h-8 w-auto border border-black rounded-md bg-slate-300 text-black shadow-md shadow-slate-500">
                            Search
                        </button>
                    </form>
                </div>
            </div>
            <div class="bg-white mt-8 rounded-md shadow-md shadow-slate-500 justify-center mx-10 w-[1200px] h-4/6">
                <div class="overflow-auto self-center text-center m-8 h-[79%] rounded-md shadow-md shadow-slate-500">
                    @if ($documents->isEmpty())
                    <div class="flex flex-col items-center justify-center h-full">
                        <img src="{{ asset('images/blank-page.svg') }}" alt="No Documents" class="text-slate-300 w-32 h-32 mb-4">
                        <p class="text-center text-lg font-bold text-red-600">You don't have "Tagged as Terminal" Documents at the moment. Check the Following: </p>
                        <div class="flex justify-center flex-col">
                            <h1 class="text-start text-lg font-bold text-red-600"><a href="{{ route('user-office-docs') }}">-> Office Documents</a></h1>
                            <h1 class="text-start text-lg font-bold text-red-600"><a href="{{ route('user-for-releasing') }}">-> For Releasing</a></h1>
                            <h1 class="text-start text-lg font-bold text-red-600"><a href="{{ route('user-my-docs') }}">-> My Documents</a></h1>
                            <h1 class="text-start text-lg font-bold text-red-600"><a href="{{ route('user-my-received') }}">-> Received</a></h1>
                        </div>
                    </div>
                    @else
                    <table class="divide-y divide-gray-200 w-full h-full">
                        <thead class="bg-indigo-800 text-white sticky top-0 inset-0">
                            <tr>
                                <th scope="col" class="border border-black">Tracking Number</th>
                                <th scope="col" class="border border-black">Originating Office</th>
                                <th scope="col" class="border border-black">Last Office</th>
                                <th scope="col" class="border border-black">Document Title</th>
                                <th scope="col" class="border border-black">Document Type</th>
                                <th scope="col" class="border border-black">Latest Action</th>
                                <th scope="col" class="border border-black">Latest Remarks</th>
                                <th scope="col" class="border border-black">View</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($documents as $document)
                                <tr class="bg-white text-black h-12">
                                    <td class="border border-black">{{ $document->tracking_number }}</td>
                                    <td class="border border-black">{{ $document->originating_office }}</td>
                                    <td class="border border-black">{{ $document->current_office }}</td>
                                    <td class="border border-black">{{ $document->title }}</td>
                                    <td class="border border-black">{{ $document->type }}</td>
                                    <td class="border border-black">{{ $document->action }}</td>
                                    <td class="border border-black">{{ $document->remarks }}</td>
                                    <td class="border border-black">
                                        <form action="{{ route('view', $document->tracking_number) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="size-11/12 p-1 font-bold text-white rounded-md bg-[#bf9b30] hover:bg-[#8C6B0A]">
                                                View
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
                <div class="mt-4">
                    {{ $documents->appends(['search' => request('search'), 'category' => request('category'), 'order' => request('order')])->links('vendor.pagination.tailwind') }}
                </div>
            </div>
        </div>
    </div>
<!-- Script goes here!! -->
    <script>
        src="{{ asset('js/user.js') }}"
        function confirmLogout(url) {
            if (confirm('Are you sure you want to Logout?')) {
                window.location.href = url;
            }
        }
        function updateTime() {
            const now = new Date();
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric', second: 'numeric' };
            const realTime = now.toLocaleString('en-US', options);
            document.getElementById('realTime').textContent = realTime;
        }

        // Update every second
        setInterval(updateTime, 1000);
        function closeModal() {
            document.querySelector('.fixed.z-10.inset-0.overflow-y-auto').style.display = 'none';
        }

        function toggleDropdown() {
            const dropdown = document.querySelector('.notification-dropdown');
            dropdown.classList.toggle('hidden');
        }

        function markNotificationsAsRead(notificationIds) {
            const form = document.getElementById('mark-as-read-form');
            form.notification_ids.value = notificationIds.join(',');
            form.submit();
        }
    </script>
</body>
</html>
