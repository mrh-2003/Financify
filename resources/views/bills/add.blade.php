<?php
$title = "Agregar Letra / Factura | Cartera " . $data['billfold']['name'];
?>

@extends('layout.base')

@section('title', $title)

@section('body')
    <div id="loginContainer" class="w-100 d-flex justify-content-center mt-5" style="height: 100vh;">
        <div class="d-flex flex-column justify-content-center align-items-center" style="height: 100vh; width: 50%;">
            <h1 class="page-title mb-4 text-center">{{$title}}</h1>

            <form action="{{route('saveBill')}}" method="POST" id="loginForm" class="login-form p-4 rounded-3 w-70">
                @csrf
                <input hidden class="form-control" type="text" value="{{$data['billfold']['id']}}" name="billfold_id"/>

                <div class="form-group mb-3">
                    <label for="emission_at" class="form-label">Fecha inicio</label>
                    <input class="form-control" type="date" name="emission_at" id="emission_at" required value="{{old('emission_at')}}"/>
                </div>

                <div class="form-group mb-3">
                    <label for="expiration_at" class="form-label">Fecha final</label>
                    <input id="expiration_at" class="form-control" type="date" name="expiration_at" required value="{{old('expiration_at')}}"/>
                    <small class="form-text text-muted">Diferencia de días con la fecha de descuento: <span id="expiration_message"></span></small>
                </div>

                <div class="form-group mb-3">
                    <label for="amount" class="form-label">Monto</label>
                    <input type="text" name="amount" class="form-control" id="amount" required value="{{old('amount')}}" placeholder="100">
                </div>

                <div class="form-group mb-3">
                    <label for="select-type-interest" class="form-label">Tipo de tasa</label>
                    <select class="form-select" id="select-type-interest" name="interest_type">
                        <option value="1" {{ old('interest_type') == '1' ? 'selected' : '' }}>Efectiva</option>
                        <option value="2" {{ old('interest_type') == '2' ? 'selected' : '' }}>Nominal</option>
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label for="interest_rate" class="form-label">Tasa de intereses (%)</label>
                    <input type="text" name="interest_rate" class="form-control" id="interest_rate" value="{{old('interest_rate')}}" placeholder="7.5" required>
                </div>

                <div class="form-group mb-3">
                    <label for="interest_frequency" class="form-label">Frecuencia</label>
                    <select class="form-select" name="interest_frequency" id="interest_frequency" required>
                        @foreach($data['frequencies'] as $value => $label)
                            <option value="{{ $value }}" {{ old('interest_frequency', '1') == $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mb-3" id="cap-input" style="display: none">
                    <label for="interest_capitalization" class="form-label">Capitalización</label>
                    <select class="form-select" name="interest_capitalization" id="interest_capitalization" required>
                        @foreach($data['frequencies'] as $value => $label)
                            <option value="{{ $value }}" {{ old('interest_capitalization', '1') == $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label for="other_costs" class="form-label">Otros Costos</label>
                    <input type="text" name="other_costs" class="form-control" id="other_costs" value="{{old('other_costs')}}" placeholder="10" required>
                </div>

                <div class="d-flex justify-content-center mt-4 gap-3">
                    <button type="button" class="btn btn-secondary" onclick="clearForm()">
                        <i class="fa-solid fa-eraser"></i> Limpiar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-floppy-disk"></i> Guardar
                    </button>
                    <a href="{{ url()->previous() }}">
                        <button type="button" class="btn btn-danger">
                            <i class="fa-solid fa-arrow-left"></i> Cancelar
                        </button>
                    </a>
                </div>

                @if (session('error'))
                    <div class="alert alert-danger mt-3">
                        {{ session('error') }}
                    </div>
                @endif
            </form>

            <div id="response-section" class="card mt-3 w-100" style="display: none">
                <div class="card-title text-center"><b>Resultado</b></div>
                <div id="response-body" class="card-body"></div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        const billfoldDate = '{{$data['billfold']['discount_date']}}';

        $('#expiration_at').on('change', function () {
            const expirationDate = this.value;

            const [yearS, monthS, dayS] = expirationDate.split('-').map(Number);
            const [yearE, monthE, dayE, hourE = 0, minE = 0, secE = 0] = billfoldDate.split(/[- :]/).map(Number);

            const startUTC = Date.UTC(yearS, monthS - 1, dayS);
            const endUTC = Date.UTC(yearE, monthE - 1, dayE, hourE, minE, secE);

            const millisDifference = startUTC - endUTC;
            const millisPerDay = 1000 * 60 * 60 * 24;
            const daysDiff = Math.ceil(millisDifference / millisPerDay);

            $('#expiration_message').html(daysDiff);
        });

        $('#select-type-interest').on('change', function () {
            let cap = $('#cap-input');
            if ($(this).val() === '1') {
                cap.hide();
            } else {
                cap.show();
            }
        });

        function clearForm() {
            $('#emission_at').val('');
            $('#expiration_at').val('');
            $('#amount').val('');
            $('#select-type-interest').val('1');
            $('#interest_rate').val('');
            $('#other_costs').val('');
            $('#interest_frequency').val('1');
            $('#interest_capitalization').val('1');
        }
    </script>
@endpush

<style>
    /* Estilo del título de la página */
    .page-title {
        font-size: 2rem;
        font-weight: bold;
        color: #007bff;
        text-align: center;
        margin-bottom: 1rem;
    }

    /* Estilo del formulario */
    .login-form {
        background-color: #ffffff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        transition: 0.3s ease;
    }

    /* Estilos de los botones */
    .btn-primary, .btn-secondary, .btn-danger {
        font-size: 1rem;
        padding: 8px 15px;
        font-weight: 500;
        display: flex;
        align-items: center;
    }

    .btn i {
        margin-right: 5px;
    }
</style>
