<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PortfolioItem extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image_path',
        'category',
        'category_id',
        'sort_order',
        'is_visible',
    ];

    protected $casts = [
        'is_visible' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
       public function portfolioCategory()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}