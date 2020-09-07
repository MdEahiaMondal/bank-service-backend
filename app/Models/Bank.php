<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

/**
 * @method static create(array $only)
 * @method static paginate(int $int)
 * @method static find(int $int)
 */
class Bank extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'image',
        'location',
        'created_by',
        'updated_by',
        'status',
    ];


    protected $appends = ['image_url'];

    public function getImageUrlAttribute(){
        return  url('/') . Storage::url( 'banks/'.$this->image);
    }

    public function cards()
    {
        return $this->hasMany(Card::class, 'bank_id');
    }

    public function createdUser()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }


}
