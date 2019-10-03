<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarxUserRelationshipTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('marx_userRelationshipTypes');
        Schema::create('marx_user_relationship_types', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('marx_users')->onDelete('cascade');
            $table->integer('relationship_type_id')->unsigned();
            $table->foreign('relationship_type_id')->references('id')->on('marx_relationship_types')->onDelete('cascade');
            $table->index(['user_id', 'relationship_type_id']);
            $table->double('reminder_date');
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
        Schema::dropIfExists('marx_userRelationshipTypes');
    }
}
