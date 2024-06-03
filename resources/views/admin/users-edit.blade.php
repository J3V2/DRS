<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-...." crossorigin="anonymous" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    @vite(['resources/css/admin.css','resources/js/admin.js'])
    <title>Edit User</title>
</head>

<body class="bg-slate-100">
<!-- Top-bar Navigation -->
<div class="bg-white h-16 p-5 md:p-2 flex flex-row md:flex-row items-center justify-between">
    <!-- Logo and Home Container -->
    <div class="flex flex-row md:flex-row items-center">
        <img src="{{ asset('images/PLM_LOGO.png') }}" alt="PLM Logo" class="ml-4 w-14 h-14">
        <h2 class="text-4xl md:text-4xl font-bold text-indigo-800 mr-20">
            <a href="{{route('admin-reports')}}" class="ml-4">DRS</a>
        </h2>
    </div>

    <!-- Date and Time -->
    <div class="flex items-center">
        <h2 id="realTime" class="text-xl font-bold text-red-800">
        </h2>
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
            <h2 class="text-black p-2 block hover:bg-gray-300">Administrator</h2>
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
                <li class="relative px-5 py-3 bg-red-900 w-full">
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
    <div class="flex-none flex flex-row item-center justify-between">
        <div class="w-auto bg-white flex justify-center text-center ml-12 items-center h-12 rounded-md shadow-md shadow-slate-500 mt-8 ">
            <h2 class="text-indigo-800 text-4xl font-bold p-4">
                Edit "{{$user->name}}" User
            </h2>
        </div>
        <div class="bg-white px-4 w-[600px] h-4/6 mt-8 justify-center rounded-md shadow-md shadow-slate-500 relative m-4">
                <!-- Messages -->
                @if ($errors->any())
                    <div class="alert alert-danger relative bg-red-300 text-red-800 font-bold text-base w-full">
                        <ul>
                            <h2> User not updated successfully due to various reason(s):</h2>
                                @foreach ($errors->all() as $error)
                                <li class="pl-4">->{{ $error }}</li>
                                @endforeach
                        </ul>
                    </div>
                @endif
                <form class="space-y-4" action="/admin/users/update/{{ $user->id }}" method="POST">
                @csrf
                    <div>
                        <div class="flex items-center mt-6 mb-4">
                            <span class="material-icons-sharp text-3xl">person_outline</span>
                            <h2 class="text-xl text-indigo-800 md:text-2xl font-bold ml-2">Edit DRS User</h2>
                        </div>
                        <label for="name" class="text-indigo-800 font-bold text-md">Name</label><br>
                        <input type="text" id="name" name="name" value="{{ $user->name }}" class="rounded-full bg-slate-200 text-black w-full pl-3 shadow-md shadow-slate-500 mb-2" required>

                        <label for="email" class="text-indigo-800 font-bold text-md">Email</label><br>
                        <input type="text" id="email" name="email" value="{{ $user->email }}" class="rounded-full bg-slate-200 text-black w-full pl-3 shadow-md shadow-slate-500 mb-2" required><br>

                        <label for="password" class="text-indigo-800 font-bold text-md">Password</label><br>
                        <input type="password" id="password" name="password" value="{{ $user->password }}" class="rounded-full bg-slate-200 text-black w-full pl-3 shadow-md shadow-slate-500 mb-2" required><br>

                        <label for="role" class="text-indigo-800 font-bold text-md">Role</label><br>
                        <select id="role" name="role" class="rounded-full bg-slate-200 text-black w-full pl-3 shadow-md shadow-slate-500 mb-2" required>
                            <option value="1">Regular User</option>
                            <option value="0">Administrator</option>
                        </select><br>

                        <label for="office_id" class="text-indigo-800 font-bold text-md">Office</label><br>
                        <select id="office_id" name="office_id" value="{{ $user->office->code}}" class="rounded-full bg-slate-200 text-black w-full pl-3 shadow-md shadow-slate-500 mb-2" required>
                        @foreach ($offices as $office)
                            <option value="{{ $office->id }}" {{ $office->code == $user->office_code ? 'selected' : '' }}>{{ $office->name }}</option>
                        @endforeach
                        </select><br>
                    </div>
                    <div class="flex justify-center">
                        <button type="submit" class="mb-4 inline-flex justify-center py-1 px-4 border border-transparent shadow-sm text-xl font-medium rounded-md text-white bg-[#bf9b30] hover:bg-[#8C6B0A] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#bf9b30]">Update User</button>
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
        function updateTime() {
            const now = new Date();
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric', second: 'numeric' };
            const realTime = now.toLocaleString('en-US', options);
            document.getElementById('realTime').textContent = realTime;
        }

        // Update every second
        setInterval(updateTime, 1000);

    </script>
</body>
</html>
