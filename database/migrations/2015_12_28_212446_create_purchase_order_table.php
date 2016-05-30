<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('po', function(Blueprint $table){
            $table->bigIncrements('id');
            $table->date('date');
            $table->bigInteger('supplier_id')->unsigned();
            $table->text('remarks');
            $table->char('status',1)->default('S');
            $table->char('po_status',2)->default('P');
            $table->bigInteger('encoded_by')->unsigned();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('po_products', function(Blueprint $table){
            $table->bigIncrements('id');
            $table->bigInteger('po_id')->unsigned();
            $table->bigInteger('product_id')->unsigned();
            $table->decimal('quantity');
            $table->decimal('cost');
            $table->decimal('amount');

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
        Schema::drop('po');
        Schema::drop('po_products');
    }
}
