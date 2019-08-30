<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarxRelationshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('marx_relationships');
        Schema::create('marx_relationships', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->integer('userRelationshipTypeId')->unsigned();
            $table->foreign('userRelationshipTypeId')->references('id')->on('marx_user_relationship_types');
            $table->index(['name', 'userRelationshipTypeId']);
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
        Schema::dropIfExists('marx_relationships');
    }
}
