<?php

namespace App\Exceptions;

use Exception;

class ValidacaoException extends Exception
{
    /**
     * @param string $mensagem
     * @param int $codigo
     * @param Exception|null $anterior
     */
    public function __construct(string $mensagem, int $codigo = 0, Exception $anterior = null) {
        parent::__construct($mensagem, $codigo, $anterior);
    }

   /**
    * @return string
    */
    public function __toString() {
        return __CLASS__ . ": [{$this->codigo}]: {$this->mensagem}\n";
    }
}
