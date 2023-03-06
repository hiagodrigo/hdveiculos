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
    public function index(Request $request)
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
                ->sortBy('created_at', 'desc')->get();
        } else {
            $veiculos = Veiculo::all();
        }

        if ($user = auth()->user()) {
            $veiculosInteresse = $user->veiculosInteresse;
        }

        if ($request->ajax()) {
            $veiculos = Veiculo::orderBy('created_at', 'desc')->paginate(4);
        
            $response = [
                'veiculos' => $veiculos->items(),
                'next_page' => $veiculos->nextPageUrl()
            ];
        
            return response()->json($response);
        }
        

        return view('veiculos.index', compact('veiculos', 'search', 'veiculosInteresse'));
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
                $nomesFotos = [];

                foreach ($fotos as $foto) {
                    if ($foto->isValid()) {
                        $extensao = $foto->extension();
                        $nomeFoto = md5($foto->getClientOriginalName() . strtotime("now") . "." . $extensao);

                        $foto->move(public_path('img/veiculos'), $nomeFoto);

                        $nomesFotos[] = $nomeFoto;
                    }
                }

                // Salva a foto na base de dados como um array codificado em JSON
                $veiculo->fotos = json_encode($nomesFotos);
            }

            $user = auth()->user();
            $veiculo->user_id = $user->id;

            if ($veiculo->save()) {
                // Recupera o veículo recém-cadastrado, incluindo as fotos decodificadas
                $veiculo = Veiculo::with('user')->findOrFail($veiculo->id);
                $veiculo->fotos = json_decode($veiculo->fotos);

                return redirect('/')->with('msg', 'Veículo cadastrado com sucesso!')->with('veiculo', $veiculo);
            }
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

        return view('veiculos.show', compact('veiculo', 'donoAnuncio', 'hasUserJoined'));
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

        return view('veiculos.edit', compact('veiculo'));
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

            $nomesFotos = [];

            foreach ($fotos as $foto) {
                if ($foto->isValid()) {
                    $extensao = $foto->extension();
                    $nomeFoto = md5($foto->getClientOriginalName() . strtotime("now") . "." . $extensao);

                    $foto->move(public_path('img/veiculos'), $nomeFoto);

                    $nomesFotos[] = $nomeFoto;
                }
            }

            // Salva a foto na base de dados
            $data['fotos'] = json_encode($nomesFotos);
        }

        if (isset($data['fotos']) && !is_string($data['fotos'])) {
            $data['fotos'] = json_encode($data['fotos']);
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
            compact('veiculos', 'veiculosInteresse')
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