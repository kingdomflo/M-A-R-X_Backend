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
        Schema::create('marx_userRelationshipTypes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('userId')->unsigned();
            $table->foreign('userId')->references('id')->on('marx_users');
            $table->integer('relationshipTypeId')->unsigned();
            $table->foreign('relationshipTypeId')->references('id')->on('marx_relationshipTypes');
            $table->index(['userId', 'relationshipTypeId']);
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
