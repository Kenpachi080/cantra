<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndividualApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('individual_applications', function (Blueprint $table) {
            $table->id();
            $table->integer('type');
            $table->integer('zamsha');
            $table->integer('row');
            $table->integer('edging');
            $table->string('name');
            $table->string('phone');
            $table->text('comment');
            $table->integer('price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('individual_applications');
    }
}
