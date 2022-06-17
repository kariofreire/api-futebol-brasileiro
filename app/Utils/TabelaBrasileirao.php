<?php

namespace App\Utils;

class TabelaBrasileirao extends UtilsAbstract
{
    /**
     * Retorna o JSON da tabela do Brasileirão de acordo com a página WEB solicitada.
     *
     * @param String $url
     * @param String $pattern
     *
     * @return \Illuminate\Support\Collection
     */
    public function jsonTabela(string $url, string $pattern)
    {
        [$dados_completos, $dados_otmizados] = $this->file_get_contents_utf8($url, $pattern);

        $dados_tabela = $this->get_string_to_pattern(collect($dados_otmizados)->first(), '/\<tbody>(.*?)<\/tbody>/s');

        $tabela = collect([]);

        collect(explode("data-idteam", $dados_tabela))->each(function($dados_time, $key) use (&$tabela) {
            if (strlen($dados_time) < 10) return true;

            $tabela = $tabela->merge([$this->time_static($dados_time)]);
        });

        return collect($tabela);
    }
}
