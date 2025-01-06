<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Token extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'tokens';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'status',
        'isActive',
        'description',
        'user_id',
    ];

    /**
     * The possible statuses for a token.
     */
    public const STATUS_PENDING = 'pending';
    public const STATUS_SCHEDULED = 'scheduled';
    public const STATUS_DELIVERED = 'delivered';
    public const STATUS_CANCELED = 'canceled';
    public const STATUS_REASIGNED = 'reasigned';
    public const STATUS_CYLINDER_RECEIVED = 'cylinder_received';
    public const STATUS_PAYMENT_COMPLETE = 'payment_complete';

    /**
     * Relationships
     */

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with TokenHistory
    public function histories()
    {
        return $this->hasMany(TokenHistory::class, 'token_id');
    }

    
   
}
