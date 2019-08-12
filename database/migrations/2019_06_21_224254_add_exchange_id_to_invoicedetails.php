<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExchangeIdToInvoicedetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoicedetails', function (Blueprint $table) {
            $table->integer('extend_id')->nullable();
            $table->decimal('org_price')->nullable();
            $table->integer('exchange_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoicedetails', function (Blueprint $table) {
            $table->dropColumn('extend_id');
            $table->dropColumn('org_price');
            $table->dropColumn('exchange_id');
        });
    }
}
