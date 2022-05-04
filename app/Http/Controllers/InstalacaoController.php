<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Instalacao;
use Illuminate\Http\Request;
use App\Repositories\InstalacaoRepository;

use App\Repositories\AntenaRepository;

class InstalacaoController extends Controller
{
    /* Construtor desta classe, para quando o objeto
    ( esta classe ) for instanciada. Está usando a
    sugestão de tipo ( type-hinting ), para injetar
    a instância do respectivo model neste controller.
    */

    public function __construct(Instalacao $instalacao)
    {
        $this->iiinstalacao = $instalacao;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $instalacaoRepository = new InstalacaoRepository($this->iiinstalacao);

        /* Verificando se um determinado parâmetro existe/está definido no request */
        if ($request->has('filtro')) {
            $instalacaoRepository->filtro($request->filtro);
        }

        /* Verificando se um determinado parâmetro existe/está definido no request */
        if ($request->has('atributos')) {
            $instalacaoRepository->selectAtributos($request->atributos);
        }

        return response()->json($instalacaoRepository->getResultadoPaginado(3), 200);
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

        $request->validate($this->iiinstalacao->rules(), $this->iiinstalacao->feedback());

        $imagem = $request->file('imagem');
        /* O método store() espera dois parâmetros */
        //$image->store( 'path', 'disco' );
        $imagem_urn = $imagem->store('imagens/instalacoes', 'public');

        $instalacao = $this->iiinstalacao->create([
            'imagem' => $imagem_urn,
            'cliente_id' => $request->cliente_id,
            'rua' => $request->rua,
            'numero' =>  $request->numero,
            'bairro' => $request->bairro,
            'cidade' => $request->cidade,
            'estado' => $request->estado,
            'celular' => $request->celular,
            'telefone' => $request->telefone,
            'status' => $request->status,
            'banda' => $request->banda,
            'instalador_id' => $request->instalador_id,
            'distribuidor_id' => $request->distribuidor_id,
            'plano_id' => $request->plano_id,
            'dataInstalacao' => $request->dataInstalacao,
            'observacao' => $request->observacao,
            'notaFiscal' => $request->notaFiscal,
            'dataDaNota' => $request->dataDaNota,
        ]);

        return response()->json($instalacao, 201);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Instalacao  $instalacao
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        /* Procurando uma instalacao, e junto do seu retôrno, todos os registros
        relacionados de roteradores
        O 'with()' é usado para informações de relacionamentos */
        /*  $antena = $this->aaantena->with('roteadores')->find($id); */
        $instalacao = $this->iiinstalacao->find($id);
        if ($instalacao === null) {
            /* helper 'response()' do laravel */
            /* Através dele, podemos alterar os detalhes da resposta dada pelo laravel*/
            /* Como 2º parâmetro do método 'json()', podemos passar o status code http */
            return response()->json(['erro' => 'Recurso não existe'], 404);
        }
        return response()->json($instalacao, 200);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Instalacao  $instalacao
     * @return \Illuminate\Http\Response
     */
    public function edit(Instalacao $instalacao)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Instalacao  $instalacao
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        /* Variável $antena sendo instanciando como objeto do tipo 'Antena' */
        $instalacao = $this->iiinstalacao->find($id);

        if ($instalacao === null) {
            /* helper 'response()' do laravel */
            /* Através dele, podemos alterar os detalhes da resposta dada pelo laravel*/
            /* Como 2º parâmetro do método 'json()', podemos passar o status code http */
            return response()->json(['erro' => 'Impossível realizar a atualização. O recurso não existe.'], 404);
        }

        /* Método 'PATH' permite o envio parcial de parâmetros */
        if ($request->method() === 'PATCH') {

            $regrasDinamicas = array();

            /* Percorrendo todas as regras( rules() ) definidas no Model */
            foreach ($instalacao->rules() as $input => $regra) {

                /* Coletar apenas as regras aplicáveis aos parâmetros parciais da requisição PATCH */
                /* Método nativo do PHP que varre o array procurando a chave "$input" no mesmo */
                if (array_key_exists($input, $request->all())) {
                    $regrasDinamicas[$input] = $regra;
                }
            }

            $request->validate($regrasDinamicas, $instalacao->feedback());
        } else {
            $request->validate($instalacao->rules(), $instalacao->feedback());
        }

        /* Preenchendo o objeto $antena com "todos" os dados do request */
        $instalacao->fill($request->all());

        /* Se a imagem foi enviada na requisição */
        if ($request->file('imagem')) {
            /* Remove a imagem antiga caso uma nova imagem tenha sido enviado no request do update */
            /* 'Storage' é um façade do laravel */
            Storage::disk('public')->delete($instalacao->imagem);

            $imagem = $request->file('imagem');
            $imagem_urn = $imagem->store('imagens/instalacoes', 'public');
            $instalacao->imagem = $imagem_urn;
        }

        $instalacao->save();

        return response()->json($instalacao, 200);

        //$imagem = $request->file('imagem');

        /* O método store() espera dois parâmetros */
        //$image->store( 'path', 'disco' );
        //$imagem_urn = $imagem->store('imagens/instalacoes', 'public');

        /* Quando o update for PATCH, não atualizando todos os atributos, para não dar êrros,
         preenchendo o objeto $instalacao com todos os dados do request. Os atributos que não
         estiverem sendo alterados, serão repetidos dos dados anteriores, trazidos do banco
         de dados. */
        //$instalacao->fill($request->all());
        //$instalacao->imagem = $imagem_urn;
        //dd( $instalacao->getAttributes() );
        //$instalacao->save();

        /*
         $instalacao->update( [ ] );
        */

        //return response()->json($instalacao, 200);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Instalacao  $instalacao
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $instalacao = $this->iiinstalacao->find($id);

        if ($instalacao === null) {
            /* helper 'response()' do laravel */
            /* Através dele, podemos alterar os detalhes da resposta dada pelo laravel*/
            /* Como 2º parâmetro do método 'json()', podemos passar o status code http */
            return response()->json(['erro' => 'Impossível excluir. O registro não existe.'], 404);
        }

        /* Remove a imagem*/
        /* 'Storage' é um façade do laravel */
        Storage::disk('public')->delete($instalacao->imagem);

        /* Remove então o registro */
        $instalacao->delete();
        return response()->json(['msg' => 'A instalacao foi removida com sucesso!'], 200);
    }
}
