<?php

namespace App\Services;

use App\Exceptions\ValidacaoException;
use App\Helpers\ReturnResponse;
use App\Repositories\Contracts\BrasileiraoRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BrasileiraoService
{
    /** @var BrasileiraoRepositoryInterface $brasileiraoRepository */
    protected $brasileiraoRepository;

    /**
     * Define o Repository deste Service.
     *
     * @param BrasileiraoRepositoryInterface $brasileiraoRepository
     */
    public function __construct(BrasileiraoRepositoryInterface $brasileiraoRepository)
    {
        $this->brasileiraoRepository = $brasileiraoRepository;
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

}
