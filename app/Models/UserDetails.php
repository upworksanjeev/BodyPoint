<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class UserDetails extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'profile_img',
        'primary_phone',
        'alternate_phone',
        'customer_number',
        'shipping_user_name',
        'shipping_last_name',
        'shipping_address',
        'shipping_city',
        'shipping_state',
        'shipping_zip',
        'shipping_country',
        'shipping_phone',
        'billing_user_name',
        'billing_last_name',
        'billing_address',
        'billing_city',
        'billing_state',
        'billing_zip',
        'billing_country',
        'billing_phone',
        'tax_status',
        'tax_exemption_no',
        'credit_limit',
        'class_id',
        'invoice_term_code',
        'user_field',
        'salesperson',
        'invoice_discount_code',
        'branch',
        'line_discount_code',
        'state_code',
        'default_email'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
