<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;


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
       return $this->hasOne(CategoryDescription::class)->where('language_id', getAdminDefaultLang());
    }
    public function descriptions(){
       return $this->hasMany(CategoryDescription::class);
    }

    #[Scope]
    public function lang()
    {
        return $this->description()->where('language_id', getAdminDefaultLang())->first();
    }

     public function deleteWithImages()
    {
        if ($this->attributes['image']) {
            $file = 'assets/'.$this->attributes['image'];
            Storage::delete($file);
        }
        $this->delete();
    }
}
