<?php

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;

interface BrasileiraoRepositoryInterface
{
    /**
     * Recupera todas as informações da tabela do Brasileirão.
     *
     * @param Request $request
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAllBrasileirao(Request $request);

    /**
     * Recupera registro da tabela do Brasileirão pelo ID.
     *
     * @param Int $id
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getBrasileiraoById(int $id);

    /**
     * Cria um registro da tabela do Brasileirão.
     *
     * @param Request $dados_brasileirao
     *
     * @return Bool
     */
    public function createBrasileriao(Request $dados_brasileirao);

    /**
     * Atualiza tabela do Brasileirão.
     *
     * @param Int $id
     * @param Request $dados_brasileirao
     *
     * @return Bool
     */
    public function updateBrasileirao(int $id, Request $dados_brasileirao);

    /**
     * Deleta um registro da tabela do Brasileirão.
     *
     * @param Int $id
     *
     * @return Bool
     */
    public function destroyBrasileirao(int $id);
}
