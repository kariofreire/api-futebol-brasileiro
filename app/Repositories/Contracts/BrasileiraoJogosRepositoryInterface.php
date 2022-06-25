<?php

namespace App\Repositories\Contracts;

interface BrasileiraoJogosRepositoryInterface
{
    /**
     * Recupera os jogos da rodada atual do campeonato brasileiro.
     *
     * @param Int $rodada
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function jogosDaRodada(int $rodada);

    /**
     * Recupera todos os jogos do brasileirão pelo ano atual.
     *
     * @param Request $request
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAllJogosBrasileirao();

    /**
     * Recupera os jogos de uma rodada da tabela do Brasileirão.
     *
     * @param Int $rodada
     * @param String $temporada
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function jogosPorRodada(int $rodada, string $temporada);
}
