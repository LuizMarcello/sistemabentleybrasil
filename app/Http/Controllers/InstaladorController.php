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

        return response()->json($instaladorRepository->getResultadoPaginado(3), 200);
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
    public function show($id)
    {
        /* Procurando uma instalacao, e junto do seu retôrno, todos os registros
        relacionados de roteradores
        O 'with()' é usado para informações de relacionamentos */
        /*  $antena = $this->aaantena->with('roteadores')->find($id); */
        $instalador = $this->iiinstalador->find($id);
        if ($instalador === null) {
            /* helper 'response()' do laravel */
            /* Através dele, podemos alterar os detalhes da resposta dada pelo laravel*/
            /* Como 2º parâmetro do método 'json()', podemos passar o status code http */
            return response()->json(['erro' => 'Recurso não existe'], 404);
        }
        return response()->json($instalador, 200);
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
    public function update(Request $request, $id)
    {
        /* Variável $antena sendo instanciando como objeto do tipo 'Antena' */
        $instalador = $this->iiinstalador->find($id);

        if ($instalador === null) {
            /* helper 'response()' do laravel */
            /* Através dele, podemos alterar os detalhes da resposta dada pelo laravel*/
            /* Como 2º parâmetro do método 'json()', podemos passar o status code http */
            return response()->json(['erro' => 'Impossível realizar a atualização. O recurso não existe.'], 404);
        }

        /* Método 'PATH' permite o envio parcial de parâmetros */
        if ($request->method() === 'PATCH') {

            $regrasDinamicas = array();

            /* Percorrendo todas as regras( rules() ) definidas no Model */
            foreach ($instalador->rules() as $input => $regra) {

                /* Coletar apenas as regras aplicáveis aos parâmetros parciais da requisição PATCH */
                /* Método nativo do PHP que varre o array procurando a chave "$input" no mesmo */
                if (array_key_exists($input, $request->all())) {
                    $regrasDinamicas[$input] = $regra;
                }
            }

            $request->validate($regrasDinamicas, $instalador->feedback());
        } else {
            $request->validate($instalador->rules(), $instalador->feedback());
        }

        /* Remove a imagem antiga caso uma nova imagem tenha sido enviado no request do update */
        if ($request->file('imagem')) {
            /* 'Storage' é um façade do laravel */
            /* Remove a imagem */
            Storage::disk('public')->delete($instalador->imagem);
        }

        $imagem = $request->file('imagem');

        /* O método store() espera dois parâmetros */
        //$image->store( 'path', 'disco' );
        $imagem_urn = $imagem->store('imagens/instaladores', 'public');

        /* Quando o update for PATCH, não atualizando todos os atributos, para não dar êrros,
          preenchendo o objeto $antena com todos os dados do request. Os atributos que não
          estiverem sendo alterados, serão repetidos dos dados anteriores, trazidos do banco
          de dados. */
        $instalador->fill($request->all());
        $instalador->imagem = $imagem_urn;
        //dd( $antena->getAttributes() );
        $instalador->save();

        return response()->json($instalador, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Instalador  $instalador
     * @return \Illuminate\Http\Response
     */
    public function destroy(Instalador $instalador)
    {
        $instalador = $this->iiinstalador->find($id);

        if ($instalador === null) {
            /* helper 'response()' do laravel */
            /* Através dele, podemos alterar os detalhes da resposta dada pelo laravel*/
            /* Como 2º parâmetro do método 'json()', podemos passar o status code http */
            return response()->json(['erro' => 'Impossível excluir. O registro não existe.'], 404);
        }

        /* Remove a imagem*/
        /* 'Storage' é um façade do laravel */
        Storage::disk('public')->delete($instalador->imagem);

        /* Remove então o registro */
        $instalador->delete();
        return response()->json(['msg' => 'A instalacao foi removida com sucesso!'], 200);
    }
}
