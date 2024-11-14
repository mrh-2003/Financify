<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield("title")</title>
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/styles.css')}}">
    <script src="https://kit.fontawesome.com/7d0f24146e.js" crossorigin="anonymous"></script>
    @stack("head")
    <style>
        /* Estilos de barra de navegación */
        .navbar {
            background-color: #007bff; /* Color principal azul */
        }
        .navbar-brand {
            font-weight: bold;
            color: #ffffff;
            font-size: 1rem; /* Tamaño de fuente uniforme */
        }
        .nav-link {
            color: #ffffff;
            font-weight: 500;
            font-size: 1rem; /* Tamaño de fuente uniforme */
            transition: color 0.3s ease;
            display: flex;
            align-items: center; /* Centrado vertical */
            height: 100%; /* Para asegurar el centrado en la barra */
        }
        .nav-link:hover {
            color: #99c3ff; /* Color de hover más claro para complementar el azul */
        }
        .navbar-toggler {
            border: none;
        }
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='30' height='30' viewBox='0 0 16 16'%3E%3Cpath fill='%23fff' d='M1.5 2.75h13a.75.75 0 0 0 0-1.5h-13a.75.75 0 0 0 0 1.5zm0 5.25h13a.75.75 0 0 0 0-1.5h-13a.75.75 0 0 0 0 1.5zm0 5.25h13a.75.75 0 0 0 0-1.5h-13a.75.75 0 0 0 0 1.5z'/%3E%3C/svg%3E");
        }
        .nav-item .active, .nav-item .nav-link.active {
            color: #b3d9ff !important; /* Color activo complementario al azul */
        }
        .spacer {
            flex-grow: 1;
        }
        .logout-button {
            color: #ffffff;
            font-weight: 500;
            font-size: 1rem; /* Tamaño de fuente uniforme */
            transition: color 0.3s ease;
            background: none;
            border: none;
            display: flex;
            align-items: center; /* Centrado vertical */
        }
        .logout-button:hover {
            color: #99c3ff; /* Color de hover en combinación con el azul */
        }
        .nav-link i, .logout-button i {
            margin-right: 5px; /* Espacio entre el icono y el texto */
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><i class="fa-solid fa-piggy-bank"></i> Financify</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 w-100">
                <li class="nav-item">
                    <a class="nav-link @yield('link1')" href="{{route('listBillfold')}}" aria-current="page">
                        <i class="fa-solid fa-wallet"></i> Mis Carteras
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @yield('link2')" href="{{route('addBillfold')}}">
                        <i class="fa-solid fa-plus-circle"></i> Agregar Cartera
                    </a>
                </li>

                <div class="spacer"></div>

                <li class="nav-item">
                    <span class="nav-link active">
                        <i class="fa-solid fa-user"></i> {{ $_SESSION['userName'] }}
                    </span>
                </li>

                <li class="nav-item">
                    <form action="{{route('logout')}}" method="POST" style="display:inline;" onsubmit="return confirmLogout();">
                        @csrf
                        <button class="logout-button" type="submit">
                            <i class="fa-solid fa-right-from-bracket"></i> Cerrar Sesión
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
@yield("body")

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
    function confirmLogout() {
        return confirm("¿Estás seguro de que deseas cerrar sesión?");
    }
</script>
@stack("scripts")
</body>
</html>
