<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrasileiraoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brasileirao', function (Blueprint $table) {
            $table->id();

            $table->integer("rodada")->nullable(false)->comment("Define a rodada da tabela.");
            $table->year("temporada")->nullable(false)->comment("Define o ano do campeonato.");
            $table->json("tabela")->nullable(false)->comment("Armazena a tabela completa em JSON.");

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
        Schema::dropIfExists('brasileirao');
    }
}
