<?php

namespace App\Console\Commands;

use App\Models\BrasileiraoJogos;
use App\Models\BrasileiraoJogosDetalhes;
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

    /** @var String $urlJsonDados */
    protected $urlJsonDados;

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
        $this->urlJsonDados           = env("URL_JSON_ESTATISTICA_JOGO");
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

            BrasileiraoJogos::orderBy("rodada")->get()->each(function ($rodada) {
                collect(json_decode($rodada->jogos))->each(function ($jogo) {
                    $referencia = $jogo->referencia_do_jogo;

                    if (BrasileiraoJogosDetalhes::where("codigo_referencia_jogo", $referencia)->count()) return true;

                    if (empty($referencia)) return true;

                    $dados = $this->estatisticasJogosBrasileiraoUtils->jsonEstatisticas("{$this->urlPaginaDados}/{$referencia}", $this->pattern, $this->urlJsonDados);
                    $dados = $dados->merge(["codigo_referencia_jogo" => $referencia]);

                    BrasileiraoJogosDetalhes::create($dados->toArray());

                    $this->info("{$this->signature} | INFORMAÇÕES DO JOGO {$jogo->times_partida} SALVO EM NOSSA BASE DE DADOS.");
                });
            });

            $this->info("FINALIZANDO PROCESSAMENTO | {$this->signature} | {$this->dataProcessamento}");
        } catch (\Exception $e) {
            $this->error("ERRO DE PROCESSAMENTO | {$this->signature} | ERRO: {$e->getMessage()}");
        }
    }
}
