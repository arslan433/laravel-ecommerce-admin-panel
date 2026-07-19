<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryDescription extends Model
{
    protected $fillable = [
        'category_id',
        'language_id',
        'name',
        'description',
        'title_tag',
        'alt_tag',
        'meta_description',
        'meta_keywords'
    ];

    public function category(){
        $this->belongsTo(Category::class);
    }
    public function languge(){
        $this->belongsTo(Language::class);
    }
}
