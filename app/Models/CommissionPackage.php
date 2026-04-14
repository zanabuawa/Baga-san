<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommissionPackage extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'features',
        'is_featured',
        'is_active',
        'sort_order',
        'category_id',

    ];

    protected $casts = [
        'price'       => 'decimal:2',
        'features'    => 'array',
        'is_featured' => 'boolean',
        'is_active'   => 'boolean',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'commission_package_product')
                    ->withPivot('quantity')
                    ->orderBy('sort_order');
    }
}