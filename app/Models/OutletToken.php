<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutletToken extends Model
{
    use HasFactory;

    protected $table = 'outlet_tokens';

    protected $fillable = [
        'outlet_id',
        'cylinder_type_id',
        'maxTokens',
        'currentTokens',
    ];

    
    public function outlet()
    {
        return $this->belongsTo(Outlet::class, 'outlet_id');
    }

   
    public function gasCylinder()
    {
        return $this->belongsTo(GasCylinder::class, 'cylinder_type_id');
    }
}
