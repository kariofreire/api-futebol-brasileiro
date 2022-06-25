<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrasileiraoJogosDetalhes extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "brasileirao_jogos_detalhes";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        "codigo_referencia_jogo",
        "nome_estadio",
        "data_hora_jogo",

        "time_casa",
        "time_casa_gols",
        "time_casa_posse_bola",
        "time_casa_cartoes_amarelos",
        "time_casa_cartoes_vermelhos",
        "time_casa_escalacao",

        "time_visitante",
        "time_visitante_gols",
        "time_visitante_posse_bola",
        "time_visitante_cartoes_amarelos",
        "time_visitante_cartoes_vermelhos",
        "time_visitante_escalacao",

        "estatisticas"
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        "id",
        "created_at",
        "updated_at"
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array<string>
     */
    protected $dates = [
        "created_at",
        "updated_at"
    ];
}
