<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-...." crossorigin="anonymous" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    @vite(['resources/css/admin.css','resources/js/admin.js'])
    <title>System Logs</title>
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

    <div class="ml-2 right-32">
        <a href="{{ url('/chatify') }}?id={{ auth()->id() }}" class="text-black px-4 py-2 rounded-md"><span class="material-icons-sharp">insert_comment</span></a>
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

<!-- Main Content -->
        <div class="flex-auto flex flex-col">
            <div class="flex bg-white mt-8 rounded-md shadow-md shadow-slate-500 mx-10 w-[1200px]">
                <div class="flex px-2 m-4">
                    <h2 class="text-indigo-800 font-bold text-4xl -ml-2 ">System Logs</h2>
                    <form action="{{ route('admin-logs') }}" method="GET" class="flex items-center ml-10">
                        <div class="relative">
                            <input class="rounded-full bg-slate-300 text-black h-8 w-64 px-10 pr-4 border border-black shadow-md shadow-slate-500" type="text" name="search" placeholder="Search for a ...">
                            <span class="material-icons-sharp absolute inset-y-0 left-1 ml-1 mt-1 text-black">
                                search
                            </span>
                        </div>
                        <select name="category" class="ml-8 p-1 h-8 w-38 border border-black rounded-r bg-slate-300 text-black shadow-md shadow-slate-500">
                            <option value="type" class="bg-slate-200 text-black">Users</option>
                            <option value="action" class="bg-slate-200 text-black">Office</option>
                            <option value="OriginatingOffice" class="bg-slate-200 text-black">Timestamps</option>
                            <option value="type" class="bg-slate-200 text-black">Event Type</option>
                            <option value="action" class="bg-slate-200 text-black">Details</option>
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
                                <th scope="col" class="border border-black">User</th>
                                <th scope="col" class="border border-black">Office</th>
                                <th scope="col" class="border border-black">Timestamps</th>
                                <th scope="col" class="border border-black">Event Type</th>
                                <th scope="col" class="border border-black">Details</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            {{-- @foreach($users as $user) --}}
                                    <tr class="bg-white text-black h-10">
                                    <td class="border border-black">Test_User</td>
                                    <td class="border border-black">TEST</td>
                                    <td class="border border-black">2024-03-30 02:00:42 2024-04-01 06:38:48</td>
                                    <td class="border border-black">Login</td>
                                    <td class="border border-black">'Login Successfully'</td>
                                </tr>
                            {{-- @endforeach --}}
                        </tbody>
                        <tbody class="bg-white divide-y divide-gray-200">
                            {{-- @foreach($users as $user) --}}
                                    <tr class="bg-white text-black h-10">
                                    <td class="border border-black">Test_User</td>
                                    <td class="border border-black">TEST</td>
                                    <td class="border border-black">2024-03-30 02:00:42 2024-04-01 06:38:48</td>
                                    <td class="border border-black">Tag as Terminal</td>
                                    <td class="border border-black">'Document Tag as Terminal'</td>
                                </tr>
                            {{-- @endforeach--}}
                        </tbody>
                        <tbody class="bg-white divide-y divide-gray-200">
                            {{-- @foreach($users as $user) --}}
                                    <tr class="bg-white text-black h-10">
                                    <td class="border border-black">Test_User</td>
                                    <td class="border border-black">TEST</td>
                                    <td class="border border-black">2024-03-30 02:00:42 2024-04-01 06:38:48</td>
                                    <td class="border border-black">Receive</td>
                                    <td class="border border-black">'Document Receive'</td>
                                </tr>

                        </tbody>
                        <tbody class="bg-white divide-y divide-gray-200">
                            {{-- @foreach($users as $user) --}}
                                    <tr class="bg-white text-black h-10">
                                    <td class="border border-black">Test_User</td>
                                    <td class="border border-black">TEST</td>
                                    <td class="border border-black">2024-03-30 02:00:42 2024-04-01 06:38:48</td>
                                    <td class="border border-black">Release</td>
                                    <td class="border border-black">'Document Release'</td>
                                </tr>

                        </tbody>
                        <tbody class="bg-white divide-y divide-gray-200">

                                    <tr class="bg-white text-black h-10">
                                    <td class="border border-black">Test_User</td>
                                    <td class="border border-black">TEST</td>
                                    <td class="border border-black">2024-03-30 02:00:42 2024-04-01 06:38:48</td>
                                    <td class="border border-black">Create</td>
                                    <td class="border border-black">'Document Created'</td>
                                </tr>

                        </tbody>
                    </table>
                    {{-- Pagination Links
                    <div class="mt-4">
                        {{ $users->appends(['search' => request('search'), 'category' => request('category'), 'order' => request('order')])->links('vendor.pagination.tailwind') }}
                    </div> --}}
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

        function chatPage(url) {
            window.location.href = url;
        }
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
