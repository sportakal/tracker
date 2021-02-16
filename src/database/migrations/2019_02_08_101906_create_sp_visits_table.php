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

            $table->integer('spSessionID')->unsigned();
            $table->foreign('spSessionID')->references('id')->on('sp_sessions')->onDelete('cascade');

            $table->boolean('is_loggedin')->default(false);

            $table->boolean('is_bot')->default(false);


            $table->string('method')->nullable();
            $table->boolean('is_ajax')->default(false);
            $table->text('url')->nullable();
            $table->text('full_url')->nullable();
            $table->text('locale')->nullable();
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

