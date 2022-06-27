<?php

namespace App\Utils;

class EstatisticasJogosBrasileirao extends UtilsAbstract
{
    /** @var String PATTERN INFO JOGO */
    const PATTERN_INFO_JOGO = '/\<div class\=\"live__content__scoreboard\">(.*?)<div class\=\"live__content__narration\">/s';

    /** @var String PATTERN INFO CARTÕES 1° TEMPO */
    const PATTERN_INFO_CARTOES_1_TEMPO = '/\<div class\=\"live__content__narration__expandable-card__header__events\">(.*?)<\/div>/s';

    /** @var String PATTERN INFO CARTÕES 2° TEMPO */
    const PATTERN_INFO_CARTOES_2_TEMPO = '/\<div class\=\"live__content__narration__expandable-card__header__events\">(.*?)<\/div>/s';

    /** @var String PATTERN INFO ESCALAÇÕES */
    const PATTERN_INFO_ESCALACOES = '/\<div class\=\"live__content__lineup\">(.*?)<div class\=\"live__content__expandable-card card card-app card-app-v loading-app\" id\=\"teams-container\">/s';

    /**
     * Retorna detalhes da jogo pelo código de referência.
     *
     * @param String $url
     * @param String $pattern
     *
     * @return \Illuminate\Support\Collection
     */
    public function jsonEstatisticas(string $url, string $pattern)
    {
        $data = collect();

        [$dados_completos, $dados_otmizados] = $this->file_get_contents_utf8($url, $pattern);

        $info_jogo = $this->get_string_to_pattern(collect($dados_otmizados)->first(), self::PATTERN_INFO_JOGO, true);

        $info_jogo->map(function ($dados_jogo) use (&$info_jogo) {
            $info_jogo = $this->info_jogo_static($dados_jogo);
        });

        $info_cartoes_1_tempo = $this->get_string_to_pattern(collect($dados_otmizados)->first(), self::PATTERN_INFO_CARTOES_1_TEMPO, true);

        $info_cartoes_1_tempo->map(function ($dados_cartoes, $key) use (&$info_cartoes_1_tempo, $info_jogo) {
            if (!in_array($key, [1])) return true;
            $info_cartoes_1_tempo = $this->info_cartoes_static($dados_cartoes, $info_jogo['time_casa'], $info_jogo['time_visitante']);
        });

        $info_cartoes_2_tempo = $this->get_string_to_pattern(collect($dados_otmizados)->first(), self::PATTERN_INFO_CARTOES_2_TEMPO, true);

        $info_cartoes_2_tempo->map(function ($dados_cartoes, $key) use (&$info_cartoes_2_tempo, $info_jogo) {
            if (!in_array($key, [0])) return true;
            $info_cartoes_2_tempo = $this->info_cartoes_static($dados_cartoes, $info_jogo['time_casa'], $info_jogo['time_visitante']);
        });

        $info_cartoes = [];

        foreach ($info_cartoes_1_tempo as $indice => $valor) {
            $info_cartoes[$indice] = $valor + $info_cartoes_2_tempo[$indice];
        }

        $data = $data->merge(array_merge($info_jogo, $info_cartoes));

        $info_escalacoes = $this->get_string_to_pattern(collect($dados_otmizados)->first(), self::PATTERN_INFO_ESCALACOES, true)->first();
        $info_escalacoes = $this->info_ecalacoes_static($info_escalacoes);

        $data = $data->merge($info_escalacoes);

        return $data;
    }
}
