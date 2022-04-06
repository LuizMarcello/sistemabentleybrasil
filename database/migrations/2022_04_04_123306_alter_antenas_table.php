<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAntenasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('antenas', function (Blueprint $table) {
            $table->string('banda', 4);
            $table->string('datanota', 12);
            $table->string('marca', 30);
            $table->string('modelo', 30);
            $table->string('notafiscal', 15);
            $table->string('situacao', 12);
            $table->string('diametro', 8);
            $table->string('observacao', 50);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('antenas', function (Blueprint $table) {
            $table->dropColumn('banda');
            $table->dropColumn('datanota');
            $table->dropColumn('marca');
            $table->dropColumn('modelo');
            $table->dropColumn('notafiscal');
            $table->dropColumn('situacao');
            $table->dropColumn('diametro');
            $table->dropColumn('observacao');
        });
    }
}
