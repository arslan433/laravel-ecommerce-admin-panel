<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Model;


class Category extends Model
{
    protected $fillable = [
        'parent_id',
        'image',
        'slug',
        'top',
        'column',
        'sort_order',
        'status'
    ];

    public function description(){
        $this->hasOne(CategoryDescription::class)->where('language_id' , getAdminDefaultLang());
    }
    public function descriptions(){
        $this->hasMany(CategoryDescription::class, 'language_id');
    }

    #[Scope]
    public function lang()
    {
        return $this->description()->where('language_id', getAdminDefaultLang())->first();
    }
}
