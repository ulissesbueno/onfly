<?php

namespace App\Application\UseCases\Exceptions;

class TravelOrderExceptions
{
    public static function orderNotFound(): \DomainException
    {
        return new \DomainException("Pedido não encontrado.", 404);
    }

    public static function userCannotChangeOwnRequest(): \DomainException
    {
        return new \DomainException("Um usuário não pode aprovar ou cancelar seu próprio pedido.", 403);
    }

    public static function onlyPendingOrdersCanBeUpdated(): \DomainException
    {
        return new \DomainException("Apenas pedidos com status 'Pendente' podem ser atualizados.", 403);
    }
}