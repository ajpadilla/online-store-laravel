<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /** @var array  */
    protected $fillable = [
        'customer_name',
        'customer_email',
        'customer_mobile',
        'customer_document_number',
        'customer_document_type',
        'amount',
        'status',
        'user_id',
        'product_id'
    ];

}
