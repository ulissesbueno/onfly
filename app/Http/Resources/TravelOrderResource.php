<?php

namespace App\Http\Resources;

use App\Domain\Entities\TravelOrder;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TravelOrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if ($this->resource instanceof TravelOrder) {
            return $this->map($this->resource);
        }

        return collect($this->resource)->map(function ($order) {
            return $this->map($order);
        })->all();
    }

    private function map(TravelOrder $data): array
    {
        return [
            'id' => $data->id,
            'requester_name' => $data->requesterName,
            'destination' => $data->destination,
            'departure_date' => $data->departureDate->format('Y-m-d H:i'),
            'return_date' => $data->returnDate->format('Y-m-d H:i'),
            'status' => $data->status,
            'user' => [
                'id' => $data->user->id,
                'name' => $data->user->name,
                'email' => $data->user->email,
            ],
        ];
    }
}
