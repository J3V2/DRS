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
        <h2 id="realTime" class="text-xl font-bold text-indigo-800">
        </h2>
    </div>

    <!-- Notifications -->
    <div class="notification-container relative inline-block">
        <button class="notification-button relative" onclick="toggleDropdown()">
            <span class="material-icons-sharp text-2xl">notifications</span>
            <span class="notification-dot absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
        </button>
        <div class="notification-dropdown hidden absolute w-64 rounded-lg border-2 bg-white shadow-lg min-w-max z-10">
            <div class="py-1" id="notification-list">
                <a href="{{ route('user-office-docs') }}" class="block text-center px-4 py-1 text-sm text-gray-700 hover:bg-gray-100">View All Documents</a>
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
        <div class="dropdown-content hidden absolute bg-gray-200 right-0 rounded-md min-w-160 text-right shadow-lg z-10">
            <h2 class="text-black p-2 block hover:bg-gray-300">{{ auth()->user()->email }}</h2>
            <h2 class="text-black p-2 block hover:bg-gray-300">{{ auth()->user()->office->code }}</h2>
            <h2 class="text-black p-2 block hover:bg-gray-300">Regular User</h2>
        </div>
    </div>
</div>
<!-- Side-bar Navigation -->
    <div class="flex">
        <div class="w-64 bg-indigo-800 shadow-lg text-white w-[250px] h-screen">
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
        <div class="flex flex-auto flex-col">
            <div class="flex bg-white w-[1200px] h-auto mt-8 rounded-md shadow-md shadow-slate-500 justify-start mx-10">
                <div class="flex w-auto m-4">
                    <div class="text-start row-span-2">
                        <h2 class="text-indigo-800 font-bold text-4xl">My Tracking Numbers</h2>
                        <h4 class="text-indigo-800 font-semibold text-sm"><a href="{{route('user-my-docs')}}" class="text-sm text-black">My Documents </a><a href="{{route('user-my-numbers')}}"> > My Tracking Numbers</a></h4>
                    </div>
                </div>
            </div>
            <div class="flex bg-white w-[1200px] h-auto mt-8 rounded-md shadow-md shadow-slate-500 justify-center mx-10">
                <div class="flex w-11/12 h-auto self-center text-center m-8">
                    <table class="min-w-full divide-y divide-gray-200 rounded-md shadow-md shadow-slate-500">
                        <thead class="bg-indigo-800 text-white">
                            <tr>
                                <th scope="col" class="border border-black">Unused</th>
                                <th scope="col" class="border border-black">Used</th>
                                <th scope="col" class="border border-black">Invalid</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr class="bg-indigo-300 text-black h-12">
                                <td class="border border-black">{{$unusedTrackingNumbers}}</td>
                                <td class="border border-black">{{$usedTrackingNumbers}}</td>
                                <td class="border border-black">{{$invalidTrackingNumbers}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @if(session('success'))
                <div class="alert alert-success relative text-center bg-green-300 text-green-800 font-bold text-base p-1 w-full">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-error relative text-center bg-red-300 text-red-800 font-bold text-base p-1 w-full">
                    {{ session('error') }}
                </div>
            @endif
            <div class="flex bg-white w-[1200px] h-auto mt-8 rounded-md shadow-md shadow-slate-500 justify-center mx-10">
                <div class="flex h-auto self-center text-center m-4 flex-row space-x-20">
                    <!-- Generate Button -->
                    @if ($unusedTrackingNumbers == null)
                    <form action="{{ route('generate-tracking-numbers') }}" method="get">
                        @csrf
                        <h2 class="text-xl font-bold text-indigo-800 mb-2">
                            Generate Tracking Numbers
                        </h2>
                        <button type="submit" class="w-full py-2 inline-flex items-center justify-center bg-indigo-600 text-white font-bold rounded-md border-md border-indigo-700 hover:bg-indigo-800 active:bg-indigo-300 disabled:opacity-50">
                            <span class="material-icons-sharp inline-block align-middle mr-2">
                                view_week
                            </span>
                            Generate
                        </button>
                    </form>
                    @else
                    <form action="{{ route('generate-tracking-numbers') }}" method="get">
                        @csrf
                        <h2 class="text-xl font-bold text-indigo-800 mb-2">
                            Generate Tracking Numbers
                        </h2>
                        <button type="submit" class="w-full py-2 inline-flex items-center justify-center bg-indigo-600 text-white font-bold rounded-md border-md border-indigo-700 hover:bg-indigo-800 active:bg-indigo-300 disabled:opacity-50" disabled>
                            <span class="material-icons-sharp inline-block align-middle mr-2">
                                view_week
                            </span>
                            Generate
                        </button>
                    </form>
                    @endif

                    <!-- Invalidate Button -->
                    <form action="{{ route('invalidate-tracking-number') }}" method="post">
                        @csrf
                        <h2 class="text-xl font-bold text-indigo-800 mb-2">
                            Invalidate Tracking Number
                        </h2>
                        <div class="bg-indigo-100 rounded border border-indigo-400 flex items-center w-auto">
                            <input type="text" id="invalidate" name="invalidate" placeholder="XXXX-XXXX-XXXX-XXXX" class="bg-transparent py-1 text-sm text-black px-1 focus:outline-none w-full" />
                            <button type="submit" class="w-40 py-2 inline-flex items-center justify-center bg-indigo-600 text-white font-bold rounded-r border-r border-indigo-700 hover:bg-indigo-800 active:bg-indigo-300 disabled:opacity-50">
                                <span class="material-icons-sharp inline-block align-middle mr-2">
                                    cancel
                                </span>
                                Invalidate
                            </button>
                        </div>
                    </form>

                    <!-- Download Button -->
                    <form action="{{ route('download-tracking-numbers') }}" method="get">
                        @csrf
                        <h2 class="text-xl font-bold text-indigo-800 mb-2">
                            Download Tracking Numbers
                        </h2>
                        <button type="submit" class="w-full py-2 inline-flex items-center justify-center bg-indigo-600 text-white font-bold rounded-md border-md border-indigo-700 hover:bg-indigo-800 active:bg-indigo-300 disabled:opacity-50">
                            <span class="material-icons-sharp inline-block align-middle mr-2">
                                cloud_download
                            </span>
                            Download
                        </button>
                    </form>
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
        function updateTime() {
            const now = new Date();
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric', second: 'numeric' };
            const realTime = now.toLocaleString('en-US', options);
            document.getElementById('realTime').textContent = realTime;
        }

        // Update every second
        setInterval(updateTime, 1000);
    </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.11.3/echo.iife.js"></script>
        <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                fetchNotifications();

                const echo = new Echo({
                    broadcaster: 'pusher',
                    key: '{{ env('PUSHER_APP_KEY') }}',
                    cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
                    encrypted: true
                });

                @if(auth()->user()->office)
                    echo.private('office.{{ auth()->user()->office->id }}')
                        .listen('DocumentReleased', (e) => {
                            addNotification({
                                title: 'New document released',
                                time: e.timestamp,
                                source: e.document.title,
                                type: e.document.type
                            });
                        });
                @endif
            });

            function toggleDropdown() {
                const dropdown = document.querySelector('.notification-dropdown');
                dropdown.classList.toggle('hidden');
            }

            function fetchNotifications() {
                fetch('/notifications')
                    .then(response => response.json())
                    .then(data => {
                        const notificationList = document.getElementById('notification-list');
                        notificationList.innerHTML = ''; // Clear current notifications

                        data.forEach(notification => {
                            const notificationItem = document.createElement('a');
                            notificationItem.setAttribute('href', '#');
                            notificationItem.classList.add('notification-item', 'block', 'p-4', 'border-b', 'border-gray-200');
                            notificationItem.innerHTML = `
                                <div class="flex justify-between">
                                    <div>${notification.data.title}</div>
                                    <div class="text-xs text-gray-500">${new Date(notification.created_at).toLocaleTimeString()}</div>
                                </div>
                                <div class="text-sm text-gray-500">${notification.data.type}</div>
                            `;
                            notificationItem.addEventListener('click', function() {
                                markNotificationAsRead(notification.id);
                                notificationItem.remove();
                            });
                            notificationList.appendChild(notificationItem);
                        });

                        const viewAllLink = document.createElement('a');
                        viewAllLink.setAttribute('href', '{{ route('user-office-docs') }}');
                        viewAllLink.classList.add('block', 'text-center', 'px-4', 'py-1', 'text-sm', 'text-gray-700', 'hover:bg-gray-100');
                        viewAllLink.textContent = 'View All Documents';
                        notificationList.appendChild(viewAllLink);
                    });
            }

            function markNotificationAsRead(notificationId) {
                fetch('/notifications/mark-as-read', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ notification_id: notificationId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log('Notification marked as read.');
                    }
                });
            }

            function addNotification(notification) {
                const notificationList = document.getElementById('notification-list');
                const notificationItem = document.createElement('a');
                notificationItem.setAttribute('href', '#');
                notificationItem.classList.add('notification-item', 'block', 'p-4', 'border-b', 'border-gray-200');
                notificationItem.innerHTML = `
                    <div class="flex justify-between">
                        <div>${notification.title}</div>
                        <div class="text-xs text-gray-500">${new Date(notification.time).toLocaleTimeString()}</div>
                    </div>
                    <div class="text-sm text-gray-500">${notification.source}</div>
                    <div class="text-sm text-gray-500">${notification.type}</div>
                `;
                notificationItem.addEventListener('click', function() {
                    notificationItem.remove();
                });
                notificationList.insertBefore(notificationItem, notificationList.firstChild);

                if (notificationList.children.length > 6) { // 5 notifications + "View All Documents" link
                    notificationList.removeChild(notificationList.lastChild.previousSibling);
                }
            }
        </script>
</body>
</html>
