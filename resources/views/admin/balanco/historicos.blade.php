@extends('adminlte::page')

@section('title', 'Histórico de Movimentações')

@section('content_header')
    <h1>Histórico de Movimentações</h1>

    <ol class="breadcrumb">
        <li><a href="">Dashboard</a></li>
        <li><a href="">Histórico</a></li>
    </ol>
@stop

@section('content')
    <div class="box">

        <div class="box-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Valor</th>
                        <th>Tipo</th>
                        <th>Data</th>
                        <th>?Sender?</th>
                    <tr>
                </thead>
                <tbody>
                    @forelse($historicos as $historico)
                    <tr>
                        <td>{{ $historico->id }}</td>
                        <td>{{ number_format($historico->montante, 2, ',', '.') }}</td>
                        <td>{{ $historico->type($historico->type) }}</td>
                        <td>{{ $historico->date }}</td>
                        <td>
                            @if ($historico->user_id_transaction)
                                {{ $historico->userRecebedor->name }}
                            @else
                                -
                            @endif
                        </td>
                    <tr>
                    @empty
                    @endforelse
                </tbody>
            </table>


        </div>
    </div>
@stop
