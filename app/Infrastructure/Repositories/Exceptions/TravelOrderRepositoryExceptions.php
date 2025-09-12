<?php

namespace App\Infrastructure\Repositories\Exceptions;

class TravelOrderRepositoryExceptions
{
    public static function orderNotFound(): \DomainException
    {
        return new \DomainException("Pedido não encontrado.", 404);
    }
}