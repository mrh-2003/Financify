<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrar</title>
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
    <style>
        /* Estilos para un diseño minimalista y moderno */
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            color: #333;
            margin: 0;
            padding: 0;
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
        .form-title {
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
            display: flex;
            height: 100vh;
            align-items: center;
            justify-content: center;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>
<div id="loginContainer">
    <div class="d-flex justify-content-center flex-column w-100 align-content-center align-items-center">
        <div class="form-title">Únete a la Familia Financify</div>
        <form id="register-form" action="{{route('register')}}" method="POST" class="login-form p-3 rounded-3">
            @csrf
            <div class="form-group">
                <label for="nameInput">Nombres</label>
                <input name="name" class="form-control" id="nameInput" aria-describedby="nameHelp" placeholder="Juan Pérez" required>
            </div>
            <div class="form-group mt-3">
                <label for="rucInput">RUC</label>
                <input name="ruc" class="form-control" id="rucInput" aria-describedby="rucHelp" placeholder="10123456789" required>
            </div>
            <div class="form-group mt-3">
                <label for="emailInput">Correo electrónico</label>
                <input name="email" class="form-control" id="emailInput" aria-describedby="emailHelp" placeholder="juan.perez@example.com" required>
                <small id="emailHelp" class="form-text text-muted">Nunca compartiremos tu correo con nadie más.</small>
            </div>
            <div class="form-group mt-3">
                <label for="passwordInput">Contraseña</label>
                <input type="password" name="password" class="form-control" id="passwordInput" placeholder="********" required>
            </div>
            <div class="form-group mt-3">
                <label for="confirmPasswordInput">Confirmar Contraseña</label>
                <input type="password" name="confirm-password" class="form-control" id="confirmPasswordInput" placeholder="********" required>
                <small id="password-help" class="form-text text-muted" style="display: none; color: orangered !important;">La contraseña no coincide</small>
            </div>
            <div class="d-flex justify-content-center mt-4">
                <button id="send-button" type="submit" class="btn btn-primary" disabled>Registrar</button>
            </div>
            @if (session('message'))
                <div class="alert alert-danger mt-3">
                    {{ session('message') }}
                </div>
            @endif
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#register-form').on('input', function() {
            // Habilitamos o deshabilitamos el botón de envío según la validez del formulario
            $('#send-button').prop('disabled', !this.checkValidity());
            if (!validateInputs()) return;
            validatePassword();
        });

        function validateInputs(){
            let name = $('#nameInput').val();
            let ruc = $('#rucInput').val();
            let pass = $('#passwordInput').val();
            let cPass = $('#confirmPasswordInput').val();

            if (name.trim() === '' || ruc.trim() === '' || pass.trim() === '' || cPass.trim() === '' ) {
                $('#send-button').prop('disabled', true);
                return false;
            } else return true;
        }

        function validatePassword(){
            let pass = $('#passwordInput').val();
            let cPass = $('#confirmPasswordInput').val();

            if (cPass.length < 1 || (pass === '' && cPass === '')) return;

            if(cPass === '' || (pass !== cPass)) {
                $('#send-button').prop('disabled', true);
                $('#password-help').show();
            } else {
                $('#send-button').prop('disabled', false);
                $('#password-help').hide();
            }
        }
    });
</script>
</body>
</html>
