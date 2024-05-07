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
        Schema::create('connection_infos', function (Blueprint $table) {
			$table->bigIncrements('id');
            $table->string('patern', 1000)->nullable();
            $table->string('match_id', 1000)->nullable();
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
        Schema::dropIfExists('connection_infos');
    }
};
