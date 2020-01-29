<?php

namespace App\Models;
use Carbon\Carbon;
use App\User;

use Illuminate\Database\Eloquent\Model;

class Historico extends Model
{
    protected $fillable = ['type', 'montante', 'total_anterior', 'total_depois', 'user_id_transaction', 'date'];

    public function getDateAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }

    public function type($type = null)
    {
        $types = [
            'E' => 'Entrada',
            'S' => 'Saque',
            'T' => 'Transferência',
        ];

        if (!$type)
            return $types;

        if ($this->user_id_transaction != null && $type == 'E')
            return 'Recebido';

        return $types[$type];
    }

    //UM HISTORICO UNICO USAURIO, MAS UM USARIO VARIOS HISTORICO..ESSE É A VOLTA DO  return $this->hasMany(Historico::class) EM USER;!!!
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function userRecebedor()
    {
        return $this->belongsTo(User::class, 'user_id_transaction');
    }
}
