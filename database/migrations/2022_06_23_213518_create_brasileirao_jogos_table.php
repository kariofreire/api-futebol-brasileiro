<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrasileiraoJogosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brasileirao_jogos', function (Blueprint $table) {
            $table->id();

            $table->integer("rodada")->nullable(false)->comment("Define a rodada dos jogos.");
            $table->year("temporada")->nullable(false)->comment("Define o ano dos jogos.");
            $table->json("tabela")->nullable(false)->comment("Armazena os jogos da rodada em JSON.");

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
        Schema::dropIfExists('brasileirao_jogos');
    }
}
