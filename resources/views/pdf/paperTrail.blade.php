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
            </div>
        </div>
    </div>
    <table class="w-full table-fixed">
        <thead>
            <th></th>
            <th></th>
        </thead>
        <tbody>
            <tr>
                <td>
                    <p>TRACKING NUMBER#: {{$document->tracking_number}}</p>
                    <p>OFFICE: {{$document->current_office}}</p>
                    <p>TYPE: {{$document->type}}</p>
                    <p>TITLE: {{$document->title}}</p>
                </td>
                <td>
                    <p>Incoming Tracking Number:________________</p>
                    <p>Date Received:__________________________</p>
                    <p>Received From:_________________________</p>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="overflow-x-auto">
        <table class="w-full table-auto border border-collapse">
            <thead>
                <tr>
                    <th class="py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">DATEIN</th>
                    <th class="py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">DATEOUT</th>
                    <th class="py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">FROM</th>
                    <th class="py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">TO</th>
                    <th class="py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Remarks</th>
                </tr>
            </thead>
            <tbody>
                @foreach($paperTrails as $paperTrail)
                    <tr>
                        <td class="py-4 text-center text-xs">{{ $paperTrail->in_time }}</td>
                        <td class="py-4 text-center text-xs">{{ $paperTrail->out_time }}</td>
                        <td class="py-4 text-center text-xs">{{ $paperTrail->office }}</td>
                        <td class="py-4 text-center text-xs">{{ $paperTrail->remarks }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tbody>
                    <tr>
                        <td class="py-4 text-xs h-32"></td>
                        <td class="py-4 text-xs h-32"></td>
                        <td class="py-4 text-xs h-32"></td>
                        <td class="py-4 text-xs h-32"></td>
                        <td class="py-4 text-xs h-32"></td>
                    </tr>
            </tbody>
            <tbody>
                <tr>
                    <td class="py-4 text-xs h-32"></td>
                    <td class="py-4 text-xs h-32"></td>
                    <td class="py-4 text-xs h-32"></td>
                    <td class="py-4 text-xs h-32"></td>
                    <td class="py-4 text-xs h-32"></td>
                </tr>
            </tbody>
            <tbody>
                <tr>
                    <td class="py-4 text-xs h-32"></td>
                    <td class="py-4 text-xs h-32"></td>
                    <td class="py-4 text-xs h-32"></td>
                    <td class="py-4 text-xs h-32"></td>
                    <td class="py-4 text-xs h-32"></td>
                </tr>
            </tbody>
        </table>
        <h2 class="text-xs">
            Printed by {{$user->email}} on <?php echo date('Y-m-d H:i:s A'); ?>
        </h2>
    </div>
</body>
</html>
