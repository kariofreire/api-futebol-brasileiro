<?php

namespace App\Utils;

class JogosBrasileirao extends UtilsAbstract
{
    /** @var Int RODADAS TOTAIS DO CAMPEONATO */
    const RODADAS_TOTAIS = 38;

    /** @var String Pattern para buscar os Jogos */
    const PATTERN_JOGOS = '<h3 class="header-round">';

    /** @var String Pattern para buscar Jogo */
    const PATTERN_JOGO = '/\<li class\=\"match \" itemscope\=\"itemscope\" itemtype\=\"http:\/\/schema.org\/SportsEvent\">(.*?)<\/li\>/s';

    /**
     * Retorna o JSON dos JOGOS do Brasileirão de acordo com a página WEB solicitada.
     *
     * @param String $url
     * @param String $pattern
     *
     * @return \Illuminate\Support\Collection
     */
    public function jsonJogos(string $url, string $pattern)
    {
        [$dados_completos, $dados_otmizados] = $this->file_get_contents_utf8($url, $pattern);

        $jogos_rodadas = collect([]);

        $this->get_string_to_pattern_explode(collect($dados_otmizados)->first(), self::PATTERN_JOGOS, true)->each(function($dados, $key) use (&$jogos_rodadas) {
            if (in_array($key, [0])) return true;

            $rodada = (int) str_replace("&ordf;", "", collect(explode(" ", $dados))->only(0)->first());

            if (!is_numeric($rodada) && $rodada > self::RODADAS_TOTAIS) return true;

            $jogos  = collect([]);

            $this->get_string_to_pattern($dados, self::PATTERN_JOGO, true)->each(function($partida) use (&$jogos, $rodada) {
                $jogos = $jogos->merge([$this->jogo_static($partida, $rodada)]);
            });

            $jogos_rodadas = $jogos_rodadas->merge([[
                "rodada"   => $rodada,
                "partidas" => $jogos
            ]]);
        });

        return collect($jogos_rodadas);
    }
}
