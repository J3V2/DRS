<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-...." crossorigin="anonymous" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    @vite(['resources/css/admin.css','resources/js/admin.js'])
    <title>Users</title>
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
        <div class="bg-red-800 shadow-lg text-white w-[250px]">
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
        <div class="flex-auto flex flex-col">
            <div class="flex bg-white mt-8 rounded-md shadow-md shadow-slate-500 mx-10 w-[1200px]">
                <div class="flex px-2 m-4">
                    <h2 class="text-indigo-800 font-bold text-4xl">Users</h2>
                    <form action="{{ route('admin-users') }}" method="GET" class="flex items-center ml-10">
                        <div class="relative">
                            <input class="rounded-full bg-slate-300 text-black h-8 w-64 px-10 pr-4 border border-black shadow-md shadow-slate-500" type="text" name="search" placeholder="Search for a ...">
                            <span class="material-icons-sharp absolute inset-y-0 left-1 ml-1 mt-1 text-black">
                                search
                            </span>
                        </div>
                        <select name="category" class="ml-8 p-1 h-8 w-40 border border-black rounded-r bg-slate-300 text-black shadow-md shadow-slate-500">
                            <option value="name" class="bg-slate-200 text-black">Name</option>
                            <option value="email" class="bg-slate-200 text-black">Employee ID</option>
                            <option value="office_id" class="bg-slate-200 text-black">Office Code</option>
                            <option value="role" class="bg-slate-200 text-black">Type of Account</option>
                        </select>
                        <select name="order" class="ml-4 p-1 h-8 w-32 border border-black rounded-r bg-slate-300 text-black shadow-md shadow-slate-500">
                            <option value="asc" class="bg-slate-200 text-black">Ascending</option>
                            <option value="desc" class="bg-slate-200 text-black">Descending</option>
                        </select>
                        <button type="submit" class="ml-12 p-1 h-8 w-auto border border-black rounded-md bg-slate-300 text-black shadow-md shadow-slate-500">
                            Search
                        </button>
                        <div class="items-center">
                            <button class="ml-12 w-24 p-1 hover:font-bold border border-gray-400 rounded-md bg-slate-200 hover:bg-green-300 text-slate-500 hover:text-green-900 shadow-md hover:shadow-xl shadow-slate-500 hover:shadow-green-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500" onclick="document.getElementById('add').style.display='block'" type="button">Add User</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Messages -->
            @if ($errors->any())
                <div class="alert alert-danger relative bg-red-300 text-red-800 font-bold text-center text-base p-1 w-full">
                    <ul>
                        <h2 class="pl-12"> User not added successfully due to various reason(s):</h2>
                        @foreach ($errors->all() as $error)
                            <li class="pl-16">->{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('success'))
                    <div class="alert alert-success relative bg-green-300 text-green-800 font-bold text-center text-base p-1 w-full">
                        {{ session('success') }}
                    </div>
            @endif

            <div class="bg-white mt-8 rounded-md shadow-md shadow-slate-500 justify-center mx-10 w-[1200px] h-4/6">
                <div class="overflow-auto self-center text-center m-8 h-[79%] rounded-md shadow-md shadow-slate-500">
                    <table class="divide-y divide-gray-200 w-full h-full">
                        <thead class="bg-red-700 text-white sticky top-0 inset-0">
                            <tr>
                                <th scope="col" class="border border-black">Name</th>
                                <th scope="col" class="border border-black">Employee ID</th>
                                <th scope="col" class="border border-black">Office Code</th>
                                <th scope="col" class="border border-black">Type of Account</th>
                                <th scope="col" class="border border-black">Created at</th>
                                <th scope="col" class="border border-black">Updated at</th>
                                <th scope="col" class="border border-black">Actions</th>
                                <th scope="col" class="border border-black">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($users as $user)
                                <tr class="bg-white text-black h-10">
                                    <td class="border border-black">{{$user->name}}</td>
                                    <td class="border border-black">{{$user->email}}</td>
                                    <td class="border border-black">{{$user->office->code}}</td>
                                    <!-- Determine the role string before outputting it -->
                                    @php
                                        $roleString = $user->role == 0 ? 'Administrator' : 'Regular User';
                                    @endphp
                                    <td class="border border-black">{{$roleString}}</td>
                                    <td class="border border-black">{{$user->created_at}}</td>
                                    <td class="border border-black">{{$user->updated_at}}</td>
                                    <td class="border border-black">
                                        <div class="flex justify-center self-center font-bold text-black">
                                            <button type="submit" class="size-11/12 p-1 rounded-md bg-[#bf9b30] hover:bg-[#8C6B0A]">
                                                <a href="/admin/users/edit/{{ $user->id }}">Edit</a>
                                            </button>
                                        </div>
                                    </td>
                                    <td class="border border-black">
                                        <div class="flex justify-center self-center font-bold text-black">
                                            @if ($user->user_status != 1)
                                            <button type="submit" class="size-11/12 p-1 rounded-md bg-green-300 hover:bg-green-500" onclick="confirmActivate('/admin/users/activate/{{ $user->id }}')">
                                                Activate
                                            </button>
                                            @else
                                            <button type="submit" class="size-11/12 p-1 rounded-md bg-red-300 hover:bg-red-500" onclick="confirmDeactivate('/admin/users/deactivate/{{ $user->id }}')">
                                                Deactivate
                                            </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- Pagination Links -->
                <div class="mt-4">
                    {{ $users->appends(['search' => request('search'), 'category' => request('category'), 'order' => request('order')])->links('vendor.pagination.tailwind') }}
                </div>
            </div>
        </div>
    </div>
<!-- Add Modal Content -->
    <div id="add" class="fixed inset-0 w-auto h-auto bg-[#474e5d] flex items-center justify-center z-10 hidden">
        <div class="relative bg-white rounded-lg shadow-lg p-8 w-[500px] inset-x-[550px] inset-y-[150px]">
            <span onclick="document.getElementById('add').style.display='none'" class="close text-3xl text-black cursor-pointer absolute top-0 right-0 p-4" title="Exit">&times;</span>
            <form class="space-y-4" action="{{ route('addUser') }}" method="POST">
            @csrf
                <div>
                    <div class="flex items-center">
                        <span class="material-icons-sharp text-3xl">person_outline</span>
                        <h2 class="text-xl text-indigo-800 md:text-2xl font-bold ml-2">Add DRS User</h2>
                    </div>
                    <label for="name" class="text-indigo-800 font-bold text-md">Name</label><br>
                    <input type="text" id="name" name="name" class="rounded-full bg-slate-200 text-black w-full pl-3 shadow-md shadow-slate-500 mb-1" required>

                    <label for="email" class="text-indigo-800 font-bold text-md">Employee ID</label><br>
                    <input type="text" id="email" name="email" class="rounded-full bg-slate-200 text-black w-full pl-3 shadow-md shadow-slate-500 mb-1" required><br>

                    <label for="password" class="text-indigo-800 font-bold text-md">Password</label><br>
                    <input type="password" id="password" name="password" class="rounded-full bg-slate-200 text-black w-full pl-3 shadow-md shadow-slate-500 mb-1" required><br>

                    <label for="role" class="text-indigo-800 font-bold text-md">Role</label><br>
                    <select id="role" name="role" class="rounded-full bg-slate-200 text-black w-full pl-3 shadow-md shadow-slate-500 mb-1" required>
                        <option value="1">Regular User</option>
                        <option value="0">Administrator</option>
                    </select><br>

                    <label for="office_id" class="text-indigo-800 font-bold text-md">Office</label><br>
                    <select id="office_id" name="office_id" class="rounded-full bg-slate-200 text-black w-full pl-3 shadow-md shadow-slate-500 mb-1" required>
                    @foreach ($offices as $office)
                        <option value="{{ $office->id }}">{{ $office->name }}</option>
                    @endforeach
                    </select><br>
                </div>
                <div class="flex justify-end">
                    <button type="button" onclick="document.getElementById('add').style.display='none'" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Cancel</button>
                    <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">Add User</button>
                </div>
            </form>
        </div>
    </div>
<!-- Script goes here!! -->
    <script>
        src="{{ asset('js/admin.js') }}"
        function confirmActivate(url) {
            if (confirm('Are you sure you want to Activate the status of this DRS User?')) {
                window.location.href = url;
            }
        }
        function confirmDeactivate(url) {
            if (confirm('Are you sure you want to Deactivate the status of this DRS User?')) {
                window.location.href = url;
            }
        }
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
