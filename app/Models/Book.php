<?php

namespace App\Models;

use App\Services\PlaceholderCoverGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'author',
        'price',
        'stock',
        'description',
        'cover_image',
        'featured',
        'category_id',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'featured' => 'boolean',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function inStock(): bool
    {
        return $this->stock > 0;
    }

    public function averageRating(): float
    {
        return round((float) $this->reviews()->avg('rating'), 1);
    }

    public function getCoverUrlAttribute(): string
    {
        if (! $this->cover_image) {
            $path = app(PlaceholderCoverGenerator::class)->generate($this->title);

            return Storage::url($path);
        }

        if (str_starts_with($this->cover_image, 'http')) {
            return $this->cover_image;
        }

        return Storage::url($this->cover_image);
    }
}
