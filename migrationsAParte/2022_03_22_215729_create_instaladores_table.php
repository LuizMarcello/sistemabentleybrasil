<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstaladoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instaladores', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->unsignedBigInteger('instalacao_id');
            $table->string('cpf');
            $table->string('rg');
            $table->string('celular');
            $table->string('telefone');
            $table->string('email');
            $table->string('cep');
            $table->string('bairro');
            $table->string('cidade');
            $table->string('estado');
            $table->string('observacao');
            $table->string('situacao');
            $table->string('rua');
            $table->string('numero');
            $table->dateTime('dataNascimento');
            $table->string('imagem');
            $table->timestamps();

            //foreign key (constraints)
            $table->foreign('instalacao_id')->references('id')->on('instalacaos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('instaladores');
    }
}
