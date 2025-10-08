<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Disable updated_at timestamp
    const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'total_amount',
        'status',
        'payment_method',
        'order_code',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'created_at' => 'datetime',
    ];

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with Order Items
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Relationship with Payment
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
