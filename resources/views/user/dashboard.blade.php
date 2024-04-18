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
        <div class="w-52 bg-indigo-800 shadow-lg text-white">
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
                        <a href="{{route('user-office-releasing')}}">
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
        <div class="flex flex-auto flex-row justify-around">
            <div class="flex flex-col w-4/12 h-auto bg-white rounded-md p-4 my-8 shadow-2xl shadow-indigo-800">
                <div class="h-auto w-full self-center text-center mt-6 mb-2">
                    <form action="{{route('drs-add')}}" method="get">
                    @csrf
                        <h2 class="text-xl font-bold text-indigo-800 mb-2 border-b-2 text-start border-indigo-800 w-auto">
                            Add Document              
                        </h2>
                        <div class="bg-indigo-100 rounded border border-indigo-400 flex items-center w-auto">
                            <input type="text" id="tracking_number" name="tracking_number" placeholder="XXXX-XXXX-XXXX-XXXX" class="bg-transparent py-1 text-black px-4 focus:outline-none w-full" />
                                <button type="submit" class="w-32 py-2 justify-center bg-indigo-600 text-white font-bold rounded-r border-r border-indigo-700 hover:bg-indigo-800 active:bg-indigo-300 disabled:opacity-50 inline-flex items-center focus:outline-none">
                                    Add
                                </button>
                        </div>
                    </form>
                </div>
                <div class="h-auto w-full self-center text-center mt-2 mb-2">
                    <form action="{{route('drs-receive')}}" method="get">
                    @csrf
                        <h2 class="text-xl font-bold text-indigo-800 mb-2 border-b-2 text-start border-indigo-800 w-auto">
                            Receive Document             
                        </h2>
                        <div class="bg-indigo-100 rounded border border-indigo-400 flex items-center w-full">
                            <input type="text" placeholder="XXXX-XXXX-XXXX-XXXX" class="bg-transparent py-1 text-black px-4 focus:outline-none w-full" />
                                <button class="w-32 py-2 justify-center bg-indigo-600 text-white font-bold rounded-r border-r border-indigo-700 hover:bg-indigo-800 active:bg-indigo-300 disabled:opacity-50 inline-flex items-center focus:outline-none">
                                    Receive
                                </button>
                        </div>
                    </form>
                </div>
                <div class="h-auto w-full self-center text-center mt-2 mb-2">
                    <form action="{{route('drs-release')}}" method="get">
                    @csrf
                        <h2 class="text-xl font-bold text-indigo-800 mb-2 border-b-2 text-start border-indigo-800 w-auto">
                            Release Document             
                        </h2>
                        <div class="bg-indigo-100 rounded border border-indigo-400 flex items-center w-full">
                            <input type="text" placeholder="XXXX-XXXX-XXXX-XXXX" class="bg-transparent py-1 text-black px-4 focus:outline-none w-full" />
                                <button class="w-32 py-2 justify-center bg-indigo-600 text-white font-bold rounded-r border-r border-indigo-700 hover:bg-indigo-800 active:bg-indigo-300 disabled:opacity-50 inline-flex items-center focus:outline-none">
                                    Release
                                </button>
                        </div>
                    </form>
                </div>
                <div class="h-auto w-full self-center text-center mt-2 mb-2">
                    <form action="{{route('drs-track')}}" method="get">
                    @csrf
                        <h2 class="text-xl font-bold text-indigo-800 mb-2 border-b-2 text-start border-indigo-800 w-auto">
                            Track Document             
                        </h2>
                        <div class="bg-indigo-100 rounded border border-indigo-400 flex items-center w-full">
                            <input type="text" placeholder="XXXX-XXXX-XXXX-XXXX" class="bg-transparent py-1 text-black px-4 focus:outline-none w-full" />
                                <button class="w-32 py-2 justify-center bg-indigo-600 text-white font-bold rounded-r border-r border-indigo-700 hover:bg-indigo-800 active:bg-indigo-300 disabled:opacity-50 inline-flex items-center focus:outline-none">
                                    Track
                                </button>
                        </div>
                    </form>
                </div>
                <div class="h-auto w-full self-center text-center mt-4 mb-4">
                    <form action="{{route('drs-tag')}}" method="get">
                    @csrf
                        <h2 class="text-xl font-bold text-indigo-800 mb-2 border-b-2 text-start border-indigo-800 w-auto">
                            Tag as Terminal             
                        </h2>
                        <div class="bg-indigo-100 rounded border border-indigo-400 flex items-center w-full">
                            <input type="text" placeholder="XXXX-XXXX-XXXX-XXXX" class="bg-transparent py-1 text-black px-4 focus:outline-none w-full" />
                                <button class="w-32 py-2 justify-center bg-indigo-600 text-white font-bold rounded-r border-r border-indigo-700 hover:bg-indigo-800 active:bg-indigo-300 disabled:opacity-50 inline-flex items-center focus:outline-none">
                                    Tag
                                </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="w-1/2 h-6/12 bg-white rounded-md p-4 my-8 shadow-2xl shadow-indigo-800">
                <div class="h-auto w-full self-center text-center mt-6 mb-2">
                    <div class="flex justify-center text-xl font-bold text-indigo-800 mb-2 w-auto">
                        <h2 class="border-b-2 border-indigo-800 w-full">
                            Pending Documents              
                        </h2>
                    </div>
                    <div class="text-start bg-gray-300 mb-4">
                        <h2 class="text-md font-bold text-indigo-800">
                            <a href="#" class="ml-6">
                                For Receive:
                            </a>
                        </h2>
                    </div>
                    <div class="flex justify-center w-auto h-auto grid grid-flow-row grid-cols-2 grid-rows-2 gap-x-2 gap-y-4">
                        <div class="bg-indigo-300 rounded-md text-start h-20">
                            <h1 class="text-sm text-black font-medium ml-1.5 mt-1.5">
                                Document:
                                <a href="#" class="font-bold">
                                    Completed Staff Work1
                                </a>
                            </h1>
                            </h1>
                            <h1 class="text-sm text-black font-medium ml-1.5 mt-.5">
                                From:
                                <a href="#" class="font-bold">
                                    College of Law
                                </a>
                            </h1>
                            <div class="text-end mt-4">
                                <h1 class="text-xs text-indigo-900 hover:text-indigo-500 font-medium mr-1.5 ">
                                    <a href="#" class="font-bold">
                                        view Document
                                    </a>
                                </h1>
                            </div>
                        </div>
                        <div class="bg-indigo-300 rounded-md text-start h-20">
                            <h1 class="text-sm text-black font-medium ml-1.5 mt-1.5">
                                Document:
                                <a href="#" class="font-bold">
                                    Completed Staff Work1
                                </a>
                            </h1>
                            </h1>
                            <h1 class="text-sm text-black font-medium ml-1.5 mt-.5">
                                From:
                                <a href="#" class="font-bold">
                                    College of Law
                                </a>
                            </h1>
                            <div class="text-end mt-4">
                                <h1 class="text-xs text-indigo-900 hover:text-indigo-500 font-medium mr-1.5 ">
                                    <a href="#" class="font-bold">
                                        view Document
                                    </a>
                                </h1>
                            </div>
                        </div>
                        <div class="bg-indigo-300 rounded-md text-start h-20">
                            <h1 class="text-sm text-black font-medium ml-1.5 mt-1.5">
                                Document:
                                <a href="#" class="font-bold">
                                    Completed Staff Work1
                                </a>
                            </h1>
                            </h1>
                            <h1 class="text-sm text-black font-medium ml-1.5 mt-.5">
                                From:
                                <a href="#" class="font-bold">
                                    College of Law
                                </a>
                            </h1>
                            <div class="text-end mt-4">
                                <h1 class="text-xs text-indigo-900 hover:text-indigo-500 font-medium mr-1.5 ">
                                    <a href="#" class="font-bold">
                                        view Document
                                    </a>
                                </h1>
                            </div>
                        </div>
                        <div class="bg-indigo-300 rounded-md text-start h-20">
                            <h1 class="text-sm text-black font-medium ml-1.5 mt-1.5">
                                Document:
                                <a href="#" class="font-bold">
                                    Completed Staff Work1
                                </a>
                            </h1>
                            </h1>
                            <h1 class="text-sm text-black font-medium ml-1.5 mt-.5">
                                From:
                                <a href="#" class="font-bold">
                                    College of Law
                                </a>
                            </h1>
                            <div class="text-end mt-4">
                                <h1 class="text-xs text-indigo-900 hover:text-indigo-500 font-medium mr-1.5 ">
                                    <a href="#" class="font-bold">
                                        view Document
                                    </a>
                                </h1>
                            </div>
                        </div>
                    </div>
                    <div class="text-start bg-gray-300 mb-4 mt-9">
                        <h2 class="text-md font-bold text-indigo-800">
                            <a href="#" class="ml-6">
                                For Release:
                            </a>
                        </h2>
                    </div>
                    <div class="flex justify-center w-auto h-auto grid grid-flow-row grid-cols-2 grid-rows-2 gap-x-2 gap-y-4">
                    <div class="bg-indigo-300 rounded-md text-start h-20">
                            <h1 class="text-sm text-black font-medium ml-1.5 mt-1.5">
                                Document:
                                <a href="#" class="font-bold">
                                    Completed Staff Work1
                                </a>
                            </h1>
                            </h1>
                            <h1 class="text-sm text-black font-medium ml-1.5 mt-.5">
                                From:
                                <a href="#" class="font-bold">
                                    College of Law
                                </a>
                            </h1>
                            <div class="text-end mt-4">
                                <h1 class="text-xs text-indigo-900 hover:text-indigo-500 font-medium mr-1.5 ">
                                    <a href="#" class="font-bold">
                                        view Document
                                    </a>
                                </h1>
                            </div>
                        </div>
                        <div class="bg-indigo-300 rounded-md text-start h-20">
                            <h1 class="text-sm text-black font-medium ml-1.5 mt-1.5">
                                Document:
                                <a href="#" class="font-bold">
                                    Completed Staff Work1
                                </a>
                            </h1>
                            </h1>
                            <h1 class="text-sm text-black font-medium ml-1.5 mt-.5">
                                From:
                                <a href="#" class="font-bold">
                                    College of Law
                                </a>
                            </h1>
                            <div class="text-end mt-4">
                                <h1 class="text-xs text-indigo-900 hover:text-indigo-500 font-medium mr-1.5 ">
                                    <a href="#" class="font-bold">
                                        view Document
                                    </a>
                                </h1>
                            </div>
                        </div>
                        <div class="bg-indigo-300 rounded-md text-start h-20">
                            <h1 class="text-sm text-black font-medium ml-1.5 mt-1.5">
                                Document:
                                <a href="#" class="font-bold">
                                    Completed Staff Work1
                                </a>
                            </h1>
                            </h1>
                            <h1 class="text-sm text-black font-medium ml-1.5 mt-.5">
                                From:
                                <a href="#" class="font-bold">
                                    College of Law
                                </a>
                            </h1>
                            <div class="text-end mt-4">
                                <h1 class="text-xs text-indigo-900 hover:text-indigo-500 font-medium mr-1.5 ">
                                    <a href="#" class="font-bold">
                                        view Document
                                    </a>
                                </h1>
                            </div>
                        </div>
                        <div class="bg-indigo-300 rounded-md text-start h-20">
                            <h1 class="text-sm text-black font-medium ml-1.5 mt-1.5">
                                Document:
                                <a href="#" class="font-bold">
                                    Completed Staff Work1
                                </a>
                            </h1>
                            </h1>
                            <h1 class="text-sm text-black font-medium ml-1.5 mt-.5">
                                From:
                                <a href="#" class="font-bold">
                                    College of Law
                                </a>
                            </h1>
                            <div class="text-end mt-4">
                                <h1 class="text-xs text-indigo-900 hover:text-indigo-500 font-medium mr-1.5 ">
                                    <a href="#" class="font-bold">
                                        view Document
                                    </a>
                                </h1>
                            </div>
                        </div>
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
    </script>
</body>
</html>