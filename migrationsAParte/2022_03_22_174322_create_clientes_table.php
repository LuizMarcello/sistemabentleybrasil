<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('imagem', 100);
            $table->string('nome_razaosocial');
            $table->string('cpf');
            $table->string('ie_rg');
            $table->string('nome_contato');
            $table->string('celular');
            $table->string('telefone');
            $table->string('email');
            $table->string('chave');
            $table->dateTime('dataadesao');
            $table->string('observacao');
            $table->string('cep');
            $table->string('rua');
            $table->string('numero');
            $table->string('bairro');
            $table->string('cidade');
            $table->string('estado');
            $table->string('situacao');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clientes');
    }
}
