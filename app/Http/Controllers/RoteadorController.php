<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Roteador;
use Illuminate\Http\Request;

class RoteadorController extends Controller
{
    /* Construtor desta classe, para quando o objeto
       (esta classe) for instanciada. Está usando a
       sugestão de tipo (type-hinting), para injetar
       a instância do respectivo model neste controller.
    */
    public function __construct(Roteador $roteador)
    {
        $this->rrroteador = $roteador;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json($this->rrroteador->all(), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /* Modo massivo */
        $request->validate($this->rrroteador->rules());

        $imagem = $request->file('imagem');

        $imagem_urn = $imagem->store('imagens/roteadores', 'public');

        $roteador = $this->rrroteador->create([
            //'nome' => $request->nome,
            'imagem' => $imagem_urn,
            //'banda' => $request->banda,
            'marca' => $request->marca,
            //'datanota' => $request->datanota,
            //'macaddress' => $request->macaddress,
            //'modelo' => $request->modelo,
            //'notafiscal' => $request->notafiscal,
            //'serial' => $request->serial,
            //'situacao' => $request->situacao,
            //'observacao' => $request->observacao

        ]);

        return response()->json($roteador, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Roteador  $roteador
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $roteador = $this->rrroteador->find($id);
        if ($roteador === null) {
            return response()->json(['erro' => 'Recurso não existe'], 404);
        }
        return response()->json($roteador, 200);
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Roteador  $roteador
     * @return \Illuminate\Http\Response
     */
    public function edit(Roteador $roteador)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Roteador $roteador
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $roteador = $this->rrroteador->find($id);

        if ($roteador === null) {

            return response()->json(['erro' => 'Impossível realizar a atualização. O recurso não existe.'], 404);
        }

        if ($request->method() === 'PATCH') {

            $regrasDinamicas = array();

            foreach ($roteador->rules() as $input => $regra) {

                if (array_key_exists($input, $request->all())) {
                    $regrasDinamicas[$input] = $regra;
                }
            }

            $request->validate($regrasDinamicas, $roteador->feedback());
        } else {
            $request->validate($roteador->rules(), $roteador->feedback());
        }

        if ($request->file('imagem')) {

            Storage::disk('public')->delete($roteador->imagem);
        }

        $imagem = $request->file('imagem');

        $imagem_urn = $imagem->store('imagens/roteadores', 'public');

        $roteador->update([
            //'banda' => $request->banda,
            'imagem' => $imagem_urn,
            //'datanota' => $request->datanota,
            //'macaddress' => $request->macaddress,
            'marca' => $request->marca,
            //'modelo' => $request->modelo,
            //'notafiscal' => $request->notafiscal,
            //'serial' => $request->serial,
            //'situacao' => $request->situacao,
            //'observacao' => $request->observacao



        ]);
        return response()->json($roteador, 200);
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Roteador  $roteador
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $roteador = $this->rrroteador->find($id);

        if ($roteador === null) {
            return response()->json(['erro' => 'Impossível excluir. O registro não existe.'], 404);
        }

        Storage::disk('public')->delete($roteador->imagem);

        $roteador->delete();
        return response()->json(['msg' => 'O roteador foi removido com sucesso!'], 200);
    }
}
