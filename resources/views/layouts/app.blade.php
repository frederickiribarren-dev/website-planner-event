<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PlannerEvents</title>
    @vite('resources/css/app.css')
</head>
<body class="antialiased text-gray-900 bg-white min-h-screen flex flex-col">
    <header>
        <x-header/>
    </header>

    <x-navbar />
    
    <!-- Aquí se inyectará el contenido de cada página -->
    <main>
        @yield('content')
    </main>

    <x-footer />
</body>
</html>
