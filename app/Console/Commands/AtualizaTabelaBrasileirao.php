<?php

namespace App\Console\Commands;

use App\Models\Brasileirao;
use App\Utils\TabelaBrasileirao;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AtualizaTabelaBrasileirao extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'atualiza:tabela-brasileirao';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para atualizar a tabela do brasileirão em nossa base de dados.';

    /** @var TabelaBrasileirao $tabelaBrasileiraoUtils */
    protected $tabelaBrasileiraoUtils;

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

        $this->tabelaBrasileiraoUtils = new TabelaBrasileirao;
        $this->dataProcessamento      = Carbon::now()->format("d-m-Y");
        $this->urlPaginaDados         = env("URL_SITE_BRASILEIRAO");
        $this->pattern                = '/\<!-- MOD 603 - STANDINGS ROUND ROBIN -->(.*?)<!-- END OF MOD 603 - STANDINGS ROUND ROBIN -->/s';
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

            $dados = $this->tabelaBrasileiraoUtils->jsonTabela($this->urlPaginaDados, $this->pattern);

            $dados = collect([
                "rodada"    => collect($dados->sortByDesc("jogos")->first())->get("jogos"),
                "temporada" => Carbon::now()->format("Y"),
                "tabela"    => $dados->toJson()
            ]);

            $rodada = Brasileirao::query()
                ->where("temporada", $dados->get("temporada"))
                ->where("rodada", $dados->get("rodada"));

            $rodada->count() ? $rodada->update($dados->only("tabela")->toArray()) : Brasileirao::create($dados->all());

            $this->info("{$this->signature} | TABELA DO BRASILEIRÃO ATUALIZADO COM SUCESSO.");

            $this->info("FINALIZANDO PROCESSAMENTO | {$this->signature} | {$this->dataProcessamento}");
        } catch (\Exception $e) {
            $this->error("ERRO DE PROCESSAMENTO | {$this->signature} | ERRO: {$e->getMessage()}");
        }
    }
}
