<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Create1553089006InvoicedetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('invoicedetails')) {
            Schema::create('invoicedetails', function (Blueprint $table) {
                $table->increments('id');
                $table->string('type')->nullable();
                $table->integer('qty')->nullable();
                $table->decimal('unit_price', 15, 2)->nullable();
                $table->decimal('total', 15, 2)->nullable();
                
                $table->timestamps();
                
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
        Schema::dropIfExists('invoicedetails');
    }
}
