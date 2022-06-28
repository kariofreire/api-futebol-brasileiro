<?php

namespace App\Repositories;

use App\Models\BrasileiraoJogos;
use App\Repositories\Contracts\BrasileiraoJogosRepositoryInterface;
use Carbon\Carbon;

class BrasileiraoJogosRepository implements BrasileiraoJogosRepositoryInterface
{
    /** @var BrasileiraoJogos $entity */
    protected $entity;

    /**
     * Define o Model utilizado neste repository.
     *
     * @param BrasileiraoJogos $brasileiraoJogos
     */
    public function __construct(BrasileiraoJogos $brasileiraoJogos)
    {
        $this->entity = $brasileiraoJogos;
    }

    /**
     * Recupera os jogos da rodada atual do campeonato brasileiro.
     *
     * @param Int $rodada
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function jogosDaRodada(int $rodada)
    {
        return $this->entity::query()
            ->where("temporada", Carbon::now()->format("Y"))
            ->where("rodada", $rodada)
            ->first();
    }

    /**
     * Recupera todos os jogos do brasileirão pelo ano atual.
     *
     * @param Request $request
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAllJogosBrasileirao()
    {
        return $this->entity->where("temporada", Carbon::now()->format("Y"))->get();
    }

    /**
     * Recupera os jogos de uma rodada da tabela do Brasileirão.
     *
     * @param Int $rodada
     * @param String $temporada
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function jogosPorRodada(int $rodada, string $temporada)
    {
        return $this->entity::query()
            ->where("rodada", (int) $rodada)
            ->where("temporada", $temporada)
            ->first();
    }

    /**
     * Recupera os jogos de um time pelo campeonato brasileiro.
     *
     * @param String $nome_time
     * @param String $temporada
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function jogosPorTime(string $nome_time, string $temporada)
    {
        return $this->entity::query()
            ->where("temporada", $temporada)
            ->orderBy("rodada")
            ->get()
            ->map(function($dados) use ($nome_time) {
                $dados->jogos = collect(json_decode($dados->jogos));
                $dados->jogos = $dados->jogos->where("time_casa", $nome_time)->first() ?? $dados->jogos->where("time_visitante", $nome_time)->first();
                $dados->jogos = json_encode($dados->jogos);

                return $dados;
            });
    }
}
