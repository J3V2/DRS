<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-...." crossorigin="anonymous" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    @vite(['resources/css/admin.css','resources/js/admin.js'])
    <title>Reports</title>
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
                    <li class="relative px-5 py-3 bg-red-900 w-full">
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
                <div class="flex px-2 m-4 items-center">
                    <h2 class="text-indigo-800 font-bold text-4xl">Reports</h2>
                    <form action="{{ route('admin-reports') }}" method="GET" class="flex items-center ml-10">
                        <select name="category" class="ml-44 p-1 h-8 w-36 border border-black rounded-r bg-slate-300 text-black shadow-md shadow-slate-500">
                            <option value="name" class="bg-slate-200 text-black">Users</option>
                            <option value="AvgProcessTime" class="bg-slate-200 text-black">Processing Time</option>
                        </select>
                        <div class="items-center ml-4">
                            <input type="datetime-local" id="dateTimePicker" name="datetime" class="form-input border bg-slate-300 border-gray-400 rounded-r w-46 bg-slate-200 text-slate-500 shadow-md shadow-slate-500" />
                        </div>
                        <select name="order" class="ml-4 p-1 h-8 w-w-[120px] border border-black rounded-r bg-slate-300 text-black shadow-md shadow-slate-500">
                            <option value="asc" class="bg-slate-200 text-black">Ascending</option>
                            <option value="desc" class="bg-slate-200 text-black">Descending</option>
                        </select>
                        <button type="submit" class="ml-12 p-1 h-8 items-center w-auto border border-black rounded-md bg-slate-300 text-black shadow-md shadow-slate-500">
                            Search
                        </button>
                    </form>
                    <button type="submit" class="print-reports-button ml-4 p-1 h-8 w-auto border border-black rounded-md bg-slate-300 text-black shadow-md shadow-slate-500">
                        Print Reports
                    </button>
                </div>
            </div>

            <div class="bg-white mt-8 rounded-md shadow-md shadow-slate-500 justify-center mx-10 w-[1200px] h-4/6">
                <div class="overflow-auto self-center text-center m-8 h-[79%] rounded-md shadow-md shadow-slate-500">
                    <table class="divide-y divide-gray-200 w-full h-full">
                        <thead class="bg-red-700 text-white sticky top-0 inset-0">
                            <tr>
                                <th scope="col" class="border border-black">Office Name</th>
                                <th scope="col" class="border border-black">Office Code</th>
                                <th scope="col" class="border border-black">Users</th>
                                <th scope="col" class="border border-black">Ave.Processing Time</th>
                                <th scope="col" class="border border-black"># of Documents Created</th>
                                <th scope="col" class="border border-black"># of Documents Received</th>
                                <th scope="col" class="border border-black"># of Documents Released</th>
                                <th scope="col" class="border border-black"># of Documents Terminal</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($users as $user)
                                <tr class="bg-white text-black h-12">
                                    <td class="border border-black">{{$user->office->name}}</td>
                                    <td class="border border-black">{{$user->office->code}}</td>
                                    <td class="border border-black">{{$user->name}}</td>
                                    <td class="border border-black">{{$user->AvgProcessTime}}</td>
                                    <td class="border border-black">{{ $user->documents_created_count }}</td>
                                    <td class="border border-black">{{ $user->documents_received_count }}</td>
                                    <td class="border border-black">{{ $user->documents_released_count }}</td>
                                    <td class="border border-black">{{ $user->documents_terminal_count }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $users->appends(['category' => request('category'), 'datetime' => request('datetime'), 'order' => request('order')])->links('vendor.pagination.tailwind') }}
                </div>
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

        document.querySelector('.print-reports-button').addEventListener('click', function() {
            window.location.href = `/download-reports`;
        });
    </script>
</body>
</html>
