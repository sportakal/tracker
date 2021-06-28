<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sp_sessions', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('spCookieID')->unsigned();
            $table->foreign('spCookieID')->references('id')->on('sp_cookies')->onDelete('cascade');
            $table->text('referer')->nullable();
            $table->boolean('is_bot')->nullable();
            $table->char('ip')->nullable();
            $table->string('country')->default('');
            $table->string('country_code')->default('');
            $table->string('city')->default('');
            $table->string('state_name')->default('');
            $table->string('state')->default('');
            $table->double('lat')->nullable();
            $table->double('lon')->nullable();
            $table->string('continent_code')->default('');
            $table->string('currency_code')->default('');
            $table->integer('gmt_offset')->nullable();
            $table->string('track_ad')->default('');
            $table->char('calling_code', 8)->default('');
            $table->boolean('default')->default(false);


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
        Schema::dropIfExists('sp_sessions');
    }
}

