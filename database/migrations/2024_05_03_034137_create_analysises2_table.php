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
        Schema::create('analysises2', function (Blueprint $table) {
			$table->bigIncrements('id');
            $table->date('date')->nullable();
            $table->integer('souko')->nullable();
            $table->string('souko_name',300)->nullable();
            $table->integer('brand_id')->nullable();
            $table->string('brand_name', 300)->nullable();
            $table->integer('shouhin')->nullable();
            $table->string('shouhin_name', 300)->nullable();
            $table->string('bumon', 300)->nullable();
            $table->string('shouhinkubunbunrui_name',100)->nullable();
            $table->integer('zengetsumizaikosuuryou')->nullable();
            $table->integer('siiresuuryou')->nullable();
            $table->integer('nyuukosuuryou')->nullable();
            $table->integer('uriagesuuryou')->nullable();
            $table->integer('shukkosuuryou')->nullable();
            $table->integer('chouseisuuryou')->nullable();
            $table->integer('tougetsumizaikosuuryou')->nullable();
            $table->integer('zaikokingaku')->nullable();
            $table->string('ref', 100)->nullable();
            $table->string('tag', 100)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analysises2');
    }
};
