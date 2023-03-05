<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Veiculo;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class VeiculoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request('search');

        $veiculosInteresse = null;

        if ($search) {
            $veiculos = Veiculo::where('especie', 'like', '%' . $search . '%')
                ->orWhere('tipo', 'like', '%' . $search . '%')
                ->orWhere('marca', 'like', '%' . $search . '%')
                ->orWhere('modelo', 'like', '%' . $search . '%')
                ->orWhere('cor', 'like', '%' . $search . '%')
                ->orWhere('potencia', 'like', '%' . $search . '%')
                ->orWhere('ano', 'like', '%' . $search . '%')
                ->paginate(4);
        } else {
            $veiculos = Veiculo::paginate(4);
        }

        if ($user = auth()->user()) {
            $veiculosInteresse = $user->veiculosInteresse;
        }

        return view('veiculos.index', ['veiculos' => $veiculos, 'search' => $search, 'veiculosInteresse' => $veiculosInteresse]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if ($user = auth()->user())
            return view('veiculos.create');
        else
            return redirect('login');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request != null) {

            $veiculo = new Veiculo;

            $veiculo->especie = $request->especie;
            $veiculo->tipo = $request->tipo;
            $veiculo->marca = $request->marca;
            $veiculo->modelo = $request->modelo;
            $veiculo->cor = $request->cor;
            $veiculo->potencia = $request->potencia;
            $veiculo->ano = $request->ano;

            $veiculo->opcionais = $request->opcionais;

            //Image Upload
            if ($request->hasFile('fotos')) {

                $fotos = $request->file('fotos');

                foreach ($fotos as $foto) {
                    if ($foto->isValid()) {
                        $extensao = $foto->extension();
                        $nomeFoto = md5($foto->getClientOriginalName() . strtotime("now") . "." . $extensao);

                        $foto->move(public_path('img/veiculos'), $nomeFoto);

                        // Salva a foto na base de dados
                        $veiculo->fotos()->create(['url' => $nomeFoto]);
                    }
                }
            }

            $user = auth()->user();
            $veiculo->user_id = $user->id;

            if ($veiculo->save())
                return redirect('/')->with('msg', 'Veículo cadastrado com sucesso!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $veiculo = Veiculo::findOrFail($id);

        $user = auth()->user();
        $hasUserJoined = false;

        if ($user) {
            $userInteresse = $user->veiculosInteresse->toArray();

            foreach ($userInteresse as $interesse) {
                if ($interesse['id'] == $veiculo->id) {
                    $hasUserJoined = true;
                }
            }
        }

        $donoAnuncio = User::where('id', $veiculo->user_id)->first()->toArray();

        return view('veiculos.show', ['veiculo' => $veiculo, 'donoAnuncio' => $donoAnuncio, 'hasUserJoined' => $hasUserJoined]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = auth()->user();

        $veiculo = Veiculo::findOrFail($id);

        if ($user->id != $veiculo->user_id) {
            return redirect('/dashboard');
        }

        return view('veiculos.edit', ['veiculo' => $veiculo]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Veiculo $veiculo)
    {
        $data = $request->all();

        // Image Upload
        if ($request->hasFile('fotos')) {

            $fotos = $request->file('fotos');

            foreach ($fotos as $foto) {
                if ($foto->isValid()) {
                    $extensao = $foto->extension();
                    $nomeFoto = md5($foto->getClientOriginalName() . strtotime("now") . "." . $extensao);

                    $foto->move(public_path('img/veiculos'), $nomeFoto);

                    // Salva a foto na base de dados
                    $veiculo->fotos()->create(['url' => $nomeFoto]);
                }
            }
        }

        Veiculo::findOrFail($veiculo->id)->update($data);

        return redirect('/dashboard')->with('msg', 'Veículo editado com sucesso!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $veiculo = Veiculo::findOrFail($id);
        $veiculo->users()->detach();
        $veiculo->delete();

        return redirect('/dashboard')->with('msg', 'Veículo excluído com sucesso!');
    }

    public function dashboard()
    {
        $user = auth()->user();

        $veiculos = $user->veiculos;

        $veiculosInteresse = $user->veiculosInteresse;

        return view(
            '/dashboard',
            ['veiculos' => $veiculos, 'veiculosInteresse' => $veiculosInteresse]
        );
    }

    public function veiculoInteresse($id)
    {
        $user = auth()->user();

        $user->veiculosInteresse()->attach($id);

        $veiculo = Veiculo::findOrFail($id);

        return redirect('/')->with('msg', 'Seu interesse foi confirmado!');
    }

    public function retirarInteresse($id)
    {

        $user = auth()->user();

        $user->veiculosInteresse()->detach($id);

        $veiculo = Veiculo::findOrFail($id);

        return redirect('/dashboard')->with('msg', 'Você tirou o interesse: ' . $veiculo->modelo);
    }
}