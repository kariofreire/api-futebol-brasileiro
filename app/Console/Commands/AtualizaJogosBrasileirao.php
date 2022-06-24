<?php

namespace App\Console\Commands;

use App\Models\BrasileiraoJogos;
use App\Utils\JogosBrasileirao;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AtualizaJogosBrasileirao extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'atualiza:jogos-brasileirao';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para atualizar os jogos do brasileirão em nossa base de dados.';

    /** @var JogosBrasileirao $jogosBrasileiraoUtils */
    protected $jogosBrasileiraoUtils;

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

        $this->jogosBrasileiraoUtils = new JogosBrasileirao;
        $this->dataProcessamento      = Carbon::now()->format("d-m-Y");
        $this->urlPaginaDados         = env("URL_JOGOS_BRASILEIRAO");
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

            $this->jogosBrasileiraoUtils->jsonJogos($this->urlPaginaDados, $this->pattern)->each(function($rodada) {
                $rodada_dados = collect($rodada);

                $dados_banco = collect([
                    "rodada"    => $rodada_dados->get("rodada"),
                    "temporada" => Carbon::now()->format("Y"),
                    "jogos"     => $rodada_dados->get("partidas")->toJson()
                ])->toArray();

                $rodada_banco = BrasileiraoJogos::query()
                    ->where("temporada", Carbon::now()->format("Y"))
                    ->where("rodada", $rodada_dados->get("rodada"));

                $acao = $rodada_banco->count() ? 'ATUALIZADA' : 'CRIADA';

                $rodada_banco->count() ? $rodada_banco->update($dados_banco) : BrasileiraoJogos::create($dados_banco);

                $this->info("{$this->signature} | RODADA {$rodada_dados->get('rodada')} {$acao} COM SUCESSO");
            });

            $this->info("FINALIZANDO PROCESSAMENTO | {$this->signature} | {$this->dataProcessamento}");
        } catch (\Exception $e) {
            $this->error("ERRO DE PROCESSAMENTO | {$this->signature} | ERRO: {$e->getMessage()}");
        }
    }
}
