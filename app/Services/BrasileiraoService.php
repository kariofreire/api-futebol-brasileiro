<?php

namespace App\Services;

use App\Helpers\ReturnResponse;
use App\Repositories\Contracts\BrasileiraoRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BrasileiraoService
{
    /** @var BrasileiraoRepositoryInterface $brasileiraoRepository */
    protected $brasileiraoRepository;

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

}
