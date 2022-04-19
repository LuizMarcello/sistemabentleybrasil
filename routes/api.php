<?php

use App\Http\Controllers\AuthController;
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

/* Rotas protegidas: */
/* Agrupando estas rotas e acrescentando o middleware(configurado em app/http/kernel.php).
   Assim estas rotas ficam protegidas pelo tokem JWT, retornado na autenticação.
   Fica possível então acessar estas rotas.  */
/* prefix: versionamento deste grupo de rotas.
   Então agora este prefix tem que ser acrescentado na url */
/* Quando a rota inicia com "apiresource", não precisa colocar o
   controller e o método(action), pois serve para todos os actions
   do controller. */
Route::prefix('v1')->middleware('jwt.auth')->group(function () {
    Route::post('me', 'AuthController@me');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::apiresource('antenas', 'AntenaController');
    //Route::apiresource('cabos', 'CaboController');
    //Route::apiresource('empresas', 'EmpresaController');
    //Route::apiresource('fontes', 'FonteController');
    //Route::apiresource('grooves', 'GrooveController');
    Route::apiresource('instaladores', 'InstaladorController');
    Route::apiresource('roteadores', 'RoteadorController');
    //Route::apiresource('modens', 'ModemController');
    //Route::apiresource('lnbs', 'LnbController');
    //Route::apiresource('ilnbs', 'IlnbController');
    //Route::apiresource('historicos', 'HistoricoController');
    //Route::apiresource('planos', 'PlanoController');
    Route::apiresource('clientes', 'ClienteController');
    //Route::apiresource('distribuidores', 'DistribuidorController');
    //Route::apiresource('migracoes', 'MigracaoController');
    /* Route::apiresource('users', 'UsersController'); */
    //Route::apiresource('ferramentas', 'FerramentaController');
    //Route::apiresource('equipamentos', 'EquipamentoController');
    //Route::apiresource('designacoes', 'DesignacaoController');
    /* Route::apiresource('medirvelocidades', 'MedirVelocidadeController'); */
    //Route::apiresource('modelocontratos', 'ModelocontratoController');
    //Route::apiresource('contratos', 'ContratoController');
    //Route::apiresource('chamados', 'ChamadoController');
    Route::apiresource('instalacoes', 'InstalacaoController');
});

/* Rotas públicas: */
Route::post('login', 'AuthController@login');
