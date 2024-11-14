<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
    <style>
        /* Estilos para un diseño minimalista, colorido y con esquinas cuadradas */
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            color: #333;
            margin: 0;
            padding: 0;
        }
        #loginBanner img {
            object-fit: cover;
            height: 100vh;
            width: 100%;
            cursor: pointer;
        }
        .login-form {
            background-color: #ffffff;
            max-width: 400px;
            width: 100%;
            padding: 2rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            transition: 0.3s ease;
            text-align: center;
        }
        .welcome-text {
            font-size: 1.5rem;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 1.5rem;
        }
        .form-group label {
            color: #333;
            font-weight: bold;
        }
        .form-control {
            border-radius: 4px; /* Esquinas cuadradas */
            border: 1px solid #ccc;
            padding: 10px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }
        .form-control:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: none;
        }
        .form-text {
            font-size: 0.875rem;
            color: #777;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            padding: 10px 20px;
            font-size: 1rem;
            transition: background-color 0.3s ease;
            width: 100%;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        #loginContainer {
            display: none;
            height: 100vh;
            align-items: center;
            justify-content: center;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>

<div id="loginBanner">
    <div class="login-banner">
        <img src="{{asset('assets/images/login-banner1.jpg')}}" alt="Banner de inicio de sesión">
    </div>
</div>

<div id="loginContainer" class="d-flex">
    <form id="{{route('validateCredentials')}}" method="POST" class="login-form">
        @csrf
        <div class="welcome-text">Bienvenido a Financify</div>
        <div class="form-group">
            <label for="exampleInputEmail1">Correo electrónico</label>
            <input name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Correo electrónico">
            <small id="emailHelp" class="form-text">Nunca compartiremos tu correo con nadie más.</small>
        </div>
        <div class="form-group mt-3">
            <label for="exampleInputPassword1">Contraseña</label>
            <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Contraseña">
        </div>
        <div class="d-flex justify-content-center mt-4">
            <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
        </div>
        <small class="form-text text-muted mt-3 text-center">
            ¿Aún no tienes una cuenta? <a href="{{route('registerView')}}">Regístrate</a>
        </small>
        @if (session('message'))
            <div class="alert alert-danger mt-3">
                {{ session('message') }}
            </div>
            <script>
                $('#loginBanner').slideUp(0);
                $('#loginContainer').show(0);
            </script>
        @endif
    </form>
</div>

<script>
    $(document).ready(function() {
        // Mostrar el formulario al hacer clic en cualquier parte del banner
        $('#loginBanner').click(function () {
            $('#loginBanner').slideUp(500);
            $('#loginContainer').fadeIn(500);
        });
    });
</script>
</body>
</html>
