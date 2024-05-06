<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-...." crossorigin="anonymous" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    @vite(['resources/css/admin.css','resources/js/admin.js'])
    <title>Edit Type</title>
</head>

<body class="bg-slate-100">
<!-- Top-bar Navigation -->
    <div class="bg-white h-16 p-5 md:p-2 flex flex-row md:flex-row items-center justify-between">
        <!-- Logo and DRS Container -->
        <div class="flex flex-row md:flex-row items-center">
            <img src="{{ asset('images/PLM_LOGO.png') }}" alt="PLM Logo" class="ml-4 w-14 h-14">
            <h2 class="text-4xl md:text-4xl font-bold text-indigo-800 mr-20">
                <a href="{{route('admin-reports')}}" class="ml-4">DRS</a>
            </h2>
        </div>

        <!-- Notifications -->
        <div class="notification-container relative inline-block">
            <button class="notification-button relative">
                <span class="material-icons-sharp text-2xl">notifications</span>
                <span class="notification-dot absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
            </button>
            <div class="notification-dropdown hidden absolute rounded-lg right-0 bg-white shadow-lg min-w-max z-10">
                <a href="#" class="notification-item block p-4 border-b border-gray-200">
                    <div class="flex justify-between">
                        <div>New notification 1</div>
                        <div class="text-xs text-gray-500">10:30 AM</div>
                    </div>
                    <div class="text-sm text-gray-500">CISTM</div>
                    <div class="text-sm text-gray-500">Type: Enrollment</div>
                </a>
                <a href="#" class="notification-item block p-4 border-b border-gray-200">
                    <div class="flex justify-between">
                        <div>New notification 2</div>
                        <div class="text-xs text-gray-500">11:30 AM</div>
                    </div>
                    <div class="text-sm text-gray-500">TEST</div>
                    <div class="text-sm text-gray-500">Type: TEST</div>
                </a>
                <a href="#" class="notification-item block p-4 border-b border-gray-200">
                    <div class="flex justify-between">
                        <div>New notification 3</div>
                        <div class="text-xs text-gray-500">10:30 PM</div>
                    </div>
                    <div class="text-sm text-gray-500">ICTO</div>
                    <div class="text-sm text-gray-500">Type: For Approval</div>
                </a>
                <!-- Repeat for other notifications -->
                <div class="py-1">
                    <a href="#" class="block text-center px-4 py-1 text-sm text-gray-700 hover:bg-gray-100">View All Notifications</a>
                </div>
            </div>
        </div>


        <!-- Search Container -->
        <div class="flex relative items-center mt-4 md:mt-0">
            <form action="" method="GET" class="relative">
                <input type="text" name="query" placeholder="Search for Documents" class="w-650 p-1 pl-10 pr-4 py-2 bg-slate-200 rounded-full">
                <span class="material-icons-sharp absolute inset-y-0 left-0 ml-2 mt-2 text-white">search</span>
                <button type="submit"></button>
            </form>
        </div>

        <!-- User Container -->
        <div class="ml-2 top-0 right-20 flex items-center">
            <span class="material-icons-sharp text-6xl">person_outline</span>
            <h2 class="text-xl md:text-2xl font-bold ml-2">{{ auth()->user()->name }}</h2>
        </div>

        <!-- Dropdown -->
        <div class="relative inline-block ml-10 top-0">
            <button class="dropbtn bg-white text-black p-3 text-sm border-none">
                <span class="material-icons-sharp">arrow_drop_down</span>
            </button>
            <div class="dropdown-content hidden absolute bg-gray-200 right-0 rounded-md min-w-160 text-right shadow-lg z-10">
                <h2 class="text-black p-2 ml-1 block hover:bg-gray-300">{{ auth()->user()->email }}</h2>
                <h2 class="text-black p-2 ml-1 block hover:bg-gray-300">{{ auth()->user()->office->code }}</h2>
                <h2 class="text-black p-2 ml-1 block hover:bg-gray-300">Administrator</h2>
            </div>
        </div>
    </div>
<!-- Side-bar Navigation -->
    <div class="flex h-screen">
        <div class="w-52 bg-red-800 shadow-lg text-white h-screen">
            <div>
                <ul class="mt-2">
                    <li class="relative px-5 py-3 bg-red-800 hover:bg-red-900 w-full">
                        <a href="{{route('admin-reports')}}">
                            <span class="flex items-center justify-between ">
                                <span>Reports</span>
                                <span class="ml-2">
                                    <svg class="h-5 w-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                        <path d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </span>
                            </span>
                        </a>
                    </li>
                    <li class="relative px-5 py-3 bg-red-800 hover:bg-red-900 w-full">
                        <a href="{{route('admin-offices')}}">
                            <span class="flex items-center justify-between ">
                                <span>Offices</span>
                                <span class="ml-2">
                                    <svg class="h-5 w-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                        <path d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </span>
                            </span>
                        </a>
                    </li>
                    <li class="relative px-5 py-3 bg-red-800 hover:bg-red-900 w-full">
                        <a href="{{route('admin-users')}}">
                            <span class="flex items-center justify-between ">
                                <span>Users</span>
                                <span class="ml-2">
                                    <svg class="h-5 w-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                        <path d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </span>
                            </span>
                        </a>
                    </li>
                    <li class="relative px-5 py-3 bg-red-800 hover:bg-red-900 w-full">
                        <a href="{{route('admin-track')}}">
                            <span class="flex items-center justify-between ">
                                <span>Track Documents</span>
                                <span class="ml-2">
                                    <svg class="h-5 w-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                        <path d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </span>
                            </span>
                        </a>
                    </li>
                    <li class="relative px-5 py-3 bg-red-800 hover:bg-red-900 w-full">
                        <a href="{{route('admin-types')}}">
                            <span class="flex items-center justify-between ">
                                <span>Document Types</span>
                                <span class="ml-2">
                                    <svg class="h-5 w-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                        <path d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </span>
                            </span>
                        </a>
                    </li>
                    <li class="relative px-5 py-3 bg-red-800 hover:bg-red-900 w-full">
                        <a href="{{route('admin-actions')}}">
                            <span class="flex items-center justify-between ">
                                <span>Document Actions</span>
                                <span class="ml-2">
                                    <svg class="h-5 w-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                        <path d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </span>
                            </span>
                        </a>
                    </li>
                    <li class="relative px-5 py-3 bg-red-800 hover:bg-red-900 w-full">
                        <a href="{{route('admin-configs')}}">
                            <span class="flex items-center justify-between ">
                                <span>Configurations</span>
                                <span class="ml-2">
                                    <svg class="h-5 w-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                        <path d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </span>
                            </span>
                        </a>
                    </li>
                    <li class="relative px-5 py-3 bg-red-800 hover:bg-red-900 w-full">
                        <a href="{{route('admin-logs')}}">
                            <span class="flex items-center justify-between ">
                                <span>System Logs</span>
                                <span class="ml-2">
                                    <svg class="h-5 w-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                        <path d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </span>
                            </span>
                        </a>
                    </li>
                    <li class="relative pt-32">
                        <a href="{{route('admin-settings')}}" class="flex items-center gap-x-2 text-sm px-12 py-1 bg-red-800 hover:bg-red-900 w-full">
                            <span class="material-icons-sharp text-base">
                                settings
                            </span>
                            <span>Settings</span>
                        </a>
                    </li>
                    <li class="relative">
                        <a href="javascript:void(0);" onclick="confirmLogout('/logout')" class="flex items-center gap-x-2 text-sm px-12 py-1 bg-red-800 hover:bg-red-900 w-full">
                            <span class="material-icons-sharp text-base">
                                logout
                            </span>
                            <span>Logout</span>
                        </a>
                    </li>
                    <li class="relative">
                        <a href="{{route('admin-guides')}}" class="flex items-center gap-x-2 text-sm px-12 py-1 bg-red-800 hover:bg-red-900 w-full">
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
<!-- Chat Page Button -->
<button onclick="chatPage('/chat-messages')" class="fixed bottom-0 right-0 bg-gray-300 hover:bg-blue-400 text-sm text-black rounded-full h-12 w-12 flex items-center justify-center border border-black shadow-md shadow-slate-500 m-4 md:m-8">
    <span class="material-icons-sharp">insert_comment</span>
</button>
        <div class="flex-none flex flex-row item-center justify-between">
            <div class="w-auto bg-white flex justify-center text-center ml-12 items-center h-12 rounded-md shadow-md shadow-slate-500 mt-8 ">
                <h2 class="text-indigo-800 text-4xl font-bold p-4">
                    Edit "{{$type->name}}" Type
                </h2>
            </div>
            <div class="bg-white px-4 w-[600px] h-3/6 mt-8 justify-center rounded-md shadow-md shadow-slate-500 relative m-4">
                <!-- Messages -->
                @if ($errors->any())
                    <div class="alert alert-danger relative bg-red-300 text-red-800 font-bold text-base w-full">
                        <ul>
                            <h2> Document Type not updated successfully due to various reason(s):</h2>
                                @foreach ($errors->all() as $error)
                                <li class="pl-4">->{{ $error }}</li>
                                @endforeach
                        </ul>
                    </div>
                @endif
                <form class="space-y-4" action="/admin/document-types/update/{{ $type->id }}" method="POST">
                @csrf
                    <div>
                        <div class="flex items-center mt-6 mb-4">
                            <span class="material-icons-sharp text-3xl">person_outline</span>
                            <h2 class="text-xl text-indigo-800 md:text-2xl font-bold ml-2">Edit Document Type</h2>
                        </div>

                        <label for="name" class="text-indigo-800 font-bold text-md">Type Name</label><br>
                        <input type="text" id="name" name="name" value="{{ $type->name }}" class="rounded-full bg-slate-200 text-black w-full pl-3 shadow-md shadow-slate-500 mb-2" required>

                        <label for="description" class="text-indigo-800 font-bold text-md">Type Description</label><br>
                        <textarea rows="5" cols="45" id="description" name="description" value="{{ $type->description }}" class="rounded resize-none bg-slate-200 text-black w-full pl-3 shadow-md shadow-slate-500 mb-2" required></textarea><br>

                    </div>
                    <div class="flex justify-center">
                        <button type="submit" class="mb-4 inline-flex justify-center py-1 px-4 border border-transparent shadow-sm text-xl font-medium rounded-md text-white bg-[#bf9b30] hover:bg-[#8C6B0A] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#bf9b30]">Update Document Type</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<!-- Script goes here!! -->
    <script>
        src="{{ asset('js/admin.js') }}"
        function confirmLogout(url) {
            if (confirm('Are you sure you want to Logout?')) {
                window.location.href = url;
            }
        }
        function chatPage(url) {
            window.location.href = url;
        }
    </script>
</body>
</html>
