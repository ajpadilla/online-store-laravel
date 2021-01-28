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

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function paymentAttempts()
    {
        return $this->hasMany(PaymentAttempt::class);
    }

    public function getFirstPaymentAttempt()
    {
        return $this->paymentAttempts()->count() ? $this->paymentAttempts()->first() : null;
    }

    public function getProductName()
    {
        return $this->product ?  $this->product->name : null;
    }

    public function getTotalProducts()
    {
        return $this->product()->count();
    }
}
