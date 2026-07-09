<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransOrder extends Model
{
    use SoftDeletes;

    // order_status values (also used as the pickup status)
    const STATUS_PENDING = 0;
    const STATUS_PICKED_UP = 1;

    protected $fillable = [
        'id_customer',
        'order_code',
        'order_date',
        'order_end_date',
        'order_status',
        'order_pay',
        'order_change',
        'total'
    ];

    protected $casts = [
        'order_date' => 'datetime',
        'order_end_date' => 'datetime',
    ];

    // ini yang one to many, pake hasMany
    public function orderDetail()
    {
        return $this->hasMany(TransOrderDetail::class, 'id_order');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer');
    }

    public function laundryPickup()
    {
        return $this->hasOne(TransLaundryPickup::class, 'id_order');
    }
}
