<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetails extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id',
        'primary_phone', 'alternate_phone', 'customer_number', 'shipping_user_name', 'shipping_last_name',
        'shipping_address', 'shipping_city', 'shipping_state', 'shipping_zip', 'shipping_country',
        'shipping_phone', 'billing_user_name', 'billing_last_name', 'billing_address', 'billing_city',
        'billing_state', 'billing_zip', 'billing_country', 'billing_phone'
    ];
}
