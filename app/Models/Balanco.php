<?php

namespace App\Models;
use DB;
use Illuminate\Database\Eloquent\Model;
use App\User;


class Balanco extends Model

{
    //private $table = 'balancos';
    public $timestamps = false;


    public function deposito(float $value) : Array
    {
        DB::beginTransaction();

        $total_anterior = $this->montante ? $this->montante : 0;
        $this->montante += number_format($value, 2, '.', '');
        $deposito = $this->save();

        $historico = auth()->user()->historicos()->create([
            'type'          => 'E',
            'montante'        => $value,
            'total_anterior'  => $total_anterior,
            'total_depois'   => $this->montante,
            'date'          => date('Ymd'),
        ]);

        if ($deposito && $historico) {


            DB::commit();

            return [
                'success' => true,
                'message' => 'Sucesso ao recarregar'
            ];
        } else {

            DB::rollback();

            return [
                'success' => false,
                'message' => 'Falha ao carregar'
            ];
        }
    }


    public function sacar(float $value) : Array
    {
        if ($this->montante < $value)
            return [
                'success' => false,
                'message' => 'Saldo insuficiênte',
            ];


        DB::beginTransaction();

        $total_anterior = $this->montante ? $this->montante : 0;
        $this->montante -= number_format($value, 2, '.', '');
        $saque = $this->save();

        $historico = auth()->user()->historicos()->create([
            'type'          => 'S',
            'montante'        => $value,
            'total_anterior'  => $total_anterior,
            'total_depois'   => $this->montante,
            'date'          => date('Ymd'),
        ]);

        if ($saque && $historico) {

            DB::commit();

            return [
                'success' => true,
                'message' => 'Sucesso ao retirar'
            ];
        } else {

            DB::rollback();

            return [
                'success' => false,
                'message' => 'Falha ao retirar'
            ];
        }
    }


    public function transferir(float $value, User $recebedor): Array
    {
        if ($this->montante < $value)
            return [
                'success' => false,
                'message' => 'Saldo insuficiênte',
            ];

        DB::beginTransaction();

        /********************************************************
         * Atualiza o próprio saldo
         * *****************************************************/
        $total_anterior = $this->montante ? $this->montante : 0;
        $this->montante -= number_format($value, 2, '.', '');
        $transfer = $this->save();

        $historic = auth()->user()->historicos()->create([
            'type'                  => 'T',
            'montante'                => $value,
            'total_anterior'          => $total_anterior,
            'total_depois'           => $this->montante,
            'date'                  => date('Ymd'),
            'user_id_transaction'   => $recebedor->id
        ]); 
        /********************************************************
         * Atualiza o saldo do recebedor
         * *****************************************************/
        $recebedorBalanco = $recebedor->balanco()->firstOrCreate([]);
        $total_anterior_recebedor = $recebedorBalanco->montante ? $recebedorBalanco->montante : 0;

        $recebedorBalanco->montante += number_format($value, 2, '.', '');
        $transferRecebedor = $recebedorBalanco->save();

        $historicRecebedor = $recebedor->historicos()->create([
            'type'                  => 'E',
            'montante'                => $value,
            'total_anterior'          => $total_anterior_recebedor,
            'total_depois'           => $recebedorBalanco->montante,
            'date'                  => date('Ymd'),
            'user_id_transaction'   => auth()->user()->id,
        ]);

        if ($transfer && $historic && $transferRecebedor && $historicRecebedor) {

            DB::commit();

            return [
                'success' => true,
                'message' => 'Sucesso ao transferir'
            ];
        }

        DB::rollback();

        return [
            'success' => false,
            'message' => 'Falha ao retirar'
        ];
    }

}
