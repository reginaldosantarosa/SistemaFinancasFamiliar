<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Balanco;
use App\Models\Historico;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



    public function balanco()
    {
        return $this->hasOne(Balanco::class);
    }


    //um usuario, varios historicos
    public function historicos()
    {

       //dd( $this->hasMany(Historico::class));
        return $this->hasMany(Historico::class);
    }


    public function getRecebedor($recebedor)
    {
        return $this->where('name', 'LIKE', "%$recebedor%")
                        ->orWhere('email', $recebedor)
                        ->get()
                        ->first();//primeiro resultado

                        //toSql() susbtituindo get para ver debug da query
    }
}
