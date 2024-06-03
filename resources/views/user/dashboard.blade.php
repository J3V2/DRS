<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-...." crossorigin="anonymous" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    @vite(['resources/css/user.css','resources/js/user.js'])
    <title>Dashboard</title>
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
                    ->get();
            @endphp
            <button class="notification-button relative" onclick="toggleDropdown()">
                <span class="material-icons-sharp text-2xl">notifications</span>
                @if ($unreadCount > 0)
                    <span class="notification-dot absolute top-0 right-0 w-4 h-4 bg-red-500 rounded-full flex items-center justify-center text-white text-xs">{{$unreadCount}}</span>
                @endif
            </button>
            <div class="notification-dropdown overflow-auto hidden absolute w-80 max-h-96 rounded-lg border-2 bg-white shadow-lg min-w-max z-10">
                <!-- Mark as Read Button -->
                <div class="text-right px-4 py-2 hover:bg-zinc-200">
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
                        <div class="overflow-y-auto px-4 py-2 text-sm text-gray-700 hover:bg-zinc-200 {{ is_null($notification->read_at) ? 'text-red-600' : 'text-indigo-600' }}">
                            <form id="mark-as-read-form" action="{{ route('notifications.markRead') }}" method="POST">
                                @csrf
                                <input type="hidden" name="notification_ids[]" value="{{ $notification->id }}">
                                <!-- Notification Text -->
                                <p class="text-xs text-right">{{ $notification->triggered_at->diffForHumans() }}</p>
                                @php
                                    $notificationData = is_array($notification->data) ? $notification->data : json_decode($notification->data, true);
                                @endphp
                                <p class="truncate">{{ $notificationData['tracking_number'] ?? auth()->user()->name }} - {{ $notificationData['title'] ?? auth()->user()->email }}</p>
                                <p>{{ is_null($notification->type) ? '' : $notification->type }}</p>
                                <p>{{ is_null($notification->action) ? '' : $notification->action }}</p>
                                <p>{{ $notificationData['event_type'] }}</p>
                                <div class="text-center px-4">
                                    <button type="submit" class="text-xs text-blue-600 hover:underline focus:outline-none">Mark as read</button>
                                </div>
                            </form>
                        </div>
                    @endforeach
                    <!-- View Office Documents Link -->
                    <a href="{{ route('user-office-docs') }}" class="block text-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:underline focus:outline-none sticky bottom-0 bg-white border-t-2 border-gray-200">View Office Documents</a>
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
        <div class="w-52 bg-indigo-800 shadow-lg text-white w-[250px]">
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
                    <li class="relative text-xs px-12 py-1 bg-indigo-800 hover:bg-indigo-900 w-full">
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
        <!-- Pop-Up Messages -->
        @if (session('error'))
        <div class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-2xl leading-6 font-medium text-red-600" id="modal-title">
                                    Error
                                </h3>
                                <div class="mt-2">
                                    <p class="text-md text-gray-500">{{ session('error') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm" onclick="closeModal()">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endif

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

        <div class="flex flex-auto flex-row justify-around">
            <div class="flex flex-wrap flex-col w-4/12 h-5/6 bg-white rounded-md p-4 my-8 shadow-2xl shadow-indigo-800">
                <div class="w-full self-center text-center mt-2 mb-2">
                    @if ($unusedTrackingNumbers)
                    <form action="{{route('drs-add')}}" method="get">
                        @csrf
                        <h2 class="text-xl font-bold text-indigo-800 mb-2 border-b-2 text-start border-indigo-800 w-auto">
                            Add Document
                        </h2>
                        <div class="bg-indigo-100 rounded border border-indigo-400 flex items-center w-auto">
                            <input type="text" id="tracking_number" name="tracking_number" value="{{ $unusedTrackingNumbers->tracking_number ?? '' }}" placeholder="XXXX-XXXX-XXXX-XXXX" class="bg-transparent py-1 text-black px-4 focus:outline-none w-full" readonly />
                            <button type="submit" class="w-40 py-2 inline-flex items-center justify-center bg-indigo-600 text-white font-bold rounded-r border-r border-indigo-700 hover:bg-indigo-800 active:bg-indigo-300 disabled:opacity-50">
                                <span class="material-icons-sharp font-bold inline-block align-middle mr-2">
                                    add
                                </span>
                                Add
                            </button>
                        </div>
                    </form>
                    @else
                    <h2 class="text-xl font-bold text-indigo-800 mb-2 border-b-2 text-start border-indigo-800 w-auto">
                        Generate Tracking Numbers
                    </h2>
                    <div class="bg-indigo-100 rounded border border-indigo-400 flex items-center w-auto">
                        <input type="text" id="tracking_number" name="tracking_number" placeholder="No Tracking Number Left..." class="bg-transparent py-1 text-black px-4 focus:outline-none w-full" readonly />
                        <a href="{{route('user-my-numbers')}}">
                        <button type="submit" class="w-40 py-2 inline-flex items-center justify-center bg-indigo-600 text-white font-bold rounded-r border-r border-indigo-700 hover:bg-indigo-800 active:bg-indigo-300 disabled:opacity-50">
                            <span class="material-icons-sharp inline-block align-middle mr-2">
                                view_week
                            </span>
                            Generate
                        </button>
                        </a>
                    </div>
                    @endif
                </div>
                <div class="h-auto w-full self-center text-center mt-2 mb-2">
                    <form action="{{route('receive')}}" method="get">
                    @csrf
                        <h2 class="text-xl font-bold text-indigo-800 mb-2 border-b-2 text-start border-indigo-800 w-auto">
                            Receive Document
                        </h2>
                        <div class="bg-indigo-100 rounded border border-indigo-400 flex items-center w-full">
                            <input type="text" id="tracking_number" name="tracking_number" placeholder="Tracking Number" class="bg-transparent py-1 text-black px-4 focus:outline-none w-full" />
                            <button class="w-40 py-2 inline-flex items-center justify-center bg-indigo-600 text-white font-bold rounded-r border-r border-indigo-700 hover:bg-indigo-800 active:bg-indigo-300 disabled:opacity-50">
                                <span class="material-icons-sharp inline-block align-middle mr-2">
                                    get_app
                                </span>
                                Receive
                            </button>
                        </div>
                    </form>
                </div>
                <div class="h-auto w-full self-center text-center mt-2 mb-2">
                    <form action="{{ route('release') }}" method="POST">
                    @csrf
                        <h2 class="text-xl font-bold text-indigo-800 mb-2 border-b-2 text-start border-indigo-800 w-auto">
                            Release Document
                        </h2>
                        <div class="bg-indigo-100 rounded border border-indigo-400 flex items-center w-full">
                            <input type="text" id="tracking_number" name="tracking_number" placeholder="Tracking Number" class="bg-transparent py-1 text-black px-4 focus:outline-none w-full" />
                            <button class="w-40 py-2 inline-flex items-center justify-center bg-indigo-600 text-white font-bold rounded-r border-r border-indigo-700 hover:bg-indigo-800 active:bg-indigo-300 disabled:opacity-50">
                                <span class="material-icons-sharp inline-block align-middle mr-2">
                                    publish
                                </span>Release
                            </button>
                        </div>
                    </form>
                </div>
                <div class="h-auto w-full self-center text-center mt-2 mb-2">
                    <form action="{{route('track')}}" method="get">
                    @csrf
                        <h2 class="text-xl font-bold text-indigo-800 mb-2 border-b-2 text-start border-indigo-800 w-auto">
                            Track Document
                        </h2>
                        <div class="bg-indigo-100 rounded border border-indigo-400 flex items-center w-full">
                            <input type="text" id="tracking_number" name="tracking_number" placeholder="Tracking Number" class="bg-transparent py-1 text-black px-4 focus:outline-none w-full" />
                            <button class="w-40 py-2 inline-flex items-center justify-center bg-indigo-600 text-white font-bold rounded-r border-r border-indigo-700 hover:bg-indigo-800 active:bg-indigo-300 disabled:opacity-50">
                                <span class="material-icons-sharp inline-block align-middle mr-2">
                                    my_location
                                </span>
                                Track
                            </button>
                        </div>
                    </form>
                </div>
                <div class="h-auto w-full self-center text-center mt-4 mb-4">
                    <form action="{{route('tag')}}" method="POST">
                    @csrf
                        <h2 class="text-xl font-bold text-indigo-800 mb-2 border-b-2 text-start border-indigo-800 w-auto">
                            Tag as Terminal
                        </h2>
                        <div class="bg-indigo-100 rounded border border-indigo-400 flex items-center w-full">
                            <input type="text" id="tracking_number" name="tracking_number" placeholder="Tracking Number" class="bg-transparent py-1 text-black px-4 focus:outline-none w-full" />
                            <button class="w-40 py-2 inline-flex items-center justify-center bg-indigo-600 text-white font-bold rounded-r border-r border-indigo-700 hover:bg-indigo-800 active:bg-indigo-300 disabled:opacity-50">
                                <span class="material-icons-sharp inline-block align-middle mr-2">
                                    download_done
                                </span>
                                Terminal
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="w-[700px] h-[700px] bg-white rounded-md p-4 my-8 shadow-2xl shadow-indigo-800">
                <div class="h-auto w-full self-center text-center mt-2 mb-2">
                    <div class="flex justify-center text-xl font-bold text-indigo-800 mb-2 w-auto">
                        <h2 class="border-b-2 border-indigo-800 w-full">
                            Documents
                        </h2>
                    </div>
                    <div class="overflow-auto max-h-[280px]">
                        <div class="text-start bg-gray-300 mb-4 sticky inset-0">
                            <h2 class="text-md font-bold text-indigo-800">
                                <a href="{{route('user-for-receiving')}}" class="ml-6">
                                    For Receive:
                                </a>
                            </h2>
                        </div>
                        @if (count($forReceive) > 0)
                        <div class="flex justify-center w-auto h-auto grid grid-flow-row grid-cols-2 grid-rows-2 gap-x-2 gap-y-4">
                            @foreach ($forReceive as $document)
                            <div class="bg-indigo-300 rounded-md text-start h-auto p-1">
                                <h1 class="text-sm text-black font-medium ml-1.5">
                                    Tracking Number: {{ $document->tracking_number }}
                                </h1>
                                </h1>
                                <h1 class="text-sm text-black font-medium ml-1.5">
                                    From: {{ $document->originating_office }}
                                </h1>
                                <div class="text-end">
                                    <h1 class="text-xs text-indigo-900 hover:text-indigo-500 font-medium"">
                                        <a href="{{route('user-for-receiving')}}" class="font-bold">
                                            For Receiving
                                        </a>
                                    </h1>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="flex flex-col items-center justify-center h-full">
                            <img src="{{ asset('images/blank-page.svg') }}" alt="No Documents" class="text-slate-300 w-32 h-32 mb-4">
                            <p class="text-center text-lg font-bold text-red-600">There are no Documents at the moment in your Office.</p>
                        </div>
                        @endif
                    </div>
                    <div class="overflow-auto max-h-[300px] mt-8">
                        <div class="text-start bg-gray-300 mb-4 sticky inset-0">
                            <h2 class="text-md font-bold text-indigo-800">
                                <a href="{{route('user-for-releasing')}}" class="ml-6">
                                    For Release:
                                </a>
                            </h2>
                        </div>
                        @if (count($forRelease) > 0)
                        <div class="flex justify-center w-auto h-auto grid grid-flow-row grid-cols-2 grid-rows-2 gap-x-2 gap-y-4">
                            @foreach ($forRelease as $document)
                            <div class="bg-indigo-300 rounded-md text-start h-auto p-1">
                                <h1 class="text-sm text-black font-medium ml-1.5">
                                    Tracking Number: {{ $document->tracking_number }}
                                </h1>
                                </h1>
                                <h1 class="text-sm text-black font-medium ml-1.5">
                                    From: {{ $document->originating_office }}
                                </h1>
                                <div class="text-end">
                                    <h1 class="text-xs text-indigo-900 hover:text-indigo-500 font-medium">
                                        <a href="{{route('user-for-releasing')}}" class="font-bold">
                                            For Releasing
                                        </a>
                                    </h1>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="flex flex-col items-center justify-center h-full">
                            <img src="{{ asset('images/blank-page.svg') }}" alt="No Documents" class="text-slate-300 w-32 h-32 mb-4">
                            <p class="text-center text-lg font-bold text-red-600">There are no Documents at the moment in your Office.</p>
                        </div>
                        @endif
                    </div>
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

        function closeModal() {
            document.querySelector('.fixed.z-10.inset-0.overflow-y-auto').style.display = 'none';
        }

        function updateTime() {
            const now = new Date();
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric', second: 'numeric' };
            const realTime = now.toLocaleString('en-US', options);
            document.getElementById('realTime').textContent = realTime;
        }

        // Update every second
        setInterval(updateTime, 1000);

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
