<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Roteador;
use Illuminate\Http\Request;
use App\Repositories\RoteadorRepository;

class RoteadorController extends Controller
{
    /* Construtor desta classe, para quando o objeto
    ( esta classe ) for instanciada. Está usando a
    sugestão de tipo ( type-hinting ), para injetar
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

    public function index(Request $request)
    {
        $roteadorRepository = new RoteadorRepository($this->rrroteador);

        /* Verificando se um determinado parâmetro existe/está definido no request */
        if ($request->has('atributos_antena')) {
            $atributos_antena = 'antena:id,' . $request->atributos_antena;
            $roteadorRepository->selectAtributosRegistrosRelacionados($atributos_antena);
        } else {
            $roteadorRepository->selectAtributosRegistrosRelacionados('antena');
        }

        /* Verificando se um determinado parâmetro existe/está definido no request */
        if ($request->has('filtro')) {
            $roteadorRepository->filtro($request->filtro);
        }

        /* Verificando se um determinado parâmetro existe/está definido no request */
        if ($request->has('atributos')) {
            $roteadorRepository->selectAtributos($request->atributos);
        }

        return response()->json($roteadorRepository->getResultadoPaginado(3), 200);
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

        $request->validate($this->rrroteador->rules(), $this->rrroteador->feedback());

        $imagem = $request->file('imagem');

        $imagem_urn = $imagem->store('imagens/roteadores', 'public');

        $roteador = $this->rrroteador->create([
            //'nome' => $request->nome,
            'imagem' => $imagem_urn,
            'banda' => $request->banda,
            'marca' => $request->marca,
            'antena_id' => $request->antena_id,
            'datanota' => $request->datanota,
            'macaddress' => $request->macaddress,
            'modelo' => $request->modelo,
            'notafiscal' => $request->notafiscal,
            'serial' => $request->serial,
            'situacao' => $request->situacao,
            'observacao' => $request->observacao

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
        /* Pesquisando um 'roteador' e adicionando seu relacionamento com 'antena'
        O 'with()' é usado para informações de relacionamentos */
        $roteador = $this->rrroteador->with('antena')->find($id);
        if ($roteador === null) {
            /* helper 'response()' do laravel */
            /* Através dele, podemos alterar os detalhes da resposta dada pelo laravel*/
            /* Como 2º parâmetro do método 'json()', podemos passar o status code http */
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
        //print_r( $request->all() );
        //Os dados atualizados.
        //print_r( $antena->getAttributes() );
        //Os dados antigos, antes do update

        /* Variável $roteador sendo instanciando como objeto do tipo 'Roteador' */
        $roteador = $this->rrroteador->find($id);

        if ($roteador === null) {
            /* helper 'response()' do laravel */
            /* Através dele, podemos alterar os detalhes da resposta dada pelo laravel*/
            /* Como 2º parâmetro do método 'json()', podemos passar o status code http */

            return response()->json(['erro' => 'Impossível realizar a atualização. O recurso não existe.'],
             404);
        }

        /* Método 'PATH' permite o envio parcial de parâmetros */
        if ($request->method() === 'PATCH') {

            $regrasDinamicas = array();

            /* Percorrendo todas as regras( rules() ) definidas no Model */
            foreach ($roteador->rules() as $input => $regra) {

                /* Coletar apenas as regras aplicáveis aos parâmetros parciais da requisição PATCH */
                /* Método nativo do PHP que varre o array procurando a chave "$input" no mesmo */
                if (array_key_exists($input, $request->all())) {
                    $regrasDinamicas[$input] = $regra;
                }
            }

            $request->validate($regrasDinamicas, $roteador->feedback());
        } else {
            $request->validate($roteador->rules(), $roteador->feedback());
        }

       /* Preenchendo o objeto $roteador com "todos" os dados do request */
       $roteador->fill($request->all());

       /* Se a imagem foi enviada na requisição */
       if ($request->file('imagem')) {
           /* Remove a imagem antiga caso uma nova imagem tenha sido enviado no request do update */
           /* 'Storage' é um façade do laravel */
           Storage::disk('public')->delete($roteador->imagem);

           $imagem = $request->file('imagem');
           $imagem_urn = $imagem->store('imagens/roteadores', 'public');
           $roteador->imagem = $imagem_urn;
       }

       $roteador->save();

       return response()->json($roteador, 200);

       //$imagem = $request->file('imagem');

       /* O método store() espera dois parâmetros */
       //$image->store( 'path', 'disco' );
       //$imagem_urn = $imagem->store('imagens/roteadores', 'public');

       /* Quando o update for PATCH, não atualizando todos os atributos, para não dar êrros,
       preenchendo o objeto $roteador com todos os dados do request. Os atributos que não
       estiverem sendo alterados, serão repetidos dos dados anteriores, trazidos do banco
       de dados. */
       //$roteador->fill($request->all());
       //$roteador->imagem = $imagem_urn;
       //dd( $roteador->getAttributes() );
       //$roteador->save();

       /*
       $roteador->update( [
           'nome' => $request->nome,
           'imagem' => $imagem_urn, */
       //'banda' => $request->banda,
       //'datanota' => $request->datanota,
       //'marca' => $request->marca,
       //'modelo' => $request->modelo,
       //'notafiscal' => $request->notafiscal,
       //'situacao' => $request->situacao,
       //'diametro' => $request->diametro,
       //'observacao' => $request->observacao
       /* ] );
           */

       //return response()->json($roteador, 200);
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
