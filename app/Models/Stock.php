<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;
    protected $table = 'stock';

    protected $fillable = [
        'outlet_id',
        'gas_cylinder_id',
        'quantity',
        'isActive',
    ];

    // Define relationship with Branch
    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }

    // Define relationship with GasCylinder
    public function gasCylinder()
    {
        return $this->belongsTo(GasCylinder::class);
    }
}
