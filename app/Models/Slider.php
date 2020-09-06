<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Slider extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'image',
        'status',
        'created_by',
        'updated_by',
    ];


    public function setSlugAttribute($value)
    {
        $slug = trim(preg_replace("/[^\w\d]+/i", '-',$value));
        $count = $this->where('slug', 'like', "%${slug}%")->count();
        $slug = $slug.($count + 1);
        $this->attributes['slug'] = strtolower($slug);
    }

    public function getSlugAttribute($value)
    {
        if ($value == null){
            return $this->id;
        }
        return $value;
    }


    protected $appends = ['image_url'];

    public function getImageUrlAttribute(){
        return  url('/') . Storage::url('sliders/'.$this->image);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

}
