<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstalacaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instalacaos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cliente_id');
            $table->string('imagem', 100);
            $table->string('rua', 60);
            $table->string('numero', 5);
            $table->string('bairro', 30);
            $table->string('cidade', 50);
            $table->string('estado', 2);
            $table->string('celular', 16);
            $table->string('telefone', 16);
            $table->string('status', 20);
            $table->string('banda', 4);
            $table->unsignedBigInteger('instalador_id');
            $table->unsignedBigInteger('distribuidor_id');
            $table->unsignedBigInteger('plano_id');
            $table->dateTime('dataInstalacao');
            $table->string('observacao', 100);
            $table->string('notaFiscal', 12);
            $table->dateTime('dataNota',);
            $table->timestamps();

            //foreign key (constraints)
            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->foreign('instalador_id')->references('id')->on('instaladores');
            $table->foreign('plano_id')->references('id')->on('planos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('instalacaos');
    }
}
