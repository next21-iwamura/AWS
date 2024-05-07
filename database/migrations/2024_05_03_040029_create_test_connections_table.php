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
        Schema::create('test_connections', function (Blueprint $table) {
			$table->bigIncrements('id');
            $table->string('item_id', 100)->nullable();
			$table->string('site',10)->nullable();
            $table->integer('kinds')->nullable();
            $table->integer('class')->nullable();
            $table->string('brand',100)->nullable();
            $table->string('category_code', 100);
            $table->string('ref', 150)->nullable();
            $table->date('arrival')->nullable();
			$table->integer('status')->nullable();
            $table->integer('del')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_connections');
    }
};
