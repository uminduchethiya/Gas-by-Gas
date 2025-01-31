<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GasCylinder extends Model
{
    use HasFactory;

    protected $table = 'gas_cylinders';

    protected $fillable = [
        'name',
        'description',
        'size',
        'user_price',

        'organization_price',
        'isActive'
    ];
    public function outletTokens()
    {
        return $this->hasMany(OutletToken::class, 'gas_cylinder_id');
    }

    public function tokens()
    {
        return $this->hasMany(Token::class, 'cylinder_type_id');
    }
}
