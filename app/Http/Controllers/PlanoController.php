<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Plano;
use Illuminate\Http\Request;
use App\Repositories\PlanoRepository;

class PlanoController extends Controller
{

    /* Construtor desta classe, para quando o objeto
    ( esta classe ) for instanciada. Está usando a
    sugestão de tipo ( type-hinting ), para injetar
    a instância do respectivo model neste controller.
    */

    public function __construct(Plano $plano)
    {
        $this->ppplano = $plano;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $planoRepository = new PlanoRepository($this->ppplano);

        /* Verificando se um determinado parâmetro existe/está definido no request */
        /* if ($request->has('atributos_antena')) {
            $atributos_antena = 'antena:id,' . $request->atributos_antena;
            $roteadorRepository->selectAtributosRegistrosRelacionados($atributos_antena);
        } else {
            $roteadorRepository->selectAtributosRegistrosRelacionados('antena');
        } */

        /* Verificando se um determinado parâmetro existe/está definido no request */
        if ($request->has('filtro')) {
            $planoRepository->filtro($request->filtro);
        }

        /* Verificando se um determinado parâmetro existe/está definido no request */
        if ($request->has('atributos')) {
            $planoRepository->selectAtributos($request->atributos);
        }

        return response()->json($planoRepository->getResultadoPaginado(3), 200);
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

        $request->validate($this->ppplano->rules(), $this->ppplano->feedback());

        $plano = $this->ppplano->create([
            'banda' => $request->banda,
            'cir' => $request->cir,
            'equipamento' => $request->equipamento,
            'nome' => $request->nome,
           /*  'situacao' => $request->situacao, */
            'valor' => $request->valor,
            'valordecusto' => $request->valordecusto,
            'valormensal' => $request->valormensal,
            'velocmaxdown' => $request->velocmaxdown,
            'velocmaxup' => $request->velocmaxup,
            'velocmindown' => $request->velocmindown,
            'velocminup' => $request->velocminup,
            'observacao' => $request->observacao,
        ]);

        return response()->json($plano, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Plano  $plano
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        /* Procurando uma instalacao, e junto do seu retôrno, todos os registros
        relacionados de roteradores
        O 'with()' é usado para informações de relacionamentos */
        /*  $antena = $this->aaantena->with('roteadores')->find($id); */
        $plano = $this->ppplano->find($id);
        if ($plano === null) {
            /* helper 'response()' do laravel */
            /* Através dele, podemos alterar os detalhes da resposta dada pelo laravel*/
            /* Como 2º parâmetro do método 'json()', podemos passar o status code http */
            return response()->json(['erro' => 'Recurso não existe'], 404);
        }
        return response()->json($plano, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Plano  $plano
     * @return \Illuminate\Http\Response
     */
    public function edit(Plano $plano)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Plano  $plano
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        /* Variável $antena sendo instanciando como objeto do tipo 'Antena' */
        $plano = $this->ppplano->find($id);

        if ($plano === null) {
            /* helper 'response()' do laravel */
            /* Através dele, podemos alterar os detalhes da resposta dada pelo laravel*/
            /* Como 2º parâmetro do método 'json()', podemos passar o status code http */
            return response()->json(['erro' => 'Impossível realizar a atualização. O recurso não existe.'], 404);
        }

        /* Método 'PATH' permite o envio parcial de parâmetros */
        if ($request->method() === 'PATCH') {

            $regrasDinamicas = array();

            /* Percorrendo todas as regras( rules() ) definidas no Model */
            foreach ($plano->rules() as $input => $regra) {

                /* Coletar apenas as regras aplicáveis aos parâmetros parciais da requisição PATCH */
                /* Método nativo do PHP que varre o array procurando a chave "$input" no mesmo */
                if (array_key_exists($input, $request->all())) {
                    $regrasDinamicas[$input] = $regra;
                }
            }

            $request->validate($regrasDinamicas, $plano->feedback());
        } else {
            $request->validate($plano->rules(), $plano->feedback());
        }

        /* Quando o update for PATCH, não atualizando todos os atributos, para não dar êrros,
        preenchendo o objeto $antena com todos os dados do request. Os atributos que não
        estiverem sendo alterados, serão repetidos dos dados anteriores, trazidos do banco
        de dados. */
        $plano->fill($request->all());

        $plano->save();

        return response()->json($plano, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Plano  $plano
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $plano = $this->ppplano->find($id);

        if ($plano === null) {
            /* helper 'response()' do laravel */
            /* Através dele, podemos alterar os detalhes da resposta dada pelo laravel*/
            /* Como 2º parâmetro do método 'json()', podemos passar o status code http */
            return response()->json(['erro' => 'Impossível excluir. O registro não existe.'], 404);
        }

        /* Remove então o registro */
        $plano->delete();
        return response()->json(['msg' => 'A instalacao foi removida com sucesso!'], 200);
    }
}
