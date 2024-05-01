<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tracking Number</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
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
        <h2 class="text-xl">Tracking Numbers</h2>
    </div>
    <ul class="text-md">
        @foreach ($trackingNumbers as $trackingNumber)
            <li>{{ $trackingNumber->tracking_number }} - {{ $trackingNumber->status }}</li>
        @endforeach
    </ul>
</body>
</html>
