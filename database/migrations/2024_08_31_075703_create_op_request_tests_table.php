<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('op_request_tests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 150);
            $table->integer('stuff');
            $table->string('pid', 100);
            $table->string('brand', 200);
            $table->string('model', 500);
            $table->integer('class')->nullable();
            $table->string('status_flg', 200)->nullable();
            $table->string('status', 10);
            $table->string('stock_condition', 200);
            $table->integer('price');
            $table->integer('price_sale')->nullable();
            $table->integer('maker_price')->nullable();
            $table->string('new_stock_condition', 200)->nullable();
            $table->text('new_price')->nullable;
            $table->integer('new_price_sale')->nullable();
            $table->integer('new_maker_price')->nullable();
            $table->text('sale_d')->nullable();
            $table->text('NO_PD')->nullable();
            $table->text('NO_CSVDL')->nullable();
            $table->text('CSVDL')->nullable();
            $table->text('MEMO')->nullable();
            $table->text('FINUSH')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('op_request_tests');
    }
};
