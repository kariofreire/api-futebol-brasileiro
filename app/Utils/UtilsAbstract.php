<?php

namespace App\Utils;

class UtilsAbstract
{
    /**
     * Recupera partes de um site de acordo com uma marcação da página.
     *
     * @param String $url
     * @param String $pattern
     *
     * @return array|string|false
     */
    public function file_get_contents_utf8(string $url, string $pattern)
    {
        preg_match_all($pattern, file_get_contents($url), $matches);

        return mb_convert_encoding($matches, "HTML-ENTITIES", "UTF-8");
    }

    /**
     * Recupera partes de uma string de acordo com a referência informada.
     *
     * @param String $text
     * @param String $pattern
     * @param Bool $all
     *
     * @return \Illuminate\Support\Collection
     */
    public function get_string_to_pattern(string $text, string $pattern, bool $all = false)
    {
        preg_match_all($pattern, $text, $matches);

        [$dados_completos, $dados_otmizados] = mb_convert_encoding($matches, "HTML-ENTITIES", "UTF-8");

        return $all ? collect($dados_otmizados) : collect($dados_otmizados)->first();
    }

    /**
     * Fraciona partes de uma string de acordo com a referência informada (explode).
     *
     * @param String $text
     * @param String $pattern
     * @param Bool $all
     *
     * @return \Illuminate\Support\Collection
     */
    public function get_string_to_pattern_explode(string $text, string $pattern, bool $all = false)
    {
        $content = mb_convert_encoding(explode($pattern, $text), "HTML-ENTITIES", "UTF-8");

        return $all ? collect($content) : collect($content)->only(1)->first();
    }

    /**
     * Organiza as informações do time na tabela em forma de array,
     *
     * @param String $info_time
     *
     * @return Array
     */
    public function time_static(string $info_time) : array
    {
        $dados_time    = explode('"', $info_time);
        $array_replace = [">", "<", "/", "tr", "td", "class", "=", " ", "title", '"'];

        $data = [
            "id_time"        => $dados_time[1],
            "posicao"        => (int) str_replace($array_replace, "", $dados_time[8]),
            "icone_width"    => (int) $dados_time[15],
            "icone_height"   => (int) $dados_time[17],
            "icone_url"      => trim($dados_time[23]),
            "nome_time"      => trim($dados_time[29]),
            "pontos"         => (int) str_replace($array_replace, "", $dados_time[38]),
            "jogos"          => (int) str_replace($array_replace, "", $dados_time[40]),
            "vitorias"       => (int) str_replace($array_replace, "", $dados_time[42]),
            "empates"        => (int) str_replace($array_replace, "", $dados_time[44]),
            "derrotas"       => (int) str_replace($array_replace, "", $dados_time[46]),
            "gols_pro"       => (int) str_replace($array_replace, "", $dados_time[48]),
            "gols_contra"    => (int) str_replace($array_replace, "", $dados_time[50]),
            "saldo_de_gols"  => (int) str_replace($array_replace, "", $dados_time[52]),
            "aproveitamento" => (int) str_replace($array_replace, "", $dados_time[54])
        ];

        return array_filter(
            array_map("html_entity_decode", $data)
        );
    }

    /**
     * Organiza as informações dos jogos em forma de array.
     *
     * @param String $info_jogo
     * @param Int $rodada
     *
     * @return Array
     */
    public function jogo_static(string $info_jogo, int $rodada) : array
    {
        $dados_jogo     = explode('"', $info_jogo);
        $array_replace  = ["</a>", "</strong>", ">", "<", "/", "tr", "td", "class", "=", "span", "\n", "div", " ", "title", '"'];
        $replace_array  = ["</strong>", "<", "span", ">", "class", "="];
        $jogo_concluido = boolval((count($dados_jogo) > 80));

        $data = [
            "rodada"                     => (int) $rodada,
            "times_partida"              => trim($dados_jogo[3]),
            "data_do_jogo"               => trim($dados_jogo[7]),
            "local_jogo"                 => trim($dados_jogo[15]),
            "time_casa"                  => trim($dados_jogo[29]),
            "time_casa_logo_width"       => (int) trim($dados_jogo[31]),
            "time_casa_logo_height"      => (int) trim($dados_jogo[33]),
            "time_casa_logo_alt"         => trim($dados_jogo[37]),
            "time_casa_logo_url"         => trim($dados_jogo[39]),
            "time_casa_abreviacao"       => trim(str_replace($array_replace, "", $dados_jogo[42])),
            "time_casa_gols"             => $jogo_concluido ? (int) trim(str_replace($array_replace, "", $dados_jogo[46])) : null,
            "time_visitante_gols"        => $jogo_concluido ? (int) trim(str_replace($array_replace, "", $dados_jogo[50])) : null,
            "data_e_horario_do_jogo"     => trim(str_replace($replace_array, "", $dados_jogo[54])),
            "referencia_do_jogo"         => $jogo_concluido ? trim(collect(explode("/ao-vivo/", $dados_jogo[57]))->last()) : null,
            "time_visitante"             => $jogo_concluido ? trim($dados_jogo[67]) : trim($dados_jogo[63]),
            "time_visitante_logo_width"  => $jogo_concluido ? (int) trim($dados_jogo[69]) : trim($dados_jogo[65]),
            "time_visitante_logo_height" => $jogo_concluido ? (int) trim($dados_jogo[71]) : trim($dados_jogo[67]),
            "time_visitante_logo_alt"    => $jogo_concluido ? trim($dados_jogo[75]) : trim($dados_jogo[71]),
            "time_visitante_logo_url"    => $jogo_concluido ? trim($dados_jogo[77]) : trim($dados_jogo[73]),
            "time_visitante_abreviacao"  => $jogo_concluido ? trim(str_replace($array_replace, "", $dados_jogo[80])) : trim(str_replace($array_replace, "", $dados_jogo[76]))
        ];

        return array_filter(
            array_map("html_entity_decode", $data)
        );
    }
}
