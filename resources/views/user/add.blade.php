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
    <title>Add Document</title>
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
        <h2 id="realTime" class="text-xl font-bold text-indigo-800"></h2>
    </div>

    <!-- Notifications -->
    <div class="notification-container relative inline-block">
        @php
            $unreadCount = \App\Models\Notification::where('user_id', auth()->id())
                ->whereNull('read_at')
                ->count();
            $notifications = \App\Models\Notification::where('user_id', auth()->id())
                ->orderBy('triggered_at', 'desc')
                ->get();
        @endphp
        <button class="notification-button relative" onclick="toggleDropdown()">
            <span class="material-icons-sharp text-2xl">notifications</span>
            @if ($unreadCount > 0)
                <span class="notification-dot absolute top-0 right-0 w-4 h-4 bg-red-500 rounded-full flex items-center justify-center text-white text-xs">{{$unreadCount}}</span>
            @endif
        </button>
        <div class="notification-dropdown overflow-auto hidden absolute w-80 max-h-96 rounded-lg border-2 bg-white shadow-lg min-w-max z-10">
            <!-- Mark as Read Button -->
            <div class="text-right px-4 py-2 hover:bg-zinc-200">
                <form id="mark-as-read-form" action="{{ route('notifications.markAsRead') }}" method="POST">
                    @csrf
                    @foreach ($notifications as $notification)
                        <input type="hidden" name="notification_ids[]" value="{{ $notification->id }}">
                    @endforeach
                    <button type="submit" class="text-xs text-blue-600 hover:underline focus:outline-none">Mark all as Read</button>
                </form>
            </div>
            <div class="py-1 divide-y divide-dotted" id="notification-list">
                @foreach ($notifications as $notification)
                    <!-- Notification Content -->
                    <div class="overflow-y-auto px-4 py-2 text-sm text-gray-700 hover:bg-zinc-200 {{ is_null($notification->read_at) ? 'text-red-600' : 'text-indigo-600' }}">
                        <form id="mark-as-read-form" action="{{ route('notifications.markRead') }}" method="POST">
                            @csrf
                            <input type="hidden" name="notification_ids[]" value="{{ $notification->id }}">
                            <!-- Notification Text -->
                            <p class="text-xs text-right">{{ $notification->triggered_at->diffForHumans() }}</p>
                            @php
                                $notificationData = is_array($notification->data) ? $notification->data : json_decode($notification->data, true);
                            @endphp
                            <p class="truncate">{{ $notificationData['tracking_number'] ?? auth()->user()->name }} - {{ $notificationData['title'] ?? auth()->user()->email }}</p>
                            <p>{{ is_null($notification->type) ? '' : $notification->type }}</p>
                            <p>{{ is_null($notification->action) ? '' : $notification->action }}</p>
                            <p>{{ $notificationData['event_type'] }}</p>
                            <div class="text-center px-4">
                                <button type="submit" class="text-xs text-blue-600 hover:underline focus:outline-none">Mark as read</button>
                            </div>
                        </form>
                    </div>
                @endforeach
                <!-- View Office Documents Link -->
                <a href="{{ route('user-office-docs') }}" class="block text-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:underline focus:outline-none sticky bottom-0 bg-white border-t-2 border-gray-200">View Office Documents</a>
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
        <div class="dropdown-content hidden absolute bg-gray-200 right-0 rounded-md w-32 text-right shadow-lg z-10">
            <h2 class="text-black p-2 block hover:bg-gray-300">{{ auth()->user()->email }}</h2>
            <h2 class="text-black p-2 block hover:bg-gray-300">{{ auth()->user()->office->code }}</h2>
            <h2 class="text-black p-2 block hover:bg-gray-300">Regular User</h2>
        </div>
    </div>
</div>
<!-- Side-bar Navigation -->
    <div class="flex h-full">
<!-- Main Content -->
        @if (session('messege'))
        <div class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-2xl leading-6 font-medium text-green-600" id="modal-title">
                                    Notifications
                                </h3>
                                <div class="mt-2">
                                    <p class="text-md text-gray-500">{{ session('messege') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm" onclick="closeModal()">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endif
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

        function closeModal() {
            document.querySelector('.fixed.z-10.inset-0.overflow-y-auto').style.display = 'none';
        }

        function toggleDropdown() {
            const dropdown = document.querySelector('.notification-dropdown');
            dropdown.classList.toggle('hidden');
        }

        function markNotificationsAsRead(notificationIds) {
            const form = document.getElementById('mark-as-read-form');
            form.notification_ids.value = notificationIds.join(',');
            form.submit();
        }
    </script>
</body>
</html>
