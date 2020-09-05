<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        'location',
        'created_by',
        'updated_by',
        'status',
    ];

    public function bankCards()
    {
        return $this->hasMany(BankCardType::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }


}
