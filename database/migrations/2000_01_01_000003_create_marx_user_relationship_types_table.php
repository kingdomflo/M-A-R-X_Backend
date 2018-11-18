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
        Schema::dropIfExists('marx_user_relationship_types');
        Schema::create('marx_user_relationship_types', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('marx_users');
            $table->integer('relationship_type_id')->unsigned();
            $table->foreign('relationship_type_id')->references('id')->on('marx_relationship_types');
            $table->index(['user_id', 'relationship_type_id']);
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
        Schema::dropIfExists('marx_user_relationship_types');
    }
}
