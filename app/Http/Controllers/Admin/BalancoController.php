<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Balanco;

class BalancoController extends Controller
{
        public function index(){

            $balanco = auth()->user()->balanco;

            //dd($balanco);
            $amount = $balanco ? $balanco->montante : 0;

            return view('admin.balanco.index', compact('amount'));
        }



        public function deposito(){

            return view('admin.balanco.deposito');
        }

        public function depositoStore(Request $request, Balanco $balanco)
        {
            $balanco = auth()->user()->balanco()->firstOrCreate([]); //se existe ele tras o caramara...se nao existe ele cria um novo
            $response = $balanco->deposito($request->value);

            if ($response['success'])
                return redirect()
                            ->route('admin.balanco')
                            ->with('success', $response['message']);


            return redirect()
                        ->back()
                        ->with('error', $response['message']);
        }
}
