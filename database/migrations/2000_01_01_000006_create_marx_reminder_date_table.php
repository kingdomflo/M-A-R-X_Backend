<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarxReminderDateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('marx_reminderDates');
        Schema::create('marx_reminderDates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('paymentId')->unsigned();
            $table->foreign('paymentId')->references('id')->on('marx_payments');
            $table->date('date');
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
        Schema::dropIfExists('marx_reminderDates');
    }
}
