<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommissionReference extends Model
{
    //

    protected $fillable = [
        'commission_id',
        'image_path',
    ];
    
    public function references()
    {
        return $this->hasMany(CommissionReference::class);
    }
}
