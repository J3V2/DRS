<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tracking Number</title>
    <style>
        td {
            width: 20.00%;
            background-color: #ADD8E6;
            border-radius: 1px;
            padding: 4px;
            text-align: left;
            font-size: 20px;
        }
    </style>
</head>
<body>
    <table>
        <tr>
            @foreach ($trackingNumbers as $trackingNumber)
            <td>
                <h1 style="font-size: 17px; color: black; font-weight: large;">{{ $trackingNumber->tracking_number }}</h1>
                <h1 style="font-size: 10px; color: black; font-weight: large;">From: {{ $office }}</h1>
            </td>
            @if ($loop->iteration % 4 == 0)
            </tr><tr>
            @endif
            @endforeach
        </tr>
    </table>
</body>
</html>
