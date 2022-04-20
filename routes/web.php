<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/* Rota protegida com o middleware auth.
   Somente autenticada, por sessão */
Route::get('/antenas', function () {
         return view('app.antenas');
})->name('antenas')->middleware('auth');

/* Rota protegida com o middleware auth.
   Somente autenticada, por sessão */
      Route::get('/roteadores', function () {
    return view('app.roteadores');
})->name('roteadores')->middleware('auth');

/* Rota protegida com o middleware auth.
   Somente autenticada, por sessão */
      Route::get('/clientes', function () {
    return view('app.clientes');
})->name('clientes')->middleware('auth');

/* Rota protegida com o middleware auth.
   Somente autenticada, por sessão */
      Route::get('/instalacoes', function () {
    return view('app.instalacoes');
})->name('instalacoes')->middleware('auth');

/* Rota protegida com o middleware auth.
   Somente autenticada, por sessão */
      Route::get('/instaladores', function () {
    return view('app.instaladores');
})->name('instaladores')->middleware('auth');

/* Rota protegida com o middleware auth.
   Somente autenticada, por sessão */
      Route::get('/planos', function () {
    return view('app.planos');
})->name('planos')->middleware('auth');

/* Definindo um grupo de rotas, através do método group(), para o middleware "auth", que é o
 * middlaware que verifica se o usuário está logado, se não estiver, direciona para o login.
 * Agora, todas as rotas dentro da função anômima, estão protegidas pela autenticação. */
/* Declarando um único método de rota que vai criar todas as rotas que precisamos: */
/* 1º parâmetro: O nome do recurso(no plural) e 2º parâmetro, o controler: */
//Route::middleware('auth')->group(function () {

    //Route::resource('antenas', 'AntenaController');

    //Route::resource('cabos', 'CaboController');

    //Route::resource('empresas', 'EmpresaController');

    //Route::resource('fontes', 'FonteController');

    //Route::resource('grooves', 'GrooveController');

    //Route::resource('instaladores', 'InstaladorController');

    //Route::resource('roteadores', 'RoteadorController');

    //Route::resource('modens', 'ModemController');

    //Route::resource('lnbs', 'LnbController');

    //Route::resource('ilnbs', 'IlnbController');

    //Route::resource('historicos', 'HistoricoController');

    //Route::resource('planos', 'PlanoController');

    //Route::resource('clientes', 'ClienteController');

    //Route::resource('distribuidores', 'DistribuidorController');

    //Route::resource('migracoes', 'MigracaoController');

    /*  Route::resource('users', 'UsersController'); */

    //Route::resource('ferramentas', 'FerramentaController');

    //Route::resource('equipamentos', 'EquipamentoController');

    //Route::resource('designacoes', 'DesignacaoController');

    /* Route::resource('medirvelocidades', 'MedirVelocidadeController'); */

    //Route::resource('modelocontratos', 'ModelocontratoController');

    //Route::resource('contratos', 'ContratoController');

    //Route::resource('chamados', 'ChamadoController');
//});
