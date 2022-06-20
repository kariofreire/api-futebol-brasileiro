<?php

namespace App\Http\Controllers\Api\v1\Brasileirao;

use App\Http\Controllers\Controller;
use App\Services\BrasileiraoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiBrasileiraoController extends Controller
{
    /** @var BrasileiraoService $brasileiraoService */
    protected $brasileiraoService;

    /**
     * Define o service deste Controller.
     *
     * @param BrasileiraoService $brasileiraoService
     */
    public function __construct(BrasileiraoService $brasileiraoService)
    {
        $this->brasileiraoService = $brasileiraoService;
    }

    /**
     * Retorna a tabela do Campeonato Brasileiro.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function tabela(Request $request) : JsonResponse
    {
        return $this->brasileiraoService->tabelaAtualizada($request);
    }

    /**
     * Retorna a tabela do Campeonato Brasileiro pelo número da Rodada.
     *
     * @param Int $rodada
     * @param String $temporada
     *
     * @return JsonResponse
     */
    public function tabelaPorRodada(int $rodada, string $temporada) : JsonResponse
    {
        return $this->brasileiraoService->tabelaPorRodada($rodada, $temporada);
    }
}
