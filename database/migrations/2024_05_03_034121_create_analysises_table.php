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
        Schema::create('analysises', function (Blueprint $table) {
			$table->bigIncrements('id');
            $table->date('uriage')->nullable();
            $table->date('shukka')->nullable();
            $table->string('gamenkubun', 20)->nullable();
            $table->string('shouhin', 20)->nullable();
            $table->string('pname', 300)->nullable();
            $table->string('zeiritsukubun', 20)->nullable();
            $table->string('zeiritsu', 20)->nullable();
            $table->integer('uriagesuu')->nullable();
            $table->integer('uriagetanka')->nullable();
            $table->integer('uriagekingaku')->nullable();
            $table->integer('genkatanka')->nullable();
            $table->integer('genkakingaku')->nullable();
            $table->integer('ararikingaku')->nullable();
            $table->string('stuffname', 50)->nullable();
            $table->string('genkinkubun', 20)->nullable();
            $table->integer('bumon')->nullable();
            $table->string('bumonmei', 30)->nullable();
            $table->integer('baikyakukubun')->nullable();
            $table->integer('tsuuhankubun')->nullable();
            $table->string('shouhinkubunbunruimei', 50)->nullable();
            $table->integer('atsukaibumon')->nullable();
            $table->integer('brand')->nullable();
            $table->string('brandname', 300)->nullable();
            $table->integer('joudaitanka')->nullable();
            $table->string('jancode', 100)->nullable();
            $table->string('sirialno', 100)->nullable();
            $table->string('refno', 300)->nullable();
            $table->integer('nebiki')->nullable();
            $table->integer('zeinukinebiki')->nullable();
            $table->string('menzei', 20)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analysises');
    }
};
