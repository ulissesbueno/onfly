<?php

namespace App\Listeners;

use App\Domain\Entities\TravelOrder;
use App\Domain\Enums\TravelOrderStatus;
use App\Events\TravelOrderStatusChange;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class SendNoticationTravelOrder //implements ShouldQueue
{
    //use Queueable;
    /**
     * Handle the event.
     */
    public function handle(TravelOrderStatusChange $event): void
    {
        $travelOrder = $event->travelOrder;
        $this->sendNotification($travelOrder);
    }

    private function sendNotification(TravelOrder $travelOrder): void
    {
        $message = $this->getMessageByStatus($travelOrder->getStatus());

        // Lógica para enviar a notificação (exemplo: email, SMS, etc.)

        Log::info("Notificação enviada para o usuário {$travelOrder->user->name}: $message");
    }

    private function getMessageByStatus(string $status): string
    {
        return match ($status) {
            TravelOrderStatus::APPROVED => "Seu pedido foi aprovado.",
            TravelOrderStatus::CANCELLED => "Seu pedido foi cancelado.",
            default => throw new \InvalidArgumentException("Status de notificação inválido."),
        };
    }
}
