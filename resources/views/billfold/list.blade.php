<?php
    $title = "Lista de Carteras";
?>

@extends('layout.base')

@section('title', $title)

@section('link1', 'active')

@section('body')
<div class="container mt-5">
    <!-- Título centrado y con estilo azul consistente -->
    <div class="text-center mb-4">
        <h1 class="page-title">{{$title}}</h1>
    </div>
    
    <!-- Botón "Nuevo" alineado a la derecha -->
    <div class="d-flex justify-content-end mb-4">
        <a href="{{route('addBillfold')}}">
            <button type="button" class="btn btn-primary d-flex align-items-center add-button">
                <i class="fa-solid fa-plus me-2"></i> Nuevo
            </button>
        </a>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Fecha de Descuento</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $billfold)
                <tr>
                    <td>{{ $billfold->name }}</td>
                    <td>{{ substr($billfold->discount_date, 0, 10) }}</td>
                    <td class="d-flex justify-content-center">
                        <a class="me-3" href="{{route('showBills', $billfold->id)}}">
                            <button type="button" class="btn btn-primary action-button">
                                <i class="fa-regular fa-folder-open"></i>
                            </button>
                        </a>
                        <form action="{{ route('billfold.destroy', $billfold->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este ítem?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger action-button">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @if(session('message'))
        <div class="alert alert-success mt-3">
            {{ session('message') }}
        </div>
    @endif
</div>

<style>
    /* Estilo para el título de la página */
    .page-title {
        font-size: 2rem;
        font-weight: bold;
        color: #007bff; /* Color azul consistente */
        margin-bottom: 1rem;
    }

    /* Estilo del botón "Nuevo" */
    .add-button {
        font-size: 1rem;
        padding: 8px 15px;
        font-weight: 500;
    }

    /* Botones circulares de acción */
    .action-button {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }

    /* Iconos en botones */
    .action-button i, .add-button i {
        font-size: 1.2rem;
    }
</style>

@endsection
