<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Antena;
use Illuminate\Http\Request;
use App\Repositories\AntenaRepository;

class AntenaController extends Controller
{
    /* Construtor desta classe, para quando o objeto
    ( esta classe ) for instanciada. Está usando a
    sugestão de tipo ( type-hinting ), para injetar
    a instância do respectivo model neste controller.
    */

    public function __construct(Antena $antena)
    {
        $this->aaantena = $antena;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $antenaRepository = new AntenaRepository($this->aaantena);

        /* Verificando se um determinado parâmetro existe/está definido no request */
        if ($request->has('atributos_roteadores')) {
            $atributos_roteadores = 'roteadores:id,' . $request->atributos_roteadores;
            $antenaRepository->selectAtributosRegistrosRelacionados($atributos_roteadores);
        } else {
            $antenaRepository->selectAtributosRegistrosRelacionados('roteadores');
        }

        /* Verificando se um determinado parâmetro existe/está definido no request */
        if ($request->has('filtro')) {
            $antenaRepository->filtro($request->filtro);
        }

        /* Verificando se um determinado parâmetro existe/está definido no request */
        if ($request->has('atributos')) {
            $antenaRepository->selectAtributos($request->atributos);
        }

        return response()->json($antenaRepository->getResultado(), 200);
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
     * Persistência dos dados
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        /* Modo massivo */

        $request->validate($this->aaantena->rules(), $this->aaantena->feedback());

        //dd( $request->nome );
        //ou
        //dd( $request->get( 'nome' ) );
        //ou
        //dd( $request->input( 'nome' ) );

        //dd( $request->imagem );
        //ou
        //dd( $request->file( 'imagem' ) );

        $imagem = $request->file('imagem');
        /* O método store() espera dois parâmetros */
        //$image->store( 'path', 'disco' );
        $imagem_urn = $imagem->store('imagens/antenas', 'public');
        //dd( $imagem_urn );

        //$antena = $this->aaantena->create( $request->all() );

        $antena = $this->aaantena->create([
            'nome' => $request->nome,
            'imagem' => $imagem_urn,
            'banda' => $request->banda,
            'datanota' => $request->datanota,
            'marca' => $request->marca,
            'modelo' => $request->modelo,
            'notafiscal' => $request->notafiscal,
            'situacao' => $request->situacao,
            'diametro' => $request->diametro,
            'observacao' => $request->observacao
        ]);

        //ou:
        //$antena->nome = $request->nome;
        //$antena->imagem = $imagem_urn;
        //$antena->save();

        return response()->json($antena, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Integer
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        /* Procurando uma antena, e junto do seu retôrno, todos os registros
        relacionados de roteradores
        O 'with()' é usado para informações de relacionamentos */
        $antena = $this->aaantena->with('roteadores')->find($id);
        if ($antena === null) {
            /* helper 'response()' do laravel */
            /* Através dele, podemos alterar os detalhes da resposta dada pelo laravel*/
            /* Como 2º parâmetro do método 'json()', podemos passar o status code http */
            return response()->json(['erro' => 'Recurso não existe'], 404);
        }
        return response()->json($antena, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Antena  $antena
     * @return \Illuminate\Http\Response
     */

    public function edit(Antena $antena)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param Integer
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
        //print_r( $request->all() );
        //Os dados atualizados.
        //print_r( $antena->getAttributes() );
        //Os dados antigos, antes do update

        /* Variável $antena sendo instanciando como objeto do tipo 'Antena' */
        $antena = $this->aaantena->find($id);

        if ($antena === null) {
            /* helper 'response()' do laravel */
            /* Através dele, podemos alterar os detalhes da resposta dada pelo laravel*/
            /* Como 2º parâmetro do método 'json()', podemos passar o status code http */
            return response()->json(['erro' => 'Impossível realizar a atualização. O recurso não existe.'], 404);
        }

        /* Método 'PATH' permite o envio parcial de parâmetros */
        if ($request->method() === 'PATCH') {

            $regrasDinamicas = array();

            /* Percorrendo todas as regras( rules() ) definidas no Model */
            foreach ($antena->rules() as $input => $regra) {

                /* Coletar apenas as regras aplicáveis aos parâmetros parciais da requisição PATCH */
                /* Método nativo do PHP que varre o array procurando a chave "$input" no mesmo */
                if (array_key_exists($input, $request->all())) {
                    $regrasDinamicas[$input] = $regra;
                }
            }

            $request->validate($regrasDinamicas, $antena->feedback());
        } else {
            $request->validate($antena->rules(), $antena->feedback());
        }

        /* Remove a imagem antiga caso uma nova imagem tenha sido enviado no request do update */
        if ($request->file('imagem')) {
            /* 'Storage' é um façade do laravel */
            /* Remove a imagem */
            Storage::disk('public')->delete($antena->imagem);
        }

        $imagem = $request->file('imagem');

        /* O método store() espera dois parâmetros */
        //$image->store( 'path', 'disco' );
        $imagem_urn = $imagem->store('imagens/antenas', 'public');

        /* Quando o update for PATCH, não atualizando todos os atributos, para não dar êrros,
        preenchendo o objeto $antena com todos os dados do request. Os atributos que não
        estiverem sendo alterados, serão repetidos dos dados anteriores, trazidos do banco
        de dados. */
        $antena->fill($request->all());
        $antena->imagem = $imagem_urn;
        //dd( $antena->getAttributes() );
        $antena->save();

        /*
        $antena->update( [
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

        return response()->json($antena, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Integer
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $antena = $this->aaantena->find($id);

        if ($antena === null) {
            /* helper 'response()' do laravel */
            /* Através dele, podemos alterar os detalhes da resposta dada pelo laravel*/
            /* Como 2º parâmetro do método 'json()', podemos passar o status code http */
            return response()->json(['erro' => 'Impossível excluir. O registro não existe.'], 404);
        }

        /* Remove a imagem*/
        /* 'Storage' é um façade do laravel */
        Storage::disk('public')->delete($antena->imagem);

        /* Remove então o registro */
        $antena->delete();
        return response()->json(['msg' => 'A antena foi removida com sucesso!'], 200);
    }
}
