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
        Schema::create('connection_ids', function (Blueprint $table) {
			$table->bigIncrements('id');
            $table->string('item_id', 100)->nullable();
            $table->string('ids', 1000)->nullable();
            $table->string('flag1',30)->nullable();
            $table->string('flag2',30)->nullable();
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
        Schema::dropIfExists('connection_ids');
    }
};
