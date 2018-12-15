<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpVisitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sp_visits', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('SessionID')->unsigned();
            $table->foreign('SessionID')->references('id')->on('sp_sessions')->onDelete('cascade');

            $table->string('ip', 40);
            $table->string('method')->nullable();
            $table->boolean('is_ajax')->default(false);
            $table->text('url')->nullable();
            $table->text('referer')->nullable();
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
        Schema::dropIfExists('sp_visits');
    }
}
