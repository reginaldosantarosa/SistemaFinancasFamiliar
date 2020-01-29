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
        ///DB::beginTransaction();

        $totalBefore = $this->montante ? $this->montante : 0;
        $this->montante += number_format($value, 2, '.', '');
        $deposito = $this->save();

        $historico = auth()->user()->historicos()->create([
            'type'          => 'I',
            'amount'        => $value,
            'total_before'  => $totalBefore,
            'total_after'   => $this->montante,
            'date'          => date('Ymd'),
        ]);

        if ($deposito && $historico) {


           // DB::commit();

            return [
                'success' => true,
                'message' => 'Sucesso ao recarregar'
            ];
        } else {

            //DB::rollback();

            return [
                'success' => false,
                'message' => 'Falha ao carregar'
            ];
        }
    }

}
