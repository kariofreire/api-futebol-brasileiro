<?php

namespace App\Services;

use App\Exceptions\ValidacaoException;
use App\Helpers\ReturnResponse;
use App\Repositories\Contracts\BrasileiraoJogosRepositoryInterface;
use App\Repositories\Contracts\BrasileiraoRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BrasileiraoService
{
    /** @var BrasileiraoRepositoryInterface $brasileiraoRepository */
    protected $brasileiraoRepository;

    /** @var BrasileiraoJogosRepositoryInterface $brasileiraoJogosRepository */
    protected $brasileiraoJogosRepository;

    /** @var Carbon $temporada_atual */
    private $temporada_atual;

    /**
     * Define o Repository deste Service.
     *
     * @param BrasileiraoRepositoryInterface $brasileiraoRepository
     */
    public function __construct(
        BrasileiraoJogosRepositoryInterface $brasileiraoJogosRepository,
        BrasileiraoRepositoryInterface $brasileiraoRepository
    )
    {
        $this->brasileiraoJogosRepository = $brasileiraoJogosRepository;
        $this->brasileiraoRepository      = $brasileiraoRepository;
        $this->temporada_atual            = Carbon::now()->format("Y");
    }

    /**
     * Recupera todas as informações da tabela do Brasileirão.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function tabelaAtualizada(Request $request) : JsonResponse
    {
        try {
            $tabela_atualizada = $this->brasileiraoRepository->getAllBrasileirao($request);

            return ReturnResponse::success("Tabela do Campeonato Brasileiro retornada com sucesso.", $tabela_atualizada, $tabela_atualizada->total());
        } catch (\Throwable $th) {
            return ReturnResponse::error("Erro ao retornar a Tabela do Campeonato Brasileiro.", [$th->getMessage()]);
        }
    }

    /**
     * Recupera a tabela do Brasileirão por Rodadas.
     *
     * @param Int $rodada
     * @param String $temporada
     *
     * @return JsonResponse
     */
    public function tabelaPorRodada(int $rodada, string $temporada)
    {
        try {
            $tabela_por_rodada = $this->brasileiraoRepository->tabelaPorRodada($rodada, $temporada);

            if (empty($tabela_por_rodada)) throw new ValidacaoException("Nenhum registro encontrado.", 1);

            return ReturnResponse::success("Tabela do Campeonato Brasileiro retornada com sucesso.", $tabela_por_rodada);
        } catch (ValidacaoException $ve) {
            return ReturnResponse::warning($ve->getMessage());
        } catch (\Throwable $th) {
            return ReturnResponse::error("Erro ao retornar a Tabela do Campeonato Brasileiro.", [$th->getMessage()]);
        }
    }

    /**
     * Retorna os jogos da Rodada atual do Campeonato Brasileiro.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function jogosDaRodada(Request $request) : JsonResponse
    {
        try {
            $tabela_atualizada = $this->brasileiraoRepository->getAllBrasileirao($request);

            $jogos_da_rodada   = $this->brasileiraoJogosRepository->jogosDaRodada($tabela_atualizada->first()->rodada);

            if (empty($jogos_da_rodada)) throw new ValidacaoException("Nenhum registro encontrado.", 1);

            return ReturnResponse::success("Jogos da Rodada do Campeonato Brasileiro retornada com sucesso.", $jogos_da_rodada);
        } catch (ValidacaoException $ve) {
            return ReturnResponse::warning($ve->getMessage());
        } catch (\Throwable $th) {
            return ReturnResponse::error("Erro ao retornar os jogos da rodada do Campeonato Brasileiro.", [$th->getMessage()]);
        }
    }

    /**
     * Retorna detalhes dos jogos pro rodada do Campeonato Brasileiro.
     *
     * @param Int $rodada
     * @param String $temporada
     *
     * @return JsonResponse
     */
    public function jogosPorRodada(int $rodada, string $temporada) : JsonResponse
    {
        try {
            $jogos_por_rodada = $this->brasileiraoJogosRepository->jogosPorRodada($rodada, $temporada);

            if (empty($jogos_por_rodada)) throw new ValidacaoException("Nenhum registro encontrado.", 1);

            return ReturnResponse::success("Jogos do Campeonato Brasileiro retornada com sucesso.", $jogos_por_rodada);
        } catch (ValidacaoException $ve) {
            return ReturnResponse::warning($ve->getMessage());
        } catch (\Throwable $th) {
            return ReturnResponse::error("Erro ao retornar a Jogos do Campeonato Brasileiro.", [$th->getMessage()]);
        }
    }

    /**
     * Retorna jogos da temporada do campeonato brasileiro por time.
     *
     * @param String $nome_time
     *
     * @return JsonResponse
     */
    public function jogosPorTime(string $nome_time) : JsonResponse
    {
        try {
            $jogos_por_time = $this->brasileiraoJogosRepository->jogosPorTime(trim(ucfirst(strtolower($nome_time))), $this->temporada_atual);

            if (empty($jogos_por_time)) throw new ValidacaoException("Nenhum registro encontrado.", 1);

            return ReturnResponse::success("Jogos do Campeonato Brasileiro retornada com sucesso.", $jogos_por_time);
        } catch (ValidacaoException $ve) {
            return ReturnResponse::warning($ve->getMessage());
        } catch (\Throwable $th) {
            return ReturnResponse::error("Erro ao retornar a Jogos do Campeonato Brasileiro.", [$th->getMessage()]);
        }
    }
}
