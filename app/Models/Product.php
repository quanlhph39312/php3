<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category_id',
        'image_thumbnail',
        'price_regular',
        'price_sale',
        'view',
        'content',
        'description',
        'material',
        'is_show_home',
        'is_new',
        'is_trending',
        'is_sale',
        'status',
    ];
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
