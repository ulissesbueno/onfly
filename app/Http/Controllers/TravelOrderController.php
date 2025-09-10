<?php

namespace App\Http\Controllers;

use App\Application\UseCases\SaveTravelOrderUseCase;
use Illuminate\Http\Request;
use App\Http\Controllers\Exceptions\ValidationException;

class TravelOrderController extends Controller
{
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'requester_name' => 'required|string',
                'destination'     => 'required|string|max:255',
                'departure_date'  => 'required|date|after_or_equal:today',
                'return_date'     => 'required|date|after_or_equal:departure_date',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw new ValidationException($e->validator);
        }
        
        $order = app(SaveTravelOrderUseCase::class)->execute($data);

        return response()->json($order, 201);
    }
}
