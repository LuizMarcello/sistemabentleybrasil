<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoteadorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roteadors', function (Blueprint $table) {
            $table->id();
            $table->char('banda', 4);
            $table->date('datanota', 12);
            $table->string('marca', 30);
            $table->string('macaddress', 16);
            $table->string('modelo', 30);
            $table->string('notafiscal', 15);
            $table->string('serial', 30);
            $table->string('situacao', 12);
            $table->string('observacao', 50);
            $table->string('imagem', 50);

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
        Schema::dropIfExists('roteadors');
    }
}
