<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpCookiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sp_cookies', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('is_user')->default(false);
            $table->unsignedInteger('user_id')->nullable(true);

            $table->char('name')->nullable();
            $table->char('email')->nullable();
            $table->char('tel')->nullable();


            $table->text('user_agent')->nullable();
            $table->boolean('is_desktop')->default(false);
            $table->boolean('is_mobile')->default(false);
            $table->boolean('is_bot')->default(false);
            $table->string('bot')->nullable();

            $table->string('device')->default('');
            $table->string('os_family')->default('');
            $table->string('os')->default('');
            $table->string('browser_family')->default('');
            $table->string('browser')->default('');
            $table->string('browser_language')->default('');

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
        Schema::dropIfExists('sp_cookies');
    }
}

