<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_admins', function (Blueprint $table) {
            $table->id();

            $table->string('name', 255);
            $table->unsignedBigInteger('bank_id');
            $table->unsignedBigInteger('user_id');
            $table->string('designation', 255);
            $table->string('status');
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->float('per_user_benefit');

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
        Schema::dropIfExists('bank_admins');
    }
}
