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
        'image',
        'created_by',
        'updated_by',
        'status',
    ];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute(){
        return  url('/') . Storage::url($this->image);
    }
}
