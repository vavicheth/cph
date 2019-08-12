<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Add5c92454cc1e48RelationshipsToInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoices', function(Blueprint $table) {
            if (!Schema::hasColumn('invoices', 'patient_id')) {
                $table->integer('patient_id')->unsigned()->nullable();
                $table->foreign('patient_id', '280118_5c91ad259ac23')->references('id')->on('patients')->onDelete('cascade');
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
        Schema::table('invoices', function(Blueprint $table) {
            
        });
    }
}
