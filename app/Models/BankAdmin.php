<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static paginate(int $int)
 */
class BankAdmin extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'bank_id',
        'name',
        'designation',
        'per_user_benefit',
        'created_by',
        'updated_by',
        'status',
    ];
}
