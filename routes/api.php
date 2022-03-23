<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/* Devemos retornam sempre, para as requisições feitas para as rotas
   API, um array associativo. Então será retornado na resposta desta
   requisição, content-type do tipo "Application-json". */
Route::get('/', function () {
    return ['Chegamos até aqui' => 'SIM'];
});


//Route::middleware('auth')->group(function () {

    Route::apiresource('antenas', 'AntenaController');

    //Route::apiresource('cabos', 'CaboController');

    //Route::apiresource('empresas', 'EmpresaController');

    //Route::apiresource('fontes', 'FonteController');

    //Route::apiresource('grooves', 'GrooveController');

    //Route::apiresource('instaladores', 'InstaladorController');

    //Route::apiresource('roteadores', 'RoteadorController');

    //Route::apiresource('modens', 'ModemController');

    //Route::apiresource('lnbs', 'LnbController');

    //Route::apiresource('ilnbs', 'IlnbController');

    //Route::apiresource('historicos', 'HistoricoController');

    //Route::apiresource('planos', 'PlanoController');

    //Route::apiresource('clientes', 'ClienteController');

    //Route::apiresource('distribuidores', 'DistribuidorController');

    //Route::apiresource('migracoes', 'MigracaoController');

    /*  Route::apiresource('users', 'UsersController'); */

    //Route::apiresource('ferramentas', 'FerramentaController');

    //Route::apiresource('equipamentos', 'EquipamentoController');

    //Route::apiresource('designacoes', 'DesignacaoController');

    /* Route::apiresource('medirvelocidades', 'MedirVelocidadeController'); */

    //Route::apiresource('modelocontratos', 'ModelocontratoController');

    //Route::apiresource('contratos', 'ContratoController');

    //Route::apiresource('chamados', 'ChamadoController');
//});
