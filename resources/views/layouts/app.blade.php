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

    <!-- Modales de Auth -->
    @guest
        <x-login-modal />
        <x-register-modal />
    @endguest

    <script>
        function openModal(id) {
            const modal = document.getElementById(id);
            if (modal) {
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
        }

        function closeModal(id) {
            const modal = document.getElementById(id);
            if (modal) {
                modal.classList.add('hidden');
                
                // Verificar si hay otros modales abiertos antes de reactivar scroll
                const loginModal = document.getElementById('loginModal');
                const registerModal = document.getElementById('registerModal');
                
                const isLoginOpen = loginModal && !loginModal.classList.contains('hidden');
                const isRegisterOpen = registerModal && !registerModal.classList.contains('hidden');
                
                if (!isLoginOpen && !isRegisterOpen) {
                    document.body.style.overflow = 'auto';
                }
            }
        }

        // Cerrar al hacer click fuera del modal (opcional pero recomendado)
        window.onclick = function(event) {
            const loginModal = document.getElementById('loginModal');
            const registerModal = document.getElementById('registerModal');
            
            if (event.target == loginModal) closeModal('loginModal');
            if (event.target == registerModal) closeModal('registerModal');
        }
    </script>
</body>
</html>
