<?php

namespace App\Models;

use App\Casts\ConvertDateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'image',
        'status',
    ];
    protected $casts = [
        'created_at' => ConvertDateTime::class,
        'updated_at' => ConvertDateTime::class,
    ];
}
