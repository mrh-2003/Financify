<!-- resources/views/bills/index.blade.php -->
<?php
$title = "Resultados | Cartera " . $matrix['billfold']['name'];
?>

@extends('layout.base')

@section('title', $title)

@section('body')
<div class="container mt-5">
    <h1 class="page-title mb-4 text-center">{{$title}}</h1>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Monto</th>
                <th>Otros Costos</th>
                <th>Fecha de descuento</th>
                <th>Fecha de vencimiento</th>
                <th>Diferencia de Días</th>
                <th>Descuento</th>
                <th>Descuento Neto</th>
                <th>TCEA (%)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($matrix['data'] as $bill)
                <tr>
                    <td>{{ $bill['amount'] }}</td>
                    <td>{{ $bill['other_costs'] }}</td>
                    <td>{{ $bill['discount_date'] }}</td>
                    <td>{{ $bill['expiration_at'] }}</td>
                    <td>{{ $bill['days'] }}</td>
                    <td class="text-end">{{ $bill['discount'] }}</td>
                    <td class="text-end">{{ $bill['netDiscount'] }}</td>
                    <td class="text-end">{{ $bill['tcea'] }}</td>
                </tr>
            @endforeach
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="text-end">{{$matrix['netValue']}}</td>
                <td class="text-end">{{$matrix['tcea']}}</td>
            </tr>
        </tbody>
    </table>

    <!-- Botón "Cancelar" con icono de retroceso -->
    <div class="d-flex justify-content-end mt-3">
        <a href="{{url()->previous()}}">
            <button type="button" class="btn btn-danger">
                <i class="fa-solid fa-arrow-left"></i> Cancelar
            </button>
        </a>
    </div>
</div>
@endsection

<style>
    /* Estilo del título de la página */
    .page-title {
        font-size: 2rem;
        font-weight: bold;
        color: #007bff;
        text-align: center;
        margin-bottom: 1rem;
    }

    /* Estilo de los botones */
    .btn-danger {
        font-size: 1rem;
        padding: 8px 15px;
        font-weight: 500;
        display: flex;
        align-items: center;
    }

    .btn-danger i {
        margin-right: 5px;
    }
</style>
