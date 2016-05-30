<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateStocksReceivingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rr', function(Blueprint $table){
            $table->bigIncrements('id');
            $table->date('date');
            $table->text('remarks');
            $table->char('status',1)->default('S');
            $table->bigInteger('encoded_by')->unsigned();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('products_rr', function(Blueprint $table){
            $table->bigIncrements('id');
            $table->bigInteger('rr_id')->unsigned();
            $table->bigInteger('product_id')->unsigned();
            $table->bigInteger('po_detail_id')->unsigned();
            $table->string('document_no',100);
            $table->decimal('quantity');
            $table->decimal('cost');
            $table->decimal('amount');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('rr_serial', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('rr_detail_id')->unsigned();
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
        Schema::drop('rr');
        Schema::drop('products_rr');
        Schema::drop('rr_serial');
    }
}
