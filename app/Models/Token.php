<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    use HasFactory;

    protected $fillable = [
        'status', 'isActive','description', 'user_id', 'cylinder_type_id', 'outlet_id','quantity','expires_at','token_code','created_by','updated_by'
    ];

    public const STATUS_PENDING = 'pending';
    public const STATUS_SCHEDULED = 'scheduled';
    public const STATUS_DELIVERED = 'delivered';
    public const STATUS_CANCELED = 'canceled';
    public const STATUS_REASIGNED = 'reasigned';
    public const STATUS_CYLINDER_RECEIVED = 'cylinder_received';
    public const STATUS_PAYMENT_COMPLETE = 'payment_complete';

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Define the relationship with the GasCylinder model
    public function gasCylinder()
    {
        return $this->belongsTo(GasCylinder::class, 'cylinder_type_id');
    }

    // Define the relationship with the Branch model
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
