<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){

        $usuario=User::where('email','=','reginaldo_00@hotmail.com')->count(); //contando quantas paginas sobre existem

        if ($usuario){
            $usuario = User::where('email','=', 'reginaldo_00@hotmail.com')->first(); //pegando uma pagina
        }
        else{
            $usuario=new User();
        }


        $usuario->name = 'Reginaldo Santa Rosa';
        $usuario->email = 'reginaldo_00@hotmail.com';
        $usuario->password = bcrypt('123456');
        $usuario->save();

    }
}
