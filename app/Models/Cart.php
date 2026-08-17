<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\CheckoutIntent;
use App\Models\CartItem;
use App\Models\User;


class Cart extends Model
{
    use HasFactory;

	 protected $fillable = [
        'user_id', 'total_items', 'purchase_order_no', 'checkout_intent'
    ];
	

	public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cartItem()
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * The dealer's order-or-quote choice for this cart.
     *
     * Deliberately resolved through the enum instead of an Eloquent cast: an
     * unrecognised column value degrades to null ("choose again at the cart")
     * rather than throwing while rendering a checkout screen.
     */
    public function checkoutIntent(): ?CheckoutIntent
    {
        return CheckoutIntent::fromNullable($this->checkout_intent);
    }

    /**
     * Removing the last line item leaves the cart row behind, so line items are
     * the only reliable "is this cart usable" signal.
     */
    public function hasItems(): bool
    {
        return $this->cartItem()->exists();
    }

}
