<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outlet extends Model
{
    use HasFactory;

    protected $table = 'outlets';

    protected $primaryKey = 'OutletID';

    protected $fillable = [
        'branch_id',
        'UserID',
        'Name',
        'Address',
        'ContactNumber',
        'Email',
        'Latitude',
        'Longitude',
        'Status',
    ];

    
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

   
    public function user()
    {
        return $this->belongsTo(User::class, 'UserID');
    }

   
    public function branchTokens()
    {
        return $this->hasMany(OutletToken::class, 'OutletID');
    }
}
