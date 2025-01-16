<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutletToken extends Model
{
    use HasFactory;

    protected $table = 'outlet_tokens';

    protected $fillable = [
        'OutletID',
        'gas_cylinder_id',
        'maxTokens',
        'currentTokens',
        'token_amount',
    ];

    
    public function outlet()
    {
        return $this->belongsTo(Outlet::class, 'outlet_id');
    }

   
    public function gasCylinder()
    {
        return $this->belongsTo(GasCylinder::class, 'gas_cylinder_id');
    }
}
