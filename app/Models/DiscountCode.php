<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiscountCode extends Model
{
    protected $fillable = [
        'code',
        'percentage',
        'is_active',
        'uses_limit',
        'uses_count',
    ];

    protected $casts = [
        'is_active'  => 'boolean',
        'percentage' => 'integer',
        'uses_limit' => 'integer',
        'uses_count' => 'integer',
    ];

    public function isValid(): bool
    {
        if (! $this->is_active) {
            return false;
        }
        if ($this->uses_limit !== null && $this->uses_count >= $this->uses_limit) {
            return false;
        }
        return true;
    }
}
