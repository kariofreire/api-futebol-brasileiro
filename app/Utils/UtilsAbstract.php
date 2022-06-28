<?php

namespace App\Utils;

use Carbon\Carbon;

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

        return array_map("html_entity_decode", $data);
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

        return array_map("html_entity_decode", $data);
    }

    /**
     * Organiza as informações simples da partida em forma de array.
     *
     * @param String $info_jogo
     *
     * @return Array
     */
    public function info_jogo_static(string $info_jogo) : array
    {
        $dados_info_jogo = explode('"', $info_jogo);
        $array_replace   = ["\n", "\t", "</span>", "<h4>", "</h4>", "</div>", "<div class=", "<span class=", ">"]; // [">", "<", "\t", "h4", "=", "class", "div", "span", "\n", '"'];

        [$nome_estadio, $data_hora_jogo] = explode("|", $dados_info_jogo[66]);

        $data_hora_jogo = trim(str_replace("h", ":", str_replace($array_replace, "", $data_hora_jogo))) . ':00';

        $data = [
            "nome_estadio"              => trim(str_replace($array_replace, "", $nome_estadio)),
            "data_hora_jogo"            => Carbon::createFromFormat("d/m/Y H:i:s", $data_hora_jogo)->format("Y-m-d H:i:s"),
            "time_casa"                 => trim(str_replace($array_replace, "", $dados_info_jogo[10])),
            "time_casa_gols"            => (int) trim(str_replace($array_replace, "", $dados_info_jogo[34])),
            "time_visitante"            => trim(str_replace($array_replace, "", $dados_info_jogo[54])),
            "time_visitante_gols"       => (int) trim(str_replace($array_replace, "", $dados_info_jogo[40]))
        ];

        return array_map("html_entity_decode", $data);
    }

    /**
     * Organiza as informações de cartões por tempo de jogo em forma de array.
     *
     * @param String $info_cartoes
     * @param String $time_casa
     * @param String $time_visitante
     *
     * @return Array
     */
    public function info_cartoes_static(string $info_cartoes, string $time_casa, string $time_visitante) : array
    {
        $time_casa_cartoes_amarelos       = 0;
        $time_casa_cartoes_vermelhos      = 0;
        $time_visitante_cartoes_amarelos  = 0;
        $time_visitante_cartoes_vermelhos = 0;

        $dados_info_cartoes = explode("\n", $info_cartoes);
        $dados_info_cartoes = collect(array_filter(array_map("html_entity_decode", $dados_info_cartoes)));

        $dados_info_cartoes->each(function ($dados) use ($time_casa, $time_visitante, &$time_casa_cartoes_amarelos, &$time_visitante_cartoes_amarelos, &$time_casa_cartoes_vermelhos, &$time_visitante_cartoes_vermelhos) {
            $dados = str_replace(['"', '>'], "", collect(explode('title="', $dados))->last());

            if (empty($dados)) return true;

            switch (true) {
                case str_contains($dados, "cartão amarelo"):
                    if (str_contains($dados, $time_casa)) $time_casa_cartoes_amarelos = $time_casa_cartoes_amarelos + 1;
                    if (str_contains($dados, $time_visitante)) $time_visitante_cartoes_amarelos = $time_visitante_cartoes_amarelos + 1;
                    break;

                case str_contains($dados, "cartão vermelho"):
                    if (str_contains($dados, $time_casa)) $time_casa_cartoes_vermelhos = $time_casa_cartoes_vermelhos + 1;
                    if (str_contains($dados, $time_visitante)) $time_visitante_cartoes_vermelhos = $time_visitante_cartoes_vermelhos + 1;
                    break;
            }
        });

        $data = [
            "time_casa_cartoes_amarelos"       => (int) $time_casa_cartoes_amarelos,
            "time_casa_cartoes_vermelhos"      => (int) $time_casa_cartoes_vermelhos,
            "time_visitante_cartoes_amarelos"  => (int) $time_visitante_cartoes_amarelos,
            "time_visitante_cartoes_vermelhos" => (int) $time_visitante_cartoes_vermelhos,
        ];

        return $data;
    }

    /**
     * Organiza as informações de escalações do times em forma de array.
     *
     * @param String $escalacoes_info
     *
     * @return Array
     */
    public function info_ecalacoes_static(string $escalacoes_info) : array
    {
        $dados_escalacoes_info = collect(array_filter(explode("\n", $escalacoes_info)));

        $data_escalacao = [];

        $categoria = "time_casa_titular";

        $dados_escalacoes_info->each(function ($data, $key) use ($dados_escalacoes_info, &$categoria, &$data_escalacao) {
            switch (true) {
                case str_contains($data, "live__content__lineup__team-player__number"):
                    $numero_jogador  = (int) strip_tags(collect(explode('">', $dados_escalacoes_info->get($key)))->last());
                    [$posicao_jogador, $nome_jogador] = explode('" >', strip_tags(collect(explode('title="', $dados_escalacoes_info->get($key + 1)))->last()));

                    $data_escalacao[$categoria][] = [
                        "numero_jogador"  => $numero_jogador,
                        "posicao_jogador" => $posicao_jogador,
                        "nome_jogador"    => $nome_jogador
                    ];

                    break;

                default:
                    switch (true) {
                        case str_contains($data, "live__content__lineup__col live__content__lineup__col-right"):
                            $categoria = "time_visitante_titular";
                            break;

                        case str_contains($data, "Banco"):
                            $categoria = in_array($categoria, ["time_casa_titular"]) ? "time_casa_banco" : "time_visitante_banco";
                            break;
                    }
                    break;
            }
        });

        $data = [
            "time_casa_escalacao"      => collect($data_escalacao)->only(["time_casa_titular", "time_casa_banco"])->toJson(),
            "time_visitante_escalacao" => collect($data_escalacao)->only(["time_visitante_titular", "time_visitante_banco"])->toJson()
        ];

        return $data;
    }

    /**
     * Organiza as estatisticas do jogo em forma de array.
     *
     * @param String $data_estatistica
     * @param String $time_casa
     *
     * @return Array
     */
    public function estatisticas_static(string $data_estatistica, string $time_casa) : array
    {
        $dados = json_decode($data_estatistica);

        $estatisticas = $dados->root->result->events[0];

        $time_a_estatistica = self::organizaEstatisticas($estatisticas->statistics[0]);
        $time_b_estatistica = self::organizaEstatisticas($estatisticas->statistics[1]);

        $estatisticas = [
            "time_casa"      => in_array($time_casa, [$time_a_estatistica["nome_time"]]) ? $time_a_estatistica : $time_b_estatistica,
            "time_visitante" => !in_array($time_casa, [$time_a_estatistica["nome_time"]]) ? $time_a_estatistica : $time_b_estatistica
        ];

        $data = [
            "estatisticas"              => collect($estatisticas)->toJson(),
            "time_casa_posse_bola"      => $estatisticas["time_casa"]["percentual_posse_de_bola"],
            "time_visitante_posse_bola" => $estatisticas["time_visitante"]["percentual_posse_de_bola"]
        ];

        return $data;
    }

    /**
     * Organiza os dados de estatisticas.
     *
     * @return Array
     */
    private static function organizaEstatisticas($estatistica_time, int $numero = 0) : array
    {
        $dados = [];

        $dados["nome_time"]  = $estatistica_time->name_team;
        $dados["sigla_time"] = $estatistica_time->acronym;

        foreach ($estatistica_time->athletes[$numero]->criterias as $key => $criteria) {
            if ($key > 25 || str_contains($criteria->label, "accurate")) continue;

            $dados[str_replace("ç", "c", self::tirarAcentos(str_replace(" ", "_", strtolower($criteria->label))))] = $criteria->amount;
        }

        return $dados;
    }

    /**
     * Remove acenturação de string.
     *
     * @param String $string
     *
     * @return String
     */
    private static function tirarAcentos($string)
    {
        return preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$string);
    }
}
