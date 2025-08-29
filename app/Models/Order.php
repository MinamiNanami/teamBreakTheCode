<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_name',
        'table_number',
        'order_method',
        'payment_method',
        'total_price',
        'cart',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
