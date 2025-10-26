<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Testimonial extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'title',
        'image_path',
        'comment',
        'rating',
        'is_published',
        'display_order',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'rating' => 'integer',
        'is_published' => 'boolean',
        'display_order' => 'integer',
    ];

    /**
     * Scope to get only published testimonials.
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
            ->orderBy('display_order')
            ->orderBy('created_at', 'desc');
    }

    /**
     * Get star rating as HTML or array.
     */
    public function getStarsAttribute(): array
    {
        return array_fill(0, $this->rating, '★') + array_fill($this->rating, 5 - $this->rating, '☆');
    }
}
