<?php
    $title = "Lista de Letras / Facturas | Cartera " . $data['billfold']['name'];
?>

@extends('layout.base')

@section('title', $title)

@section('body')
<div class="container mt-5">
    <h1 class="page-title mb-4">{{$title}}</h1>

    <form action="{{route('calculateBills', $data['billfold']['id'])}}" method="GET">
        @csrf
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Monto</th>
                    <th>Fecha de Emisión</th>
                    <th>Fecha de Vencimiento</th>
                    <th>Tasa de Interés</th>
                    <th>Tipo de Interés</th>
                    <th>Frecuencia de Interés</th>
                    <th>Capitalización de Interés</th>
                    <th>Otros costos</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['bills'] as $bill)
                    <tr>
                        <td><input type="hidden" name="bills[{{ $loop->index }}][amount]" value="{{ $bill->amount }}">{{ $bill->amount }}</td>
                        <td><input type="hidden" name="bills[{{ $loop->index }}][emission_at]" value="{{ $bill->emission_at }}">{{ substr($bill->emission_at,0,10) }}</td>
                        <td><input type="hidden" name="bills[{{ $loop->index }}][expiration_at]" value="{{ $bill->expiration_at }}">{{ substr($bill->expiration_at,0,10) }}</td>
                        <td><input type="hidden" name="bills[{{ $loop->index }}][interest_rate]" value="{{ $bill->interest_rate }}">{{ $bill->interest_rate }}</td>
                        <td><input type="hidden" name="bills[{{ $loop->index }}][interest_type]" value="{{ $bill->interest_type }}">{{ $bill->interest_type }}</td>
                        <td><input type="hidden" name="bills[{{ $loop->index }}][interest_frequency]" value="{{ $bill->interest_frequency }}">{{ $bill->interest_frequency }}</td>
                        <td><input type="hidden" name="bills[{{ $loop->index }}][interest_capitalization]" value="{{ $bill->interest_capitalization }}">{{ $bill->interest_capitalization ?? 'N/A' }}</td>
                        <td><input type="hidden" name="bills[{{ $loop->index }}][other_costs]" value="{{ $bill->other_costs }}">{{ $bill->other_costs ?? '0' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <!-- Botones de acción centrados y con texto -->
        <div class="d-flex justify-content-center mt-4 gap-3">
            <button type="submit" class="btn btn-primary" {{ count($data['bills']) > 0 ? "" : "disabled" }}>
                <i class="fa-solid fa-calculator"></i> Calcular
            </button>
            
            <a href="{{route('addBill', $data['billfold']['id'])}}">
                <button type="button" class="btn btn-success">
                    <i class="fa-solid fa-plus"></i> Nuevo
                </button>
            </a>
            
            <a href="{{route('listBillfold')}}">
                <button type="button" class="btn btn-danger">
                    <i class="fa-solid fa-arrow-left"></i> Cancelar
                </button>
            </a>
        </div>
    </form>
</div>

<style>
    /* Estilo del título de la página */
    .page-title {
        font-size: 2rem;
        font-weight: bold;
        color: #007bff; /* Color azul consistente */
        text-align: center;
        margin-bottom: 1rem;
    }
    
    /* Estilos de botones */
    .btn-primary, .btn-success, .btn-danger {
        font-size: 1rem;
        padding: 8px 15px;
        font-weight: 500;
        display: flex;
        align-items: center;
    }

    .btn-primary i, .btn-success i, .btn-danger i {
        margin-right: 5px;
    }

    /* Alineación de botones */
    .d-flex.gap-3 > * {
        margin-right: 10px;
    }
</style>

@endsection
