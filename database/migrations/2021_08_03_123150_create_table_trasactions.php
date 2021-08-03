<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableTrasactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('trasaction_id', 3000)->nullable();
            $table->string('time')->nullable();
            $table->integer('payment_channel')->default(3);
            $table->bigInteger('amount')->default(0);
            $table->string('currency')->default('CLP');
            $table->string('signature', 3000)->nullable();
            $table->string('time_expired')->nullable();
            $table->string('shopper_first_name')->nullable();
            $table->string('shopper_last_name')->nullable();
            $table->string('type_doc_identi')->nullable();
            $table->string('Num_doc_identi')->nullable();
            $table->string('email')->nullable();
            $table->string('country_code')->nullable();
            $table->string('Phone')->nullable();
            $table->string('transaction_status')->default(0)->comments="0 => Pending, 1 => Success, 2 => Failed";
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
        Schema::dropIfExists('transactions');
    }
}
