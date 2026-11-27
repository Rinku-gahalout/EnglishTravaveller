<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogFaq extends Model
{
    protected $fillable = [
        'blog_id',
        'question',
        'answer',
    ];
    
    protected $touches = ['blog'];

    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }
}