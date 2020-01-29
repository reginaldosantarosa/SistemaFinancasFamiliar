<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Balanco;
use App\User;
use App\Http\Requests\MoneyValidacao;

class BalancoController extends Controller
{
    public function index()
    {

        $balanco = auth()->user()->balanco;

        //dd($balanco);
        $amount = $balanco ? $balanco->montante : 0;

        return view('admin.balanco.index', compact('amount'));
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



    public function sacar()
    {

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


    public function transfer()
    {
        return view('admin.balance.transfer');
    }


    public function confirmTransfer(Request $request, User $user)
    {
        if (!$sender = $user->getSender($request->sender))
            return redirect()
                ->back()
                ->with('error', 'Usuário informado não foi encontrado!');

        if ($sender->id === auth()->user()->id)
            return redirect()
                ->back()
                ->with('error', 'Não pode transferir para você mesmo!');

        $balance = auth()->user()->balance;

        return view('admin.balance.transfer-confirm', compact('sender', 'balance'));
    }


    public function transferStore(MoneyValidacao $request, User $user)
    {
        if (!$sender = $user->find($request->sender_id))
            return redirect()
                ->route('balance.transfer')
                ->with('success', 'Recebedor Não Encontrado!');

        $balance = auth()->user()->balance()->firstOrCreate([]);
        $response = $balance->transfer($request->value, $sender);

        if ($response['success'])
            return redirect()
                ->route('admin.balance')
                ->with('success', $response['message']);


        return redirect()
            ->route('balance.transfer')
            ->with('error', $response['message']);
    }



    public function historic(Historico $historic)
    {
        $historics = auth()->user()
            ->historics()
            ->with(['userSender'])
            ->paginate($this->totalPage);

        $types = $historic->type();

        return view('admin.balance.historics', compact('historics', 'types'));
    }


    public function searchHistoric(Request $request, Historico $historic)
    {
        $dataForm = $request->except('_token');

        $historics = $historic->search($dataForm, $this->totalPage);

        $types = $historic->type();

        return view('admin.balance.historics', compact('historics', 'types', 'dataForm'));
    }
}
