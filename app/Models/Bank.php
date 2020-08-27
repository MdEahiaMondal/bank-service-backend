<?php

namespace App\Models;

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
}
