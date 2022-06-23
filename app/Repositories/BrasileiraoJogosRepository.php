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
}
