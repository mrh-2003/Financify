@extends('layout.base')

@section('link2', 'active')

@section('body')
<div id="loginContainer" class="w-100 d-flex justify-content-center" style="height: 100vh;">

    <div class="d-flex flex-column justify-content-center align-items-center" style="height: 100vh; width: 50%;">
        <h1 class="page-title mb-4 text-center">Nueva Cartera</h1>
        
        <form action="{{ route('addBillfold') }}" method="POST" id="loginForm" class="login-form p-4 rounded-3 w-50">
            @csrf
            <div class="form-group mb-3">
                <label for="nameInput" class="form-label">Nombre</label>
                <input type="text" name="name" class="form-control" id="nameInput" required placeholder="Mi Cartera Nueva">
            </div>

            <div class="form-group mb-3">
                <label for="discountDate" class="form-label">Fecha de descuento</label>
                <input class="form-control" type="date" name="discount_date" id="discountDate" required/>
            </div>

            <div class="d-flex justify-content-center mt-4 gap-3">
                <button type="button" class="btn btn-secondary" onclick="clearForm()">
                    <i class="fa-solid fa-eraser"></i> Limpiar
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-floppy-disk"></i> Guardar
                </button>
                <a href="{{route('listBillfold')}}">
                    <button type="button" class="btn btn-danger">
                        <i class="fa-solid fa-arrow-left"></i> Cancelar
                    </button>
                </a>
            </div>
        </form>

        <div id="response-section" class="card mt-4 w-100" style="display: none;">
            <div class="card-title text-center"><b>Resultado</b></div>
            <div id="response-body" class="card-body"></div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    function clearForm() {
        $('#nameInput').val('');
        $('#discountDate').val('');
    }
</script>
@endpush

<style>
    /* Estilos para mantener el diseño consistente */
    .page-title {
        font-size: 2rem;
        font-weight: bold;
        color: #007bff; /* Color azul consistente */
        margin-bottom: 1rem;
    }
    
    .login-form {
        background-color: #ffffff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        transition: 0.3s ease;
    }

    .form-control {
        border-radius: 4px;
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

    .btn-secondary, .btn-primary, .btn-danger {
        font-size: 1rem;
        padding: 8px 15px;
        font-weight: 500;
        display: flex;
        align-items: center;
    }

    .btn-secondary {
        background-color: #6c757d;
        border: none;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .btn-danger {
        background-color: #dc3545;
        border: none;
    }

    .btn-danger:hover {
        background-color: #c82333;
    }

    /* Iconos en botones */
    .btn i {
        margin-right: 5px;
    }
</style>
