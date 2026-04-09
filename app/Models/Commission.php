<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CommissionReference;

class Commission extends Model
{
    protected $fillable = [
        'client_name',
        'client_email',
        'client_discord',
        'commission_type',
        'description',
        'status',
        'is_priority',
        'price',
        'notes',
    ];

    protected $casts = [
        'price'       => 'decimal:2',
        'is_priority' => 'boolean',
    ];

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending'     => 'Pendiente',
            'in_progress' => 'En progreso',
            'delivered'   => 'Entregado',
            'paid'        => 'Pagado',
            default       => 'Desconocido',
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending'     => 'yellow',
            'in_progress' => 'blue',
            'delivered'   => 'purple',
            'paid'        => 'green',
            default       => 'gray',
        };
    }
    public function references()
    {
        return $this->hasMany(CommissionReference::class);
    }
}