<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderItem;
use App\Models\User;


class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_items',
        'purchase_order_no',
        'bp_number',
        'status',
        'total',
        'customer_number',
        'associate_customer_id',
        'customer_po_number'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customer()
    {
        return $this->belongsTo(AssociateCustomer::class,'associate_customer_id');
    }

    public function orderItem()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getOrderStatusAttribute()
    {
        switch ($this->status) {
            case '0':
                return 'Order In Process';
            case '1':
                return 'Open Order';
            case '2':
                return 'Open back Order';
            case '3':
                return 'Released Back Order';
            case '4':
                return 'In Warehouse';
            case '8':
                return 'To Invoice';
            case '9':
                return 'Complete';
            case 'F':
                return 'Forward Order';
            case '*':
                return 'Cancelled';
            case '/':
                return 'Cancelled';
            case 'S':
                return 'In Suspense';
            default:
                return 'Unknown Status';
        }
    }
}
