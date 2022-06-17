<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

abstract class ReturnResponse
{
    /**
     * Retorno para Sucesso.
     *
     * @param String $message
     * @param \Illuminate\Database\Eloquent\Collection|static[] $data
     * @param Int $count
     * @param Int $code
     *
     * @return JsonResponse
     */
    public static function success(string $message, $data = [], int $count = 0, int $code = Response::HTTP_OK) : JsonResponse
    {
        return response()->json([
            "code"    => $code,
            "message" => $message,
            "data"    => $data,
            "count"   => $count
        ], $code, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Retorno para Atenção.
     *
     * @param String $message
     * @param \Illuminate\Database\Eloquent\Collection|static[] $data
     * @param Int $count
     * @param Int $code
     *
     * @return JsonResponse
     */
    public static function warning(string $message, $data = [], int $count = 0, int $code = Response::HTTP_BAD_REQUEST) : JsonResponse
    {
        return response()->json([
            "code"    => $code,
            "message" => $message,
            "data"    => $data,
            "count"   => $count
        ], $code, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Retorno para Erro.
     *
     * @param String $message
     * @param \Illuminate\Database\Eloquent\Collection|static[] $data
     * @param Int $count
     * @param Int $code
     *
     * @return JsonResponse
     */
    public static function error(string $message, $data = [], int $count = 0, int $code = Response::HTTP_INTERNAL_SERVER_ERROR) : JsonResponse
    {
        return response()->json([
            "code"    => $code,
            "message" => $message,
            "data"    => $data,
            "count"   => $count
        ], $code, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }
}
