<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slider extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'image_path',
        'title',
        'subtitle',
        'button_text',
        'button_url',
        'is_active',
        'display_order',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'display_order' => 'integer',
    ];

    /**
     * Scope to get only active slides.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->orderBy('display_order')
            ->orderBy('created_at', 'desc');
    }

    /**
     * Check if slide has a button.
     */
    public function hasButton(): bool
    {
        return !empty($this->button_text) && !empty($this->button_url);
    }
}
