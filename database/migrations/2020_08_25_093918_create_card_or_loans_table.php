<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardOrLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('card_or_loans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('bank_id');
            $table->string('office_name');
            $table->string('office_address');
            $table->string('designation');
            $table->string('basic_salary');
            $table->string('gross_salary');
            $table->string('salary_payment_by_bank');
            $table->string('cash_payment_by_bank');
            $table->string('a_t');
            $table->string('loan_limit_amount');
            $table->string('secondary_bank_loan')->default("no");
            $table->string('secondary_bank_name')->nullable();
            $table->string('secondary_bank_amount')->nullable();
            $table->string('secondary_bank_address')->nullable();
            $table->string('salary_certificate', 1024);
            $table->string('tin_certificate', 1024);
            $table->string('nid_card', 1024);
            $table->string('job_id_card', 1024);
            $table->string('visiting_card', 1024);
            $table->string('status');
            $table->string('apply_for');
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('card_or_loans');
    }
}
