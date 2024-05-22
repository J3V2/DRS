<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paper Trail</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border-bottom: 1px solid #000000;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="text-center mb-8 p-5">
        <div class="flex flex-row md:flex-row items-center justify-center">
            <div class="flex flex-col md:flex-col">
                <h2 class="text-2xl font-bold ml-6 mb-2">
                    Pamantasan ng Lungsod ng Maynila
                </h2>
                <h2 class="text-xl font-bold mb-4">
                    Document Routing System
                </h2>
                <h2 class="text-l font-bold mb-4">
                    DRS Users Reports
                </h2>
            </div>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full table-auto items-center">
            <thead class="items-center">
                <tr>
                    <th scope="col" class="border border-black">Office Name</th>
                                <th scope="col" class="border border-black">Office Code</th>
                                <th scope="col" class="border border-black">Users</th>
                                <th scope="col" class="border border-black">Ave.Processing Time</th>
                                <th scope="col" class="border border-black"># of Documents Created</th>
                                <th scope="col" class="border border-black"># of Documents Received</th>
                                <th scope="col" class="border border-black"># of Documents Released</th>
                                <th scope="col" class="border border-black"># of Documents Terminal</th>
                </tr>
            </thead>
            <tbody class="items-center">
                @foreach($users as $user)
                    <tr>
                        <td class="border border-black">{{$user->office->name}}</td>
                        <td class="border border-black">{{$user->office->code}}</td>
                        <td class="border border-black">{{$user->name}}</td>
                        <td class="border border-black">{{$user->AvgProcessTime}}</td>
                        <td class="border border-black">{{ $user->documents_created_count }}</td>
                        <td class="border border-black">{{ $user->documents_received_count }}</td>
                        <td class="border border-black">{{ $user->documents_released_count }}</td>
                        <td class="border border-black">{{ $user->documents_terminal_count }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <h2 class="text-xs">
            Printed by {{auth()->user()->email}} on <?php echo date('Y-m-d H:i:s A'); ?>
        </h2>
    </div>
</body>
</html>
