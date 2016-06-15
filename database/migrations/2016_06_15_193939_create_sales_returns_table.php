<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesReturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_returns', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->text('remarks');

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('sales_return_details', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('sales_return_id')->unsigned();

            $table->bigInteger('delivery_receipt_detail_id')->unsigned();
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
        Schema::drop('sales_returns');
        Schema::drop('sales_return_details');
    }
}
