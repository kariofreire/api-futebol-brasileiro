<?php

namespace App\Console\Commands;

use App\Utils\EstatisticasJogosBrasileirao;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SalvaDetalhesJogosBrasileirao extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'salva-detalhes:jogos-brasileirao';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Salva no banco de dados detalhes dos jogos do campeonato brasileiro.';

    /** @var EstatisticasJogosBrasileirao $estatisticasJogosBrasileiraoUtils */
    protected $estatisticasJogosBrasileiraoUtils;

    /** @var Carbon $dataProcessamento */
    protected $dataProcessamento;

    /** @var String $urlPaginaDados */
    protected $urlPaginaDados;

    /** @var String $pattern */
    protected $pattern;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->estatisticasJogosBrasileiraoUtils = new EstatisticasJogosBrasileirao;
        $this->dataProcessamento      = Carbon::now()->format("d-m-Y");
        $this->urlPaginaDados         = env("URL_DETALHES_JOGOS_BRASILEIRAO");
        $this->pattern                = '/\<div class\=\"live__wrapper\">(.*?)<!-- INCLUDER -->/s';
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $this->info("INICIANDO PROCESSAMENTO | {$this->signature} | {$this->dataProcessamento}");

            $referencia = 'internacional-x-coritiba/72538';

            $dados = $this->estatisticasJogosBrasileiraoUtils->jsonEstatisticas($this->urlPaginaDados . '/' . $referencia, $this->pattern);
            $dados = $dados->merge(["codigo_referencia_jogo" => $referencia]);

            # FALTA INFORMAÇÕES
            /**
             * estatisticas
             * time_casa_posse_bola
             * time_visitante_posse_bola
             */

            dd($dados);

            $this->info("FINALIZANDO PROCESSAMENTO | {$this->signature} | {$this->dataProcessamento}");
        } catch (\Exception $e) {
            $this->error("ERRO DE PROCESSAMENTO | {$this->signature} | ERRO: {$e->getMessage()}");
        }
    }
}
