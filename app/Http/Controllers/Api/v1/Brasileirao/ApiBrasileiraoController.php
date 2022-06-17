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
}
