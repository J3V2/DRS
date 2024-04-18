<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    @vite('resources/css/app.css')
    <title>Reset Password</title>
</head>
<body class="flex items-center justify-center h-screen w-screen bg-gray-200">
    <div class="absolute inset-0 overflow-hidden">
        <img class="object-cover object-center w-full h-full" src="{{ asset('images/DRS_BG.png') }}" alt="DRS BG">
    </div>
    <div class="relative h-auto w-full md:w-1/2 lg:w-1/3 p-8 bg-white rounded-lg shadow-lg">
        @if(session('success'))
            <div class="alert alert-success bg-green-500 text-white p-2 mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger bg-red-500 text-white p-2 mb-4">
                {{ session('error') }}
            </div>
        @endif

        <div class="flex flex-col items-center justify-center">
            <div class="flex flex-col md:flex-row items-center justify-start">
                <img class="mb-4 md:mb-0 w-full md:w-20 h-20" src="{{ asset('images/PLM_LOGO.png') }}" alt="PLM Logo">
                <div class="grid grid-row-2 p-4">
                    <h2 class="text-md md:text-lg font-bold text-yellow-500">PAMANTASAN NG LUNGSOD NG MAYNILA</h2>
                    <h2 class="text-xs md:text-sm pb-4 text-neutral-400">UNIVERSITY OF THE CITY OF MANILA</h2>
                </div>
            </div>
            <h2 class="text-2xl font-bold text-indigo-800 mb-2">PLM Document Routing System</h2>
            <h2 class="text-3xl font-bold text-indigo-800 mb-2">Reset Password</h2>
        </div>
        <form action="{{ route('post-reset-password', ['token' => $token]) }}" method="post" class="flex flex-col items-center justify-center w-full">
        @csrf
            <div class="mb-4 w-full relative">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                <input type="password" id="password" name="password" placeholder="New Password" class="p-2 w-full border rounded-md">
            </div>
            <div class="mb-4 w-full relative">
                <label for="con_password" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                <input type="password" id="con_password" name="con_password" placeholder="Confirm Password" class="p-2 w-full border rounded-md">
            </div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold p-2 w-full border rounded-md">Reset</button>
            <br>
            <a href=" {{ url('') }} " class="text-sky-600">Back ←</a>
        </form>
    </div>
</body>
</html>