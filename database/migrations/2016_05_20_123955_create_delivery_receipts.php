<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveryReceipts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_receipts', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('customer_id')->unsigned();
            $table->date('date');
            $table->string('salesman');
            $table->text('remarks');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('delivery_receipt_details', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('delivery_receipt_id')->unsigned();
            $table->bigInteger('product_id')->unsigned();
            $table->decimal('quantity');
            $table->decimal('price',12,2);
            $table->decimal('amount',12,2);
            $table->string('serial_no');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('delivery_receipts');
        Schema::drop('delivery_receipt_details');
    }
}
