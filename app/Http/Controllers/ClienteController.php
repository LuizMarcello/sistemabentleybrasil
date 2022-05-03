<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Cliente;
use Illuminate\Http\Request;
use App\Repositories\ClienteRepository;

class ClienteController extends Controller
{
    /* Construtor desta classe, para quando o objeto
    ( esta classe ) for instanciada. Está usando a
    sugestão de tipo ( type-hinting ), para injetar
    a instância do respectivo model neste controller.
    */

    public function __construct(Cliente $cliente)
    {
        $this->cccliente = $cliente;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $clienteRepository = new ClienteRepository($this->cccliente);

        /* Verificando se um determinado parâmetro existe/está definido no request */
        /* if ($request->has('atributos_roteadores')) {
            $atributos_roteadores = 'roteadores:id,' . $request->atributos_roteadores;
            $clienteRepository->selectAtributosRegistrosRelacionados($clienteRepository);
        } else {
            $clienteRepository->selectAtributosRegistrosRelacionados('roteadores');
        } */

        /* Verificando se um determinado parâmetro existe/está definido no request */
        if ($request->has('filtro')) {
            $clienteRepository->filtro($request->filtro);
        }

        /* Verificando se um determinado parâmetro existe/está definido no request */
        if ($request->has('atributos')) {
            $clienteRepository->selectAtributos($request->atributos);
        }

        return response()->json($clienteRepository->getResultadoPaginado(3), 200);
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

        $request->validate($this->cccliente->rules(), $this->cccliente->feedback());

        $imagem = $request->file('imagem');
        /* O método store() espera dois parâmetros */
        //$image->store( 'path', 'disco' );
        $imagem_urn = $imagem->store('imagens/clientes', 'public');

        $cliente = $this->cccliente->create([
            'imagem' => $imagem_urn,
            'nome_razaosocial' => $request->nome_razaosocial,
            'cpf' =>  $request->cpf,
            'ie_rg' =>  $request->ie_rg,
            'nome_contato' =>  $request->nome_contato,
            'celular' =>  $request->celular,
            'telefone' =>  $request->telefone,
            'email' =>  $request->email,
            'chave' =>  $request->chave,
            'dataadesao' =>  $request->dataadesao,
            'observacao' => $request->observacao,
            'cep' =>  $request->cep,
            'rua' =>  $request->rua,
            'numero' =>  $request->numero,
            'bairro' =>  $request->bairro,
            'cidade' =>  $request->cidade,
            'estado' =>  $request->estado,
            'situacao' => $request->situacao
        ]);

        return response()->json($cliente, 201);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        /* Procurando uma instalacao, e junto do seu retôrno, todos os registros
        relacionados de roteradores
        O 'with()' é usado para informações de relacionamentos */
        /*  $antena = $this->aaantena->with('roteadores')->find($id); */
        $cliente = $this->cccliente->find($id);
        if ($cliente === null) {
            /* helper 'response()' do laravel */
            /* Através dele, podemos alterar os detalhes da resposta dada pelo laravel*/
            /* Como 2º parâmetro do método 'json()', podemos passar o status code http */
            return response()->json(['erro' => 'Recurso não existe'], 404);
        }
        return response()->json($cliente, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function edit(Cliente $cliente)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        /* Variável $antena sendo instanciando como objeto do tipo 'Antena' */
        $cliente = $this->cccliente->find($id);

        if ($cliente === null) {
            /* helper 'response()' do laravel */
            /* Através dele, podemos alterar os detalhes da resposta dada pelo laravel*/
            /* Como 2º parâmetro do método 'json()', podemos passar o status code http */
            return response()->json(['erro' => 'Impossível realizar a atualização. O recurso não existe.'], 404);
        }

        /* Método 'PATH' permite o envio parcial de parâmetros */
        if ($request->method() === 'PATCH') {

            $regrasDinamicas = array();

            /* Percorrendo todas as regras( rules() ) definidas no Model */
            foreach ($cliente->rules() as $input => $regra) {

                /* Coletar apenas as regras aplicáveis aos parâmetros parciais da requisição PATCH */
                /* Método nativo do PHP que varre o array procurando a chave "$input" no mesmo */
                if (array_key_exists($input, $request->all())) {
                    $regrasDinamicas[$input] = $regra;
                }
            }

            $request->validate($regrasDinamicas, $cliente->feedback());
        } else {
            $request->validate($cliente->rules(), $cliente->feedback());
        }

        /* Preenchendo o objeto $antena com "todos" os dados do request */
        $cliente->fill($request->all());

        /* Se a imagem foi enviada na requisição */
        if ($request->file('imagem')) {
            /* Remove a imagem antiga caso uma nova imagem tenha sido enviado no request do update */
            /* 'Storage' é um façade do laravel */
            Storage::disk('public')->delete($cliente->imagem);

            $imagem = $request->file('imagem');
            $imagem_urn = $imagem->store('imagens/clientes', 'public');
            $cliente->imagem = $imagem_urn;
        }

        $cliente->save();

        return response()->json($cliente, 200);

        //$imagem = $request->file('imagem');

        /* O método store() espera dois parâmetros */
        //$image->store( 'path', 'disco' );
        //$imagem_urn = $imagem->store('imagens/clientes', 'public');

        /* Quando o update for PATCH, não atualizando todos os atributos, para não dar êrros,
        preenchendo o objeto $antena com todos os dados do request. Os atributos que não
        estiverem sendo alterados, serão repetidos dos dados anteriores, trazidos do banco
        de dados. */
        //$cliente->fill($request->all());
        //$cliente->imagem = $imagem_urn;
        //dd( $cliente->getAttributes() );
        //$cliente->save();

        /*
        $cliente->update( [] );
            */

        //return response()->json($cliente, 200);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cliente = $this->cccliente->find($id);

        if ($cliente === null) {
            /* helper 'response()' do laravel */
            /* Através dele, podemos alterar os detalhes da resposta dada pelo laravel*/
            /* Como 2º parâmetro do método 'json()', podemos passar o status code http */
            return response()->json(['erro' => 'Impossível excluir. O registro não existe.'], 404);
        }

        /* Remove a imagem*/
        /* 'Storage' é um façade do laravel */
        Storage::disk('public')->delete($cliente->imagem);

        /* Remove então o registro */
        $cliente->delete();
        return response()->json(['msg' => 'A instalacao foi removida com sucesso!'], 200);
    }
}
