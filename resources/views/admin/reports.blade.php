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
<!-- Chat Page Button -->
    <button onclick="chatPage('/chat-messages')" class="fixed bottom-0 right-0 bg-gray-300 hover:bg-blue-400 text-sm text-black rounded-full h-12 w-12 flex items-center justify-center border border-black shadow-md shadow-slate-500 m-4 md:m-8">
        <span class="material-icons-sharp">insert_comment</span>
    </button>
<!-- Main Content -->
        <div class="flex-auto flex flex-col">
            <div class="flex bg-white mt-8 rounded-md shadow-md shadow-slate-500 mx-10 w-[1200px]">
                <div class="flex px-2 m-4">
                    <h2 class="text-indigo-800 font-bold text-4xl">Reports</h2>
                    <form action="" method="GET" class="flex items-center ml-10">
                        <div class="relative">
                            <input class="rounded-full bg-slate-300 text-black h-8 w-64 px-10 pr-4 border border-black shadow-md shadow-slate-500" type="text" name="search" placeholder="Search for a ...">
                            <span class="material-icons-sharp absolute inset-y-0 left-1 ml-1 mt-1 text-black">
                                search
                            </span>
                        </div>
                        <select name="category" class="ml-8 p-1 h-8 w-44 border border-black rounded-r bg-slate-300 text-black shadow-md shadow-slate-500">
                            <option value="title" class="bg-slate-200 text-black">Office Name</option>
                            <option value="OriginatingOffice" class="bg-slate-200 text-black">Office Code</option>
                            <option value="type" class="bg-slate-200 text-black">Users</option>
                            <option value="action" class="bg-slate-200 text-black">Processing Time</option>
                            <option value="OriginatingOffice" class="bg-slate-200 text-black">Documents Created</option>
                            <option value="type" class="bg-slate-200 text-black">Documents Received</option>
                            <option value="action" class="bg-slate-200 text-black">Documents Released</option>
                            <option value="action" class="bg-slate-200 text-black">Tagged as Terminal</option>
                        </select>
                        <select name="order" class="ml-4 p-1 h-8 w-w-[120px] border border-black rounded-r bg-slate-300 text-black shadow-md shadow-slate-500">
                            <option value="asc" class="bg-slate-200 text-black">Ascending</option>
                            <option value="desc" class="bg-slate-200 text-black">Descending</option>
                        </select>
                        <div class="items-center">
                            <input type="datetime-local" id="dateTimePicker" class="form-input border border-gray-400 rounded-r bg-slate-200 text-slate-500 shadow-md shadow-slate-500 ml-8"/>
                        </div>
                    </form>
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
                                <th scope="col" class="border border-black">Documents Created</th>
                                <th scope="col" class="border border-black">Documents Received</th>
                                <th scope="col" class="border border-black">Documents Released</th>
                                <th scope="col" class="border border-black">Tagged as Terminal</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            {{-- @foreach($documents as $document)--}}
                                <tr class="bg-white text-zinc-400 h-12">
                                    <td class="border border-black">Name</td>
                                    <td class="border border-black">xxx-xx-xxx</td>
                                    <td class="border border-black">Users_BA_JHACK</td>
                                    <td class="border border-black">Time</td>
                                    <td class="border border-black">No.Created</td>
                                    <td class="border border-black">No.Received</td>
                                    <td class="border border-black">No.Release</td>
                                    <td class="border border-black">No.Tagged</td>
                                </tr>
                            {{--@endforeach--}}
                        </tbody>
                        <tbody class="bg-white divide-y divide-gray-200">
                            {{-- @foreach($documents as $document)--}}
                                <tr class="bg-white text-zinc-400 h-12">
                                    <td class="border border-black">Name</td>
                                    <td class="border border-black">xxx-xx-xxx</td>
                                    <td class="border border-black">Users_PM_ANGEL</td>
                                    <td class="border border-black">Time</td>
                                    <td class="border border-black">No.Created</td>
                                    <td class="border border-black">No.Received</td>
                                    <td class="border border-black">No.Release</td>
                                    <td class="border border-black">No.Tagged</td>
                                </tr>
                            {{--@endforeach--}}
                        </tbody>
                        <tbody class="bg-white divide-y divide-gray-200">
                            {{-- @foreach($documents as $document)--}}
                                <tr class="bg-white text-zinc-400 h-12">
                                    <td class="border border-black">Name</td>
                                    <td class="border border-black">xxx-xx-xxx</td>
                                    <td class="border border-black">Users_PM_ANGEL</td>
                                    <td class="border border-black">Time</td>
                                    <td class="border border-black">No.Created</td>
                                    <td class="border border-black">No.Received</td>
                                    <td class="border border-black">No.Release</td>
                                    <td class="border border-black">No.Tagged</td>
                                </tr>
                            {{--@endforeach--}}
                        </tbody>
                        <tbody class="bg-white divide-y divide-gray-200">
                            {{-- @foreach($documents as $document)--}}
                                <tr class="bg-white text-zinc-400 h-12">
                                    <td class="border border-black">Name</td>
                                    <td class="border border-black">xxx-xx-xxx</td>
                                    <td class="border border-black">Users_PM_ANGEL</td>
                                    <td class="border border-black">Time</td>
                                    <td class="border border-black">No.Created</td>
                                    <td class="border border-black">No.Received</td>
                                    <td class="border border-black">No.Release</td>
                                    <td class="border border-black">No.Tagged</td>
                                </tr>
                            {{--@endforeach--}}
                        </tbody>
                        <tbody class="bg-white divide-y divide-gray-200">
                            {{-- @foreach($documents as $document)--}}
                                <tr class="bg-white text-zinc-400 h-12">
                                    <td class="border border-black">Name</td>
                                    <td class="border border-black">xxx-xx-xxx</td>
                                    <td class="border border-black">Users_PM_ANGEL</td>
                                    <td class="border border-black">Time</td>
                                    <td class="border border-black">No.Created</td>
                                    <td class="border border-black">No.Received</td>
                                    <td class="border border-black">No.Release</td>
                                    <td class="border border-black">No.Tagged</td>
                                </tr>
                            {{--@endforeach--}}
                        </tbody>
                    </table>
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

        function chatPage(url) {
            window.location.href = url;
        }
    </script>
</body>
</html>
