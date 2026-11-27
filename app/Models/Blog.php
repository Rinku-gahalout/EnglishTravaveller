<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Blog extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'language',
        'category_id',
        'subcategory_id',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'blog_heading',
        'blog_description',
        'blog_url',
        'image',
        'alt_tag',
        'is_draft',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    /**
     * Keep published_at in sync with the draft/published status.
     */
    protected static function booted(): void
    {
        static::saving(function (Blog $blog) {

            // Status not set on this save (e.g. a partial update): leave the date alone
            if ($blog->is_draft === null) {
                return;
            }

            if ((int) $blog->is_draft === 0) {
                // Going live: stamp the date once, keep it on later edits
                if (empty($blog->published_at)) {
                    $blog->published_at = now();
                }
            } else {
                // Back to draft: clear it so a new date is set when republished
                $blog->published_at = null;
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function faqs()
    {
        return $this->hasMany(BlogFaq::class);
    }

    public function getPreviewSlugAttribute(): string
    {
        return Str::slug(filled($this->blog_url) ? $this->blog_url : $this->blog_heading);
    }
}