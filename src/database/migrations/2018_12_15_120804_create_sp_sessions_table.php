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

            $table->boolean('is_user')->default(false);
            $table->unsignedInteger('user_id')->nullable(true);
            $table->integer('cookie')->nullable(true);
            $table->integer('session')->nullable(true);


            $table->string('ip', 40);

            $table->text('url')->nullable();
            $table->text('referer')->nullable();

            $table->string('user_agent')->nullable();
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


            $table->string('country')->default('');
            $table->string('country_code')->default('');
            $table->string('city')->default('');
            $table->string('state_name')->default('');
            $table->string('state')->default('');
            $table->double('lat')->nullable();
            $table->double('lon')->nullable();


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
