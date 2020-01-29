<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Balanco;
use App\Models\Historico;
use App\User;
use App\Http\Requests\MoneyValidacao;

class BalancoController extends Controller
{
    public function index()
    {

        $balanco = auth()->user()->balanco;

        $montante = $balanco ? $balanco->montante : 0;

        return view('admin.balanco.index', compact('montante'));
    }


    public function deposito()
    {
        return view('admin.balanco.deposito');
    }

    public function depositoStore(MoneyValidacao $request)
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


    public function sacar()    {

        return view('admin.balanco.sacar');
    }


    public function sacarStore(MoneyValidacao $request)
    {
        $balanco = auth()->user()->balanco()->firstOrCreate([]);
        $response = $balanco->sacar($request->value);

        if ($response['success'])
            return redirect()
                ->route('admin.balanco')
                ->with('success', $response['message']);


        return redirect()
            ->back()
            ->with('error', $response['message']);
    }


    public function transferir()
    {
        return view('admin.balanco.transferir');
    }


    public function confirmarTransferencia(Request $request, User $user)
    {
        if (!$recebedor = $user->getRecebedor($request->recebedor))
            return redirect()
                ->back()
                ->with('error', 'Usuário informado não foi encontrado!');

        if ($recebedor->id === auth()->user()->id)
            return redirect()
                ->back()
                ->with('error', 'Não pode transferir para você mesmo!');

        $balanco = auth()->user()->balanco;

        return view('admin.balanco.transferir-confirmacao', compact('recebedor', 'balanco'));
    }


    public function transferirStore(MoneyValidacao $request, User $user)
    {
        if (!$recebedor = $user->find($request->recebedor_id))
            return redirect()
                ->route('balanco.transferir')
                ->with('success', 'Recebedor Não Encontrado!');

        $balanco = auth()->user()->balanco()->firstOrCreate([]);


        $response = $balanco->transferir($request->value, $recebedor);

        if ($response['success'])
            return redirect()
                ->route('admin.balanco')
                ->with('success', $response['message']);


        return redirect()
            ->route('balance.transferir')
            ->with('error', $response['message']);
    }


    public function historico(Historico $historico)
    {
        $historicos = auth()->user()
            ->historicos()
            ->with(['userRecebedor'])
            ->get();
           // ->paginate($this->totalPage);


        $types = $historico->type();

        return view('admin.balanco.historicos', compact('historicos', 'types'));
    }


    public function searchHistoric(Request $request, Historico $historic)
    {
        $dataForm = $request->except('_token');

        $historics = $historic->search($dataForm, $this->totalPage);

        $types = $historic->type();

        return view('admin.balance.historics', compact('historics', 'types', 'dataForm'));
    }
}
