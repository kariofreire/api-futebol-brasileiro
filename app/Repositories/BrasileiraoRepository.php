<?php

namespace App\Repositories;

use App\Models\Brasileirao;
use App\Repositories\Contracts\BrasileiraoRepositoryInterface;
use Illuminate\Http\Request;

class BrasileiraoRepository implements BrasileiraoRepositoryInterface
{
    /** @var Brasileirao $entity */
    protected $entity;

    /**
     * Define o Model utilizado neste repository.
     *
     * @param Brasileirao $brasileirao
     */
    public function __construct(Brasileirao $brasileirao)
    {
        $this->entity = $brasileirao;
    }

    /**
     * Recupera todas as informações da tabela do Brasileirão.
     *
     * @param Request $request
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAllBrasileirao(Request $request)
    {
        return $this->entity->orderByDesc("rodada")->paginate(1);
    }

    /**
     * Recupera um registro da tabela do Brasileirão pelo número de rodada.
     *
     * @param Int $rodada
     * @param String $temporada
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function tabelaPorRodada(int $rodada, string $temporada)
    {
        return $this->entity::query()
            ->where("rodada", (int) $rodada)
            ->where("temporada", $temporada)
            ->first();
    }

    /**
     * Recupera registro da tabela do Brasileirão pelo ID.
     *
     * @param Int $id
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getBrasileiraoById(int $id)
    {
        return $this->entity->find($id);
    }

    /**
     * Cria um registro da tabela do Brasileirão.
     *
     * @param Request $dados_brasileirao
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function createBrasileriao(Request $dados_brasileirao)
    {
        return $this->entity->create($dados_brasileirao);
    }

    /**
     * Atualiza tabela do Brasileirão.
     *
     * @param Int $id
     * @param Request $dados_brasileirao
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function updateBrasileirao(int $id, Request $dados_brasileirao)
    {
        return $this->entity->find($id)->update($dados_brasileirao->all());
    }

    /**
     * Deleta um registro da tabela do Brasileirão.
     *
     * @param Int $id
     *
     * @return Bool
     */
    public function destroyBrasileirao(int $id)
    {
        return $this->entity->find($id)->delete() ? true : false;
    }
}
