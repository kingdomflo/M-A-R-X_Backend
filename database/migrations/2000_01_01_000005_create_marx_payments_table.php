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
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('marx_users')->onDelete('cascade');;
            $table->integer('relationship_id')->unsigned();
            $table->foreign('relationship_id')->references('id')->on('marx_relationships')->onDelete('cascade');;
            $table->string('title', 20);
            $table->string('detail', 280)->nullable();
            $table->string('currency', 10);
            $table->double('amount');
            $table->date('date');
            $table->string('type', 3);
            $table->boolean('refunded')->default(false);
            $table->date('refunded_date')->nullable();
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
