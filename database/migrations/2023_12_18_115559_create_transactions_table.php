<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('account_id');
            $table->enum('type', ['deposit', 'withdrawal', 'transfer']);
            $table->decimal('amount', 20, 2);
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('account_id')->references('id')->on('bank_accounts')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
