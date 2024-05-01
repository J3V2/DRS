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
                <h2 class="text-lg font-bold  ml-6 mb-2">
                    Pamantasan ng Lungsod ng Maynila
                </h2>
                <h2 class="text-md font-bold mb-4">
                    Document Routing System
                </h2>
            </div>
        </div>
        <h2 class="text-xl">Paper Trail</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full table-auto">
            <thead>
                <tr>
                    <th class="py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Office</th>
                    <th class="py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">In</th>
                    <th class="py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Out</th>
                    <th class="py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Elapsed Time</th>
                    <th class="py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                    <th class="py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Drive Links</th>
                    <th class="py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Remarks</th>
                </tr>
            </thead>
            <tbody>
                @foreach($paperTrails as $paperTrail)
                    <tr>
                        <td class="py-4 text-center text-xs">{{ $paperTrail->office }}</td>
                        <td class="py-4 text-center text-xs">{{ $paperTrail->in_time }}</td>
                        <td class="py-4 text-center text-xs">{{ $paperTrail->out_time }}</td>
                        <td class="py-4 text-center text-xs">{{ $paperTrail->elapsed_time }}</td>
                        <td class="py-4 text-center text-xs">{{ $paperTrail->action }}</td>
                        <td class="py-4 text-center text-xs">{{ $paperTrail->drive }}</td>
                        <td class="py-4 text-center text-xs">{{ $paperTrail->remarks }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
