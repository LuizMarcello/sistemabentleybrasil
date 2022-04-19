<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Instalador;
use Illuminate\Http\Request;
use App\Repositories\InstaladorRepository;

class InstaladorController extends Controller
{
    /* Construtor desta classe, para quando o objeto
    ( esta classe ) for instanciada. Está usando a
    sugestão de tipo ( type-hinting ), para injetar
    a instância do respectivo model neste controller.
    */

    public function __construct(Instalador $instalador)
    {
        $this->iiinstalador = $instalador;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $instaladorRepository = new InstaladorRepository($this->iiinstalador);

        /* Verificando se um determinado parâmetro existe/está definido no request */
        /* if ($request->has('atributos_roteadores')) {
            $atributos_roteadores = 'roteadores:id,' . $request->atributos_roteadores;
            $clienteRepository->selectAtributosRegistrosRelacionados($clienteRepository);
        } else {
            $clienteRepository->selectAtributosRegistrosRelacionados('roteadores');
        } */

        /* Verificando se um determinado parâmetro existe/está definido no request */
        if ($request->has('filtro')) {
            $instaladorRepository->filtro($request->filtro);
        }

        /* Verificando se um determinado parâmetro existe/está definido no request */
        if ($request->has('atributos')) {
            $instaladorRepository->selectAtributos($request->atributos);
        }

        return response()->json($instaladorRepository->getResultado(), 200);
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

        $request->validate($this->iiinstalador->rules(), $this->iiinstalador->feedback());

        $imagem = $request->file('imagem');
        /* O método store() espera dois parâmetros */
        //$image->store( 'path', 'disco' );
        $imagem_urn = $imagem->store('imagens/instaladores', 'public');

        $instalador = $this->iiinstalador->create([
            'imagem' => $imagem_urn,
            'nome' => $request->nome,
            'cpf' =>  $request->cpf,
            'rg' =>  $request->rg,
            'celular' =>  $request->celular,
            'telefone' =>  $request->telefone,
            'email' =>  $request->email,
            'cep' =>  $request->cep,
            'bairro' =>  $request->bairro,
            'cidade' => $request->cidade,
            'estado' =>  $request->estado,
            'observacao' =>  $request->observacao,
            'situacao' =>  $request->situacao,
            'rua' =>  $request->rua,
            'numero' =>  $request->numero,
            'dataNascimento' =>  $request->dataNascimento

        ]);

        return response()->json($instalador, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Instalador  $instalador
     * @return \Illuminate\Http\Response
     */
    public function show(Instalador $instalador)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Instalador  $instalador
     * @return \Illuminate\Http\Response
     */
    public function edit(Instalador $instalador)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Instalador  $instalador
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Instalador $instalador)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Instalador  $instalador
     * @return \Illuminate\Http\Response
     */
    public function destroy(Instalador $instalador)
    {
        //
    }
}
