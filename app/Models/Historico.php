<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Historico extends Model
{
    protected $fillable = ['type', 'montante', 'total_anterior', 'total_depois', 'user_id_transaction', 'date'];
}
