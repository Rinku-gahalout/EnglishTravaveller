<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        'image',
        'alt_tag',
        'is_draft',
    ];

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
}