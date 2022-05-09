<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartnerBiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partner_bios', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->string('step1');
            $table->string('step1_content');
            $table->string('step2');
            $table->string('step2_content');
            $table->string('step3');
            $table->string('step3_content');
            $table->string('step4');
            $table->string('step4_content');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('partner_bios');
    }
}
