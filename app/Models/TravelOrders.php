<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TravelOrders extends Model
{
    protected $table = 'travel_orders';
    protected $fillable = [
        'requester_name',
        'destination',
        'departure_date',
        'return_date',
        'status',
        'user_id',
    ];
}
