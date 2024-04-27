<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-...." crossorigin="anonymous" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    @vite(['resources/css/admin.css','resources/js/admin.js'])
    <title>Offices</title>
</head>

<body>
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
    <div class="flex h-auto">
        <div class="w-52 bg-red-800 shadow-lg text-white">
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
                    <a href="{{route('admin-settings')}}" class="flex items-center gap-x-2 text-sm mt-20 bg-red-800 hover:bg-red-900 w-full px-5 py-1">
                        <span class="material-icons-sharp text-base">
                            settings
                        </span>
                        <h3 class="text-xs">Settings</h3>
                    </a>
                    <a href="javascript:void(0);" class="flex items-center gap-x-2 text-sm mt-1 bg-red-800 hover:bg-red-900 w-full px-5 py-1" onclick="confirmLogout('/logout')">
                        <span class="material-icons-sharp text-base">
                            logout
                        </span>
                        <h3 class="text-xs">Logout</h3>
                    </a>
                    <a href="{{route('admin-guides')}}" class="flex items-center gap-x-2 text-sm mt-1 bg-red-800 hover:bg-red-900 w-full px-5 py-1">
                        <span class="material-icons-sharp text-base">
                            question_mark
                        </span>
                        <h3 class="text-xs">DRS Guide</h3>
                    </a>
                </ul>
            </div>
        </div>

<!-- Main Content -->
        <div class="flex-auto flex flex-col">
            <div class="max-w-7xl bg-white mx-auto px-4 sm:px-6 lg:px-8 h-auto w-11/12 mt-8 rounded-md shadow-md shadow-slate-500 relative m-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
                <div class="flex items-center justify-between p-4">
                    <h2 class="text-indigo-800 font-bold text-4xl">Document Types</h2>
                    <form action="{{ route('admin-types') }}" method="GET" class="flex items-center">
                        <div class="relative ml-28 top-3">
                            <input class="rounded-full bg-slate-300 text-black h-8 w-64 px-10 pr-4 border border-black shadow-md shadow-slate-500" type="text" name="search" placeholder="Search for ...">
                            <button type="submit">
                                <span class="material-icons-sharp absolute inset-y-0 left-1 ml-1 mt-1 text-black">
                                    search
                                </span>
                            </button>
                        </div>
                        <select name="category" class="ml-4 p-1 h-8 w-32 border border-black rounded-r bg-slate-300 text-black shadow-md shadow-slate-500">
                            <option value="name" class="bg-slate-200 text-black">Name</option>
                            <option value="description" class="bg-slate-200 text-black">Description</option>
                        </select>
                        <select name="order" class="ml-4 p-1 h-8 w-w-[120px] border border-black rounded-r bg-slate-300 text-black shadow-md shadow-slate-500">
                            <option value="asc" class="bg-slate-200 text-black">Ascending</option>
                            <option value="desc" class="bg-slate-200 text-black">Descending</option>
                        </select>
                    </form>
                    <div class="items-center">
                        <button class="ml-8 w-24 p-1 hover:p-2 hover:font-bold border border-gray-400 rounded-md bg-slate-200 hover:bg-green-300 text-slate-500 hover:text-green-900 shadow-md hover:shadow-xl shadow-slate-500 hover:shadow-green-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500" onclick="document.getElementById('add').style.display='block'" type="button">Add Type</button>
                    </div>
                </div>
            </div>
            <!-- Messages -->
            @if ($errors->any())
                <div class="alert alert-danger relative bg-red-300 text-red-800 font-bold text-base p-1 w-full">
                    <ul>
                        <h2 class="pl-12">Type not added successfully due to various reason(s):</h2>
                        @foreach ($errors->all() as $error)
                            <li class="pl-16">->{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('success'))
                    <div class="alert alert-success relative bg-green-300 text-green-800 font-bold text-base p-1 w-full">
                        {{ session('success') }}
                    </div>
            @endif

            <div class="max-w-7xl bg-white mx-auto px-4 sm:px-6 lg:px-8 h-auto w-11/12 mt-8 rounded-md shadow-md shadow-slate-500 relative m-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
            
                <div class="overflow-auto max-h-96 w-[985px] self-center text-center mt-8 mb-4">
                
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-red-700">
                            <tr>
                                <th scope="col" class="border border-black">Type Name</th>
                                <th scope="col" class="border border-black">Type Description</th>
                                <th scope="col" class="border border-black">Created at</th>
                                <th scope="col" class="border border-black">Updated at</th>
                                <th scope="col" class="border border-black">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($types as $type)
                                <tr class="bg-white text-black h-10">
                                    <td class="border border-black">{{$type->name}}</td>
                                    <td class="border border-black">{{$type->description}}</td>
                                    <td class="border border-black">{{$type->created_at}}</td>
                                    <td class="border border-black">{{$type->updated_at}}</td>
                                    <td class="border border-black">
                                        <div class="flex space-x-1 font-bold text-black">
                                            <button type="submit" class="size-11/12 p-1 rounded-md bg-[#bf9b30] hover:bg-[#8C6B0A]">
                                                <a href="/admin/document-types/edit/{{ $type->id }}">Edit</a>
                                            </button>
                                            <button type="submit" class="size-11/12 p-1 rounded-md bg-red-700 hover:bg-red-900" onclick="confirmDelete('/admin/document-types/delete/{{ $type->id }}')">Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- Pagination Links -->
                    <div class="mt-4">
                        {{ $types->appends(['search' => request('search'), 'category' => request('category'), 'order' => request('order')])->links('vendor.pagination.tailwind') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- Add Modal Content -->
    <div id="add" class="fixed inset-0 w-auto h-auto bg-[#474e5d] flex items-center justify-center z-10 hidden">
        <div class="relative bg-white rounded-lg shadow-lg p-8 w-auto mt-14">
            <span onclick="document.getElementById('add').style.display='none'" class="close text-3xl text-black cursor-pointer absolute top-0 right-0 p-4" title="Exit">&times;</span>
            <form class="space-y-4" action="{{ route('addType') }}" method="POST">
            @csrf
                <div>
                    <div class="flex flex-row md:flex-row items-center text-center md:ml-[400px]">
                        <img src="{{ asset('images/PLM_LOGO.png') }}" alt="PLM Logo" class="mb-4 w-20 h-20">
                        <div class="flex flex-col md:flex-col">
                            <h2 class="text-lg md:text-xl font-bold text-[#bf9b30] ml-6 mb-2">
                                Pamantasan ng Lungsod ng Maynila
                            </h2>
                            <h2 class="text-md md:text-sm font-bold text-indigo-800 mb-4">
                                    Document Routing System
                            </h2>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <span class="material-icons-sharp text-3xl">person_outline</span>
                        <h2 class="text-xl text-indigo-800 md:text-2xl font-bold ml-2">Add Document Type</h2>
                    </div>

                    <label for="name" class="text-indigo-800 font-bold text-md">Type Name</label><br>
                    <input type="text" id="code" name="name" class="rounded-full bg-slate-200 text-black w-full pl-3 shadow-md shadow-slate-500 mb-1" required><br>

                    <label for="description" class="text-indigo-800 font-bold text-md">Type Description</label><br>
                    <textarea rows="4" cols="40" id="description" name="description" class="rounded resize-none bg-slate-200 text-black w-full pl-3 shadow-md shadow-slate-500 mb-1" required></textarea>
                
                </div>
                <div class="flex justify-end">
                    <button type="button" onclick="document.getElementById('add').style.display='none'" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Cancel</button>
                    <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">Add Document Type</button>
                </div>
            </form>
        </div>
    </div>
<!-- Script goes here!! -->
    <script>
        src="{{ asset('js/admin.js') }}"
        function confirmDelete(url) {
            if (confirm('Are you sure you want to delete this Document Type?')) {
                window.location.href = url;
            }
        }
        function confirmLogout(url) {
            if (confirm('Are you sure you want to Logout?')) {
                window.location.href = url;
            }
        }
    </script>
</body>
</html>