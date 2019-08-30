<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarxPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('marx_payments');
        Schema::create('marx_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('userId')->unsigned();
            $table->foreign('userId')->references('id')->on('marx_users');
            $table->integer('relationshipId')->unsigned();
            $table->foreign('relationshipId')->references('id')->on('marx_relationships');
            $table->integer('user_currenciesId')->unsigned();
            $table->foreign('user_currenciesId')->references('id')->on('marx_user_currencies');
            $table->string('title', 20);
            $table->string('detail', 280)->nullable();
            $table->string('currency', 10);
            $table->double('amount');
            $table->date('date');
            $table->string('type', 3);
            $table->boolean('refunded')->default(false);
            $table->date('refundedDate')->nullable();
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
        Schema::dropIfExists('marx_payments');
    }
}
