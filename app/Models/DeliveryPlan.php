<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryPlan extends Model
{
    use HasFactory;

    protected $table = 'delivery_plans';

    protected $fillable = [
        'DeliveryDate',
        'QuantityPlanned',
        'QuantityReceived',
        'Status',
        'Notes',
        'isActive',
        'outlet_id',
        'cylinder_type_id',
    ];

    public function outlet()
    {
        return $this->belongsTo(Outlet::class, 'outlet_id');
    }

    // Relationship with GasCylinder
    public function gasCylinder()
    {
        return $this->belongsTo(GasCylinder::class, 'cylinder_type_id');
    }
}
