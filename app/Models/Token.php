<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    use HasFactory;

    protected $fillable = [
        'status', 'description', 'user_id', 'cylinder_type_id', 'branch_id'
    ];

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
