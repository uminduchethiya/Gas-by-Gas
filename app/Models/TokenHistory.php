<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class TokenHistory extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

   
    protected $table = 'token_histories';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'token_id',
        'currentStatus',
        'updateStatus',
        'reason',
    ];

    /**
     * The possible statuses for token history.
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

    // Relationship with Token
    public function token()
    {
        return $this->belongsTo(Token::class, 'token_id');
    }

    
   
}
