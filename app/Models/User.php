<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Models\UserDetails;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'payment_term_description',
        'customer_id',
        'default_customer_id',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function isSuperAdmin()
    {
        return $this->hasRole('super-admin');
    }

    public function isAdmin()
    {
        return $this->hasRole('Admin');
    }

    /**
     * Determine if the user has an admin role.
     *
     * @return bool
     */
    public function getIsAdminAttribute()
    {
        $adminRoles = ['super-admin', 'Admin', 'Editor'];

        return $this->hasAnyRole($adminRoles);
    }


    public function getUserDetails()
    {
        return $this->hasOne(UserDetails::class)->withDefault();

    }
}
