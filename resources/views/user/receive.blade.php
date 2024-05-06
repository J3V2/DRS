<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-...." crossorigin="anonymous" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
        <div class="flex-none flex flex-row space-x-2 item-center">
            <div class="h-auto justify-center ml-2">
                <div class="mb-6 mt-8">
                    <div class="flex justify-between">
                        <form action="{{ route('drs-release', $document->tracking_number) }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-gray-300 hover:bg-gray-500 text-md text-black m-1 w-32 border rounded-md shadow-md shadow-slate-500">
                                Tag as Terminal
                            </button>
                        </form>
                        <form action="{{ route('drs-release', $document->tracking_number) }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-indigo-300 hover:bg-indigo-500 text-md text-black m-1 w-32 border rounded-md shadow-md shadow-slate-500">
                                Release
                            </button>
                        </form>
                    </div>
                    <table class="w-[400px] border-collapse border border-black text-sm bg-white shadow-md shadow-slate-500">
                        <thead>
                            <tr>
                                <th class="bg-indigo-400">Overview</th>
                                <td class="bg-indigo-400"></td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th class="border border-black text-black text-start pl-4 w-1/3">Tracking Number</th>
                                <td class="border border-black text-black pl-2">{{$document->tracking_number}}</td>
                            </tr>
                            <tr>
                                <th class="border border-black text-black text-start pl-4 w-1/3">Title</th>
                                <td class="border border-black text-black pl-2">{{$document->title}}</td>
                            </tr>
                            <tr>
                                <th class="border border-black text-black text-start pl-4 w-1/3">Type</th>
                                <td class="border border-black text-black pl-2">{{$document->type}}</td>
                            </tr>
                            <tr>
                                <th class="border border-black text-black text-start pl-4 w-1/3">Remarks</th>
                                <td class="border border-black text-black pl-2">{{$document->remarks}}
                                    </td>
                            </tr>
                            <tr>
                                <th class="border border-black text-black text-start pl-4 w-1/3">Originating Office</th>
                                <td class="border border-black text-black pl-2">{{$document->originating_office}}</td>
                            </tr>
                            <tr>
                                <th class="border border-black text-black text-start pl-4 w-1/3">Current Office</th>
                                <td class="border border-black text-black pl-2">{{$document->current_office}}</td>
                            </tr>
                            <tr>
                                <th class="border border-black text-black text-start pl-4 w-1/3">Current Recipient Office</th>
                                <td class="border border-black text-black pl-2">{{$document->designated_office}}</td>
                            </tr>
                            <tr>
                                <th class="border border-black text-black text-start pl-4 w-1/3">Status</th>
                                <td class="border border-black text-black pl-2">{{$document->status}}</td>
                            </tr>

                            <tr>
                                <th class="border border-black text-black text-start pl-4 w-1/3">Action</th>
                                <td class="border border-black text-black pl-2">{{$document->action}}</td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="w-[400px] border-collapse border border-black text-sm bg-white shadow-md shadow-slate-500">
                        <thead>
                            <tr>
                                <th scope="col" class="w-full bg-indigo-400">File</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="border border-black text-black pl-2">{{$document->file_attach}}</td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="w-[400px] border-collapse border border-black text-sm bg-white shadow-md shadow-slate-500 ">
                        <thead>
                            <tr>
                                <th scope="col" class="w-full bg-indigo-400">Drive Link</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="border border-black text-black h-6 pl-2">{{$document->drive}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="flex flex-col text-center w-auto items-center h-12 mt-4">
                <div class="flex flex-col">
                    <div class="bg-white w-auto h-auto text-indigo-800 text-2xl font-bold p-4 rounded-md shadow-md mb-4 shadow-slate-500">
                        <h2>
                            {{$document->type}} - {{$document->title}}
                        </h2>
                    </div>
                </div>
                    @if(session('success'))
                        <div class="alert alert-success relative text-center bg-green-300 text-green-800 font-bold text-base p-1 my-5 w-[850px]">
                            {{ session('success') }}
                        </div>
                    @endif
                    <table class="w-[850px] border-collapse border border-black self-center text-sm bg-white shadow-md shadow-slate-500">
                        <thead>
                            <tr>
                                <th scope="col" class="pl-20 bg-indigo-400">Paper Trail</th>
                                <td class="bg-indigo-400"><button type="submit" class="print-dts-button bg-slate-300 hover:bg-slate-400 text-xs text-black m-1 self-center w-16 border rounded-none shadow-md shadow-slate-500">Print DTS</button></td>
                            </tr>
                        </thead>
                    </table>
                    <table class="w-[850px] border-collapse border border-black text-center self-center text-xs bg-white shadow-md shadow-slate-500">
                        <thead>
                            <tr>
                                <th scope="col" class="border border-black text-black w-[10%]">Office</th>
                                <th scope="col" class="border border-black text-black w-[10%]">In</th>
                                <th scope="col" class="border border-black text-black w-[10%]">Out</th>
                                <th scope="col" class="border border-black text-black w-[10%]">Elapsed Time</th>
                                <th scope="col" class="border border-black text-black w-[10%]">Action</th>
                                <th scope="col" class="border border-black text-black w-[20%]">Remarks</th>
                                <th scope="col" class="border border-black text-black w-[15%]">File</th>
                                <th scope="col" class="border border-black text-black w-[15%]">Drive Link</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($paperTrails as $paperTrail)
                            <tr>
                                <td class="border border-black text-black w-[10%]">{{ $paperTrail->office }}</td>
                                <td class="border border-black text-black w-[10%]">{{ $paperTrail->in_time }}</td>
                                <td class="border border-black text-black w-[10%]">{{ $paperTrail->out_time }}</td>
                                <td class="border border-black text-black w-[10%]">{{ $paperTrail->elapsed_time }}</td>
                                <td class="border border-black text-black w-[10%]">{{ $paperTrail->action }}</td>
                                <td class="border border-black text-black w-[20%]">{{ $paperTrail->remarks }}</td>
                                <td class="border border-black text-black w-[15%]">{{ $paperTrail->file_attach }}</td>
                                <td class="border border-black text-black w-[15%]">{{ $paperTrail->drive }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
            </div>
        </div>
    </div>
<!-- Script goes here!! -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        src="{{ asset('js/user.js') }}"
        function confirmLogout(url) {
            if (confirm('Are you sure you want to Logout?')) {
                window.location.href = url;
            }
        }

        document.querySelector('.print-dts-button').addEventListener('click', function() {
            const documentId = '{{ $document->id }}';
            window.location.href = `/download-paper-trail/${documentId}`;
        });

    </script>
</body>
</html>
