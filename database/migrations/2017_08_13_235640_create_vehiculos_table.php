<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehiculosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehiculos', function (Blueprint $table) {
            $table->increments('id');

            $table->string('placa', 45);
            $table->string('color', 45);
            $table->integer('propietario')
                ->unsigned()
                ->nullable();

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('vehiculo', function(Blueprint $table) {
            $table->foreign('propietario')
                ->references('id')->on('propietarios')
                //->onDelete('CASCADE')
                //->onDelete('SET NULL')
                //->onDelete('NO ACTION')
                ->onDelete('RESTRICT')
                //->onUpdate('CASCADE')
                //->onUpdate('SET NULL')
                //->onUpdate('NO ACTION')
                ->onUpdate('RESTRICT')
                ;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehiculo');
    }
}
