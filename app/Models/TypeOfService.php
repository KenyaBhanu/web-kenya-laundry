<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TypeOfService extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'service_name',
        'price',
        'description',
    ];

    public function orderDetail()
    {
        return $this->hasMany(TransOrderDetail::class, 'id_service');
    }
}