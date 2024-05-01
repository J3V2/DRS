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

<body>
<!-- Top-bar Navigation -->
    <div class="bg-white h-16 p-5 md:p-2 flex flex-row md:flex-row items-center justify-between">
        <!-- Logo and Home Container -->
        <div class="flex flex-row md:flex-row items-center">
            <img src="{{ asset('images/PLM_LOGO.png') }}" alt="PLM Logo" class="ml-4 w-14 h-14">
            <h2 class="text-4xl md:text-4xl font-bold text-indigo-800 mr-20">
                <a href="{{route('user-dashboard')}}" class="ml-4">DRS</a>
            </h2>
        </div>

        <!-- Notifications -->
        <div class="notification-container relative inline-block">
            <button class="notification-button relative">
                <span class="material-icons-sharp text-2xl">notifications</span>
                <span class="notification-dot absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
            </button>
            <div class="notification-dropdown hidden absolute w-64 rounded-lg border-2 bg-white shadow-lg min-w-max z-10">
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
                    <a href="#" class="block text-center px-4 py-1 text-sm text-gray-700 hover:bg-gray-100">View All Documents</a>
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
                <h2 class="text-black p-2 block hover:bg-gray-300">{{ auth()->user()->email }}</h2>
                <h2 class="text-black p-2 block hover:bg-gray-300">{{ auth()->user()->office->code }}</h2>
                <h2 class="text-black p-2 block hover:bg-gray-300">Regular User</h2>
            </div>
        </div>
    </div>
<!-- Side-bar Navigation -->
    <div class="flex h-auto">
        <div class="w-64 bg-indigo-800 shadow-lg text-white">
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
                    <li class="relative text-sm px-12 py-1 bg-indigo-800 hover:bg-indigo-900 w-full">
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
                    <a href="{{route('user-settings')}}" class="flex items-center gap-x-2 text-sm mt-28 bg-indigo-800 hover:bg-indigo-900 w-full px-5 py-1">
                        <span class="material-icons-sharp text-base">
                            settings
                        </span>
                        <h3 class="text-xs">Settings</h3>
                    </a>
                    <a href="javascript:void(0);" class="flex items-center gap-x-2 text-sm mt-1 bg-indigo-800 hover:bg-indigo-900 w-full px-5 py-1" onclick="confirmLogout('/logout')">
                        <span class="material-icons-sharp text-base">
                            logout
                        </span>
                        <h3 class="text-xs">Logout</h3>
                    </a>
                    <a href="{{route('user-guides')}}" class="flex items-center gap-x-2 text-sm mt-1 bg-indigo-800 hover:bg-indigo-900 w-full px-5 py-1">
                        <span class="material-icons-sharp text-base">
                            question_mark
                        </span>
                        <h3 class="text-xs">DRS Guide</h3>
                    </a>
                </ul>
            </div>
        </div>
<!-- Main Content -->
        <div class="flex flex-auto flex-col">
            <div class="flex bg-white w-11/12 h-auto mt-8 rounded-md shadow-md shadow-slate-500 justify-center mx-10">
                <div class="flex grid grid-cols-3 px-2 w-auto m-4">
                    <div class="row-start-1 row-span-2">
                        <h2 class="text-indigo-800 font-bold text-4xl">Received</h2>
                        <h4 class="text-indigo-800 font-semibold text-sm"><a href="{{route('user-my-docs')}}"class="text-sm text-black">My Documents </a><a href="{{route('user-my-received')}}"> > Received</a></h4>
                    </div>
                    <form action="" method="GET" class="flex items-center">
                        <div class="relative ml-6 top-3">
                            <input class="rounded-full bg-slate-300 text-black h-8 w-64 px-10 pr-4 border border-black shadow-md shadow-slate-500" type="text" name="search" placeholder="Search for ...">
                            <button type="submit">
                                <span class="material-icons-sharp absolute inset-y-0 left-1 ml-1 mt-1 text-black">
                                    search
                                </span>
                            </button>
                        </div>
                        <select name="category" class="ml-6 p-1 h-8 w-auto border border-black rounded-r bg-slate-300 text-black shadow-md shadow-slate-500">
                            <option value="tracking_number" class="bg-slate-200 text-black">Tracking Number</option>
                            <option value="received" class="bg-slate-200 text-black">Received</option>
                            <option value="office_code" class="bg-slate-200 text-black">Originating Office</option>
                            <option value="office_code" class="bg-slate-200 text-black">Last Office</option>
                            <option value="title" class="bg-slate-200 text-black">Document Title</option>
                            <option value="type" class="bg-slate-200 text-black">Document Type</option>
                            <option value="action" class="bg-slate-200 text-black">Latest Action</option>
                        </select>
                        <select name="order" class="ml-6 p-1 h-8 w-auto border border-black rounded-r bg-slate-300 text-black shadow-md shadow-slate-500">
                            <option value="asc" class="bg-slate-200 text-black">Ascending</option>
                            <option value="desc" class="bg-slate-200 text-black">Descending</option>
                        </select>
                    </form>
                </div>
            </div>
            <div class="bg-white w-11/12 h-auto mt-8 rounded-md shadow-md shadow-slate-500 justify-center mx-10">
                <div class="overflow-auto max-h-96 w-[1010px] self-center text-center m-8">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-indigo-800">
                            <tr>
                                <th scope="col" class="border border-black">Tracking Number</th>
                                <th scope="col" class="border border-black">Received</th>
                                <th scope="col" class="border border-black">Originating Office</th>
                                <th scope="col" class="border border-black">Last  Office</th>
                                <th scope="col" class="border border-black">Document Title</th>
                                <th scope="col" class="border border-black">Document Type</th>
                                <th scope="col" class="border border-black">Latest Action</th>
                                <th scope="col" class="border border-black">Latest Remarks</th>
                                <th scope="col" class="border border-black">View</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            {{-- @foreach($documents as $document)--}}
                                <tr class="bg-white text-zinc-400 h-12">
                                    <td class="border border-black">xxxx-xxxx-xxxx-xxxx</td>
                                    <td class="border border-black">Yes/No</td>
                                    <td class="border border-black">Office Code</td>
                                    <td class="border border-black">Last Office Code</td>
                                    <td class="border border-black">Document Title</td>
                                    <td class="border border-black">Document Type</td>
                                    <td class="border border-black">Latest Action</td>
                                    <td class="border border-black">Latest Remarks</td>
                                    <td class="border border-black">
                                        <button type="submit" class="size-11/12 p-1 font-bold text-white rounded-md bg-[#bf9b30] hover:bg-[#8C6B0A]">
                                            <a href="/user/view-document">View</a>
                                        </button>
                                        </div>
                                    </td>
                                </tr>
                            {{--@endforeach--}}
                        </tbody>
                        <tbody class="bg-white divide-y divide-gray-200">
                            {{-- @foreach($documents as $document)--}}
                                <tr class="bg-white text-zinc-400 h-12">
                                    <td class="border border-black">xxxx-xxxx-xxxx-xxxx</td>
                                    <td class="border border-black">Yes/No</td>
                                    <td class="border border-black">Office Code</td>
                                    <td class="border border-black">Last Office Code</td>
                                    <td class="border border-black">Document Title</td>
                                    <td class="border border-black">Document Type</td>
                                    <td class="border border-black">Latest Action</td>
                                    <td class="border border-black">Latest Remarks</td>
                                    <td class="border border-black">
                                        <button type="submit" class="size-11/12 p-1 font-bold text-white rounded-md bg-[#bf9b30] hover:bg-[#8C6B0A]">
                                            <a href="/user/view-document">View</a>
                                        </button>
                                        </div>
                                    </td>
                                </tr>
                            {{--@endforeach--}}
                        </tbody>
                        <tbody class="bg-white divide-y divide-gray-200">
                            {{-- @foreach($documents as $document)--}}
                                <tr class="bg-white text-zinc-400 h-12">
                                    <td class="border border-black">xxxx-xxxx-xxxx-xxxx</td>
                                    <td class="border border-black">Yes/No</td>
                                    <td class="border border-black">Office Code</td>
                                    <td class="border border-black">Last Office Code</td>
                                    <td class="border border-black">Document Title</td>
                                    <td class="border border-black">Document Type</td>
                                    <td class="border border-black">Latest Action</td>
                                    <td class="border border-black">Latest Remarks</td>
                                    <td class="border border-black">
                                        <button type="submit" class="size-11/12 p-1 font-bold text-white rounded-md bg-[#bf9b30] hover:bg-[#8C6B0A]">
                                            <a href="/user/view-document">View</a>
                                        </button>
                                        </div>
                                    </td>
                                </tr>
                            {{--@endforeach--}}
                        </tbody>
                        <tbody class="bg-white divide-y divide-gray-200">
                            {{-- @foreach($documents as $document)--}}
                                <tr class="bg-white text-zinc-400 h-12">
                                    <td class="border border-black">xxxx-xxxx-xxxx-xxxx</td>
                                    <td class="border border-black">Yes/No</td>
                                    <td class="border border-black">Office Code</td>
                                    <td class="border border-black">Last Office Code</td>
                                    <td class="border border-black">Document Title</td>
                                    <td class="border border-black">Document Type</td>
                                    <td class="border border-black">Latest Action</td>
                                    <td class="border border-black">Latest Remarks</td>
                                    <td class="border border-black">
                                        <button type="submit" class="size-11/12 p-1 font-bold text-white rounded-md bg-[#bf9b30] hover:bg-[#8C6B0A]">
                                            <a href="/user/view-document">View</a>
                                        </button>
                                        </div>
                                    </td>
                                </tr>
                            {{--@endforeach--}}
                        </tbody>
                        <tbody class="bg-white divide-y divide-gray-200">
                            {{-- @foreach($documents as $document)--}}
                                <tr class="bg-white text-zinc-400 h-12">
                                    <td class="border border-black">xxxx-xxxx-xxxx-xxxx</td>
                                    <td class="border border-black">Yes/No</td>
                                    <td class="border border-black">Office Code</td>
                                    <td class="border border-black">Last Office Code</td>
                                    <td class="border border-black">Document Title</td>
                                    <td class="border border-black">Document Type</td>
                                    <td class="border border-black">Latest Action</td>
                                    <td class="border border-black">Latest Remarks</td>
                                    <td class="border border-black">
                                        <button type="submit" class="size-11/12 p-1 font-bold text-white rounded-md bg-[#bf9b30] hover:bg-[#8C6B0A]">
                                            <a href="/user/view-document">View</a>
                                        </button>
                                        </div>
                                    </td>
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
        src="{{ asset('js/user.js') }}"
        function confirmLogout(url) {
            if (confirm('Are you sure you want to Logout?')) {
                window.location.href = url;
            }
        }
    </script>
</body>
</html>
