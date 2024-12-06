<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class AssociateCustomer extends Model
{
    use HasFactory, HasRoles;

    protected $fillable = [
        'user_id',
        'customer_id',
        'name',
        'first_name',
        'last_name',
        'primary_phone',
        'alternate_phone',
        'account_id',
        'telephone',
        'contact',
        'last_login_date',
        'shipping_code',
        'company_name',
        'tax_status',
        'tax_exemption_no',
        'class_id',
        'user_field',
        'salesperson',
        'invoice_discount_code',
        'branch',
        'state_code',
        'default_email',
        'unit',
        'street_address',
        'city',
        'state',
        'country',
        'zip_code'
    ];
}
