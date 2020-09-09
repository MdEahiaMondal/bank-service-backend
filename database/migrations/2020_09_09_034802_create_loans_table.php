<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('bank_id');
            $table->string('office_name', 255);
            $table->string('office_address', 255);
            $table->string('designation', 255);
            $table->float('basic_salary');
            $table->float('gross_salary');
            $table->string('salary_payment_by_bank', 255);
            $table->string('cash_payment_by_bank', 255);
            $table->string('a_t', 100);
            $table->float('loan_limit_amount');
            $table->tinyInteger('secondary_bank_loan')->default(0);
            $table->string('secondary_bank_name', 255)->nullable();
            $table->float('secondary_bank_amount')->nullable();
            $table->string('secondary_bank_address', 255)->nullable();
            $table->string('salary_certificate', 1024);
            $table->string('tin_certificate', 1024);
            $table->string('nid_card_front', 1024);
            $table->string('nid_card_back', 1024);
            $table->string('job_id_card', 1024);
            $table->string('visiting_card', 1024);
            $table->string('status');
            $table->string('apply_for', 100);
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
        Schema::dropIfExists('loans');
    }
}
