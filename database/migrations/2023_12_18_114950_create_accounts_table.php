<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->integer('account_number');
            $table->unsignedBigInteger('user_id');
            $table->enum('currency', ['LBP', 'USD', 'EUR']);
            $table->decimal('balance', 20, 2)->default(0.00);
            $table->enum('status', ['pending', 'approved', 'disapproved', 'disabled'])->default('pending');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}
