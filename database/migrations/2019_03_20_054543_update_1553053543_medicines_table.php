<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Update1553053543MedicinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('medicines', function (Blueprint $table) {
            if(Schema::hasColumn('medicines', 'expire')) {
                $table->dropColumn('expire');
            }
            
        });
Schema::table('medicines', function (Blueprint $table) {
            
if (!Schema::hasColumn('medicines', 'expire_date')) {
                $table->date('expire_date')->nullable();
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
        Schema::table('medicines', function (Blueprint $table) {
            $table->dropColumn('expire_date');
            
        });
Schema::table('medicines', function (Blueprint $table) {
                        $table->datetime('expire')->nullable();
                
        });

    }
}
