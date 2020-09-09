<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Loan extends Model
{
    use SoftDeletes;
    protected $fillable =
        [
            'user_id',
            'bank_id',
            'phone',
            'office_name',
            'office_address',
            'designation',
            'basic_salary',
            'gross_salary',
            'salary_certificate',
            'job_id_card',
            'visiting_card',
            'nid_card',
            'bank_loan',
            'loan_limit_amount',
            'status',
            'created_by',
            'updated_by'
        ];

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

}
