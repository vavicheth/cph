<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Add5c9241f48bb34RelationshipsToInvoicedetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoicedetails', function(Blueprint $table) {
            if (!Schema::hasColumn('invoicedetails', 'invoice_id')) {
                $table->integer('invoice_id')->unsigned()->nullable();
                $table->foreign('invoice_id', '280315_5c9241f1b1fa0')->references('id')->on('invoices')->onDelete('cascade');
                }
                if (!Schema::hasColumn('invoicedetails', 'medicine_id')) {
                $table->integer('medicine_id')->unsigned()->nullable();
                $table->foreign('medicine_id', '280315_5c9241f1c9ea7')->references('id')->on('medicines')->onDelete('cascade');
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
        Schema::table('invoicedetails', function(Blueprint $table) {
            
        });
    }
}
