<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BankCardType extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'bank_id',
        'name',
        'slug',
        'created_by',
        'updated_by',
        'status',
    ];


    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

}
