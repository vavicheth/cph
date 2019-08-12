<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Create1553008684OrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('organizations')) {
            Schema::create('organizations', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name_kh')->nullable();
                $table->string('name_en')->nullable();
                $table->string('address')->nullable();
                $table->string('contact')->nullable();
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
        Schema::dropIfExists('organizations');
    }
}
