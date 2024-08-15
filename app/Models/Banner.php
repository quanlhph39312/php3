<?php

namespace App\Models;

use App\Casts\ConvertDateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'link',
        'position',
        'description',
        'image',
        'start_date',
        'end_date',
        'priority',
        'status',
    ];

    protected $casts = [
        'start_date' => ConvertDateTime::class,
        'end_date' => ConvertDateTime::class,
        'created_at' => ConvertDateTime::class,
        'updated_at' => ConvertDateTime::class,
    ];
}
