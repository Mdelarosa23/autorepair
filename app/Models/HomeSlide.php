<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeSlide extends Model
{
    use HasFactory;
    use HasPublicItems;

    protected $fillable = [
        'title',
        'highlight_text',
        'hook_message',
        'hook_highlight_text',
        'description',
        'primary_label',
        'primary_url',
        'secondary_label',
        'secondary_url',
        'background_image_path',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return ['is_active' => 'boolean', 'sort_order' => 'integer'];
    }
}
