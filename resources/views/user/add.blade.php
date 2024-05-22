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

    <!-- Date and Time -->
    <div class="flex items-center">
        <h2 id="realTime" class="text-xl font-bold text-indigo-800">
        </h2>
    </div>

    <div class="ml-2 right-32">
        <a href="{{ url('/chatify') }}?id={{ auth()->id() }}" class="text-black px-4 py-2 rounded-md"><span class="material-icons-sharp">insert_comment</span></a>
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
        <div class="flex-none flex flex-row space-x-10 item-center justify-between">
            <div class="w-auto bg-white flex justify-center text-center ml-12 items-center h-12 rounded-md shadow-md shadow-slate-500 mt-8 ">
                <h2 class="text-indigo-800 text-4xl font-bold p-4">
                    Add Document
                </h2>
            </div>
            <div class="px-4 w-[600px] h-5/6 mt-8 justify-center relative m-4">
                <!-- Messages -->
                @if ($errors->any())
                    <div class="alert alert-danger relative bg-red-300 text-red-800 font-bold text-base w-full">
                        <ul>
                                @foreach ($errors->all() as $error)
                                <li class="pl-4">->{{ $error }}</li>
                                @endforeach
                        </ul>
                    </div>
                @endif
                <form id="documentForm" onsubmit="clearDraft()" class="space-y-4" action="{{route('addDocument')}}" method="POST" enctype="multipart/form-data">
                @csrf
                    <div>
                        <label for="tracking_number" class="text-indigo-800 font-bold text-md">Document Tracking Number</label><br>
                        <input type="text" id="tracking_number" name="tracking_number" value="{{ $tracking_number }}" placeholder="XXXX-XXXX-XXXX-XXXX" class="rounded-md bg-slate-200 text-black w-full pl-3 shadow-md shadow-indigo-500 mb-2" readonly>

                        <label for="title" class="text-indigo-800 font-bold text-md">Document Title</label><br>
                        <input id="title" name="title" placeholder="Title..." class="rounded-md bg-slate-200 text-black w-full pl-3 shadow-md shadow-indigo-500 mb-2" required><br>

                        <label for="type" class="text-indigo-800 font-bold text-md">Document Type</label><br>
                        <select  id="type" name="type" placeholder="Type..." class="js-example-basic-single rounded-md bg-slate-200 text-black w-full pl-3 shadow-md shadow-indigo-500 mb-2" required>
                            @foreach($types as $type)
                                <option value="{{ $type->name }}">{{ $type->name }}</option>
                            @endforeach
                        </select><br>

                        <label for="designated_office" class="text-indigo-800 font-bold text-md">Recipient Office(s)</label><br>
                        <select id="designated_office" name="designated_office[]" class="js-example-basic-multiple rounded-md bg-slate-200 text-black w-full pl-3 shadow-md shadow-indigo-500 mb-2" required multiple>
                            @foreach($offices as $office)
                                <option value="{{ $office->id }}">{{ $office->code }}</option>
                            @endforeach
                        </select><br>


                        <label for="action" class="text-indigo-800 font-bold text-md">Document Action</label><br>
                        <select id="action" name="action" placeholder="Action..." class="js-example-basic-single rounded-md bg-slate-200 text-black w-full pl-3 shadow-md shadow-indigo-500 mb-2" required>
                            @foreach($actions as $action)
                                <option value="{{ $action->name }}">{{ $action->name }}</option>
                            @endforeach
                        </select><br>

                        <label class="text-md font-bold text-indigo-800">File Attachment</label><br>
                        <input type="file" id="file_attach" name="file_attach[]" class="rounded-md text-black bg-slate-200 w-full border-indigo-400 shadow-md shadow-indigo-500 mb-2" onchange="previewFiles(this)" multiple><br>

                        <label for="drive" class="text-indigo-800 font-bold text-md">OneDrive (Optional)</label><br>
                        <input id="drive" name="drive" placeholder="drive..." class="rounded-md bg-slate-200 text-black w-full pl-3 shadow-md shadow-indigo-500 mb-2"><br>

                        <label for="remarks" class="text-indigo-800 font-bold text-md">Remarks</label><br>
                        <textarea rows="5" cols="45" id="remarks" name="remarks" class="rounded-md resize-none bg-slate-200 text-black w-full pl-3 shadow-md shadow-indigo-500 mb-2"></textarea><br>

                    </div>
                    <div class="flex justify-center space-x-4">
                        <button type="button" onclick="saveDraft()" class="mb-4 inline-flex justify-center py-1 px-4 border border-transparent shadow-sm text-xl font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600">Saved as Draft</button>
                        <button type="submit" onclick="return confirmFinalize();" class="mb-4 inline-flex justify-center py-1 px-4 border border-transparent shadow-sm text-xl font-medium rounded-md text-white bg-[#bf9b30] hover:bg-[#8C6B0A] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#bf9b30]">Finalized Document</button>
                    </div>
                </form>
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

        $(document).ready(function(){
            $('.js-example-basic-multiple').select2({
                theme: "classic"
            });
        });

        $(document).ready(function(){
            $('.js-example-basic-single').select2({
                theme: "classic"
            });
        });

        function saveDraft() {
            var form = document.getElementById('documentForm');
            var formData = new FormData(form);
            localStorage.setItem('draftData', JSON.stringify(Object.fromEntries(formData)));
            alert("Document saved as draft successfully.");
        }

        function clearDraft() {
            localStorage.removeItem('draftData');
        }

        $(document).ready(function(){
            var savedData = localStorage.getItem('draftData');
            if (savedData) {
                var data = JSON.parse(savedData);
                for (var key in data) {
                    var element = document.getElementById(key);
                    if (element) {
                        element.value = data[key];
                    }
                }
            }

            $('.js-example-basic-multiple').select2({
                theme: "classic"
            });
            $('.js-example-basic-single').select2({
                theme: "classic"
            });
        });

        function confirmFinalize() {
        // Display the confirmation dialog
            var confirmation = confirm("Are you sure you want to finalize this document?");
            // If the user confirms, return true to proceed with the form submission
            if (confirmation) {
                return true;
            } else {
                // If the user cancels, return false to prevent the form submission
                return false;
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
