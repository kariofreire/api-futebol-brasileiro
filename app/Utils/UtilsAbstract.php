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
     *
     * @return String
     */
    public function get_string_to_pattern(string $text, string $pattern)
    {
        preg_match_all($pattern, $text, $matches);

        [$dados_completos, $dados_otmizados] = mb_convert_encoding($matches, "HTML-ENTITIES", "UTF-8");

        return collect($dados_otmizados)->first();
    }

    /**
     * Organiza as informações do time na tabela em forma de array,
     *
     * @param String $info_time
     *
     * @return Array
     */
    public function time_static(string $info_time)
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

        return $data;
    }
}
