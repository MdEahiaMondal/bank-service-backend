<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $fillable = [
        'bank_id',
        'name',
        'slug',
        'status',
        'created_by',
        'updated_by',
    ];


    public function bank(){
        return $this->belongsTo(Bank::class);
    }

    public function createdBy(){
        return $this->belongsTo(User::class, 'created_by');
    }

}
