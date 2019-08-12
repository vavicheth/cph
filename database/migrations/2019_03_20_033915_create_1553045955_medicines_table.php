<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Create1553045955MedicinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('medicines')) {
            Schema::create('medicines', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name')->nullable();
                $table->string('type')->nullable();
                $table->decimal('price', 15, 2)->nullable();
                $table->datetime('expire')->nullable();
                $table->string('company')->nullable();
                $table->text('description')->nullable();
                $table->tinyInteger('active')->nullable()->default('1');
                
                $table->timestamps();
                $table->softDeletes();

                $table->index(['deleted_at']);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medicines');
    }
}
