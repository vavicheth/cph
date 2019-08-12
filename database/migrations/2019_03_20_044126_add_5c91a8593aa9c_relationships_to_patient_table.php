<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Add5c91a8593aa9cRelationshipsToPatientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('patients', function(Blueprint $table) {
            if (!Schema::hasColumn('patients', 'oranization_id')) {
                $table->integer('oranization_id')->unsigned()->nullable();
                $table->foreign('oranization_id', '280117_5c91a85691048')->references('id')->on('organizations')->onDelete('cascade');
                }
                
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('patients', function(Blueprint $table) {
            
        });
    }
}
