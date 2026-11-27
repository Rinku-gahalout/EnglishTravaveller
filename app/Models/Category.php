<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'meta_title',
        'meta_description',
        'description',
        'status',
    ];

    public function subcategories()
    {
        return $this->hasMany(Subcategory::class);
    }

    public function blogs()
    {
        return $this->hasMany(Blog::class); // adjust if your relation/model name differs
    }
}