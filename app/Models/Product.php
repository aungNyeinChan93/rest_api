<?php

namespace App\Models;

use App\Models\Image;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $guarded=[];


    public function category(){
        return $this->belongsTo(Category::class,"category_id");
    }

    public function images(){
        return $this->hasMany(Image::class);
    }
}
