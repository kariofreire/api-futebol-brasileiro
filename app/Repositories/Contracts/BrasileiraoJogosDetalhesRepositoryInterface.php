<?php

namespace App\Repositories\Contracts;

interface BrasileiraoJogosDetalhesRepositoryInterface
{
    /**
     * Recupera detalhes de um jogo do campeonato brasileiro pelo código de referência.
     *
     * @param String $codigo_referencia
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function detalhes_do_jogo(string $codigo_referencia);
}
