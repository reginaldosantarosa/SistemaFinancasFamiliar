@extends('adminlte::page')

@section('title', 'Nova Tranferencia')

@section('content_header')
    <h1>Fazer Transferencia</h1>

    <ol class="breadcrumb">
        <li><a href="">Dashboard</a></li>
        <li><a href="">Saldo</a></li>
        <li><a href="">Tranferencia</a></li>
    </ol>
@stop

@section('content')
    <div class="box">
        <div class="box-header">
            <h3>Transferir Saldo (Informe o Recebedor)</h3>
        </div>
        <div class="box-body">
            @include('admin.includes.alerts')

            <form method="POST" action="{{ route('confirmar.transferencia') }}">
                {!! csrf_field() !!}

                <div class="form-group">
                    <input type="text" name="recebedor" placeholder="Informação de quem vai receber o saque (Nome ou E-mail)" class="form-control" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success">Próxima Etapa</button>
                </div>
            </form>
        </div>
    </div>
@stop
