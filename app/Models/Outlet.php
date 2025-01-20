<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outlet extends Model
{
    use HasFactory;

    protected $table = 'outlets';

    protected $fillable = [
        'branch_id',
        'user_id', 
        'name',
        'address',
        'ContactNumber',
        'email',
        'latitude',
        'longitude',
        'isActive',
    ];

    
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

  
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); 
    }

   
    public function outletTokens()
    {
        return $this->hasMany(OutletToken::class, 'outlet_id'); 
    }
}
