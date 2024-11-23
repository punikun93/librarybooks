<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="grid grid-cols-[250px_1fr] h-screen">
        <!-- Sidebar -->
        <aside class="bg-white shadow-md">
            @include('admin.sidebar')
        </aside>

        <!-- Main Content -->
        <main class="overflow-y-auto">
            @php
                $username = Auth::user()->Username;
            @endphp
            {{ $slot }}
        </main>
    </div>
</body>
</html>
