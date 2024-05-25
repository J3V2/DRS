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
    <div class="flex h-full">
<!-- Main Content -->
        <div class="flex-none flex flex-row space-x-10 item-center justify-between">
            <div class="sticky inset-y-0 left-0 px-4 w-[600px] h-5/6 mt-8 justify-center relative m-4">
                <h2 class="text-indigo-800 text-4xl font-bold p-4 bg-white">
                    Add Document
                </h2>
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
                        <input type="file" id="file_attach" name="file_attach[]" class="rounded-md text-black bg-slate-200 w-full border-indigo-400 shadow-md shadow-indigo-500 mb-2" onchange="previewFile(this)" multiple><br>

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
            <div id="file_preview_container" class="px-4 w-[800px] h-5/6 mt-8 justify-center relative space-y-4 m-4"></div>
        </div>
    </div>
<!-- Script goes here!! -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.11.3/echo.iife.js"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
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

        function previewFile(input) {
        const previewContainer = document.getElementById('file_preview_container');
        previewContainer.innerHTML = ''; // Clear previous previews

        if (input.files) {
            Array.from(input.files).forEach(file => {
                const reader = new FileReader();

                // Read the file and generate a preview
                reader.onload = function(e) {
                    const filePreview = document.createElement('div');
                    filePreview.className = 'file-preview';
                    const fileType = file.name.split('.').pop().toLowerCase();
                    if (['jpg', 'jpeg', 'png', 'gif'].includes(fileType)) {
                        filePreview.innerHTML = `<img src="${e.target.result}" alt="File Preview" class="preview-image" width="700" height="500">`;
                    } else if (['docx', 'pdf', 'xlsx', 'xls'].includes(fileType)) {
                        filePreview.innerHTML = `<embed src="${e.target.result}" type="application/${fileType}" width="700" height="500"/>`;
                    } else {
                        filePreview.innerHTML = `<p>${file.name}</p>`; // Display file name for unsupported types
                    }
                    previewContainer.appendChild(filePreview);
                };

                reader.readAsDataURL(file);
            });
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOMContentLoaded event fired');

        fetchNotifications();

        const echo = new Echo({
            broadcaster: 'pusher',
            key: '{{ env('PUSHER_APP_KEY') }}',
            cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
            forceTLS: true,
            encrypted: true,
            disableStats: true,
        });

        console.log('Echo initialized', echo);

        @if(auth()->check() && auth()->user()->office)
            const officeChannel = echo.private('office.{{ auth()->user()->office->id }}');
            console.log('Listening to private office channel:', 'office.{{ auth()->user()->office->id }}');

            officeChannel.listen('DocumentReleased', (e) => {
                console.log('DocumentReleased event received:', e);
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
        console.log('toggleDropdown called');
        const dropdown = document.querySelector('.notification-dropdown');
        dropdown.classList.toggle('hidden');
    }

    function fetchNotifications() {
        console.log('fetchNotifications called');
        fetch('/notifications')
            .then(response => {
                console.log('fetch /notifications response:', response);
                return response.json();
            })
            .then(data => {
                console.log('fetch /notifications data:', data);
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
        console.log('markNotificationAsRead called for notification ID:', notificationId);
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
            console.log('markNotificationAsRead response:', data);
            if (data.success) {
                console.log('Notification marked as read.');
            }
        });
    }

    function addNotification(notification) {
        console.log('addNotification called with:', notification);
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
