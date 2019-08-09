<?php

/**
 * @author César Escudero <cedaesca@gmail.com>
 * @package cedaesca\URLShortener
 * @copyright © 2019 César Escudero, all rights reserved worldwide
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visitors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('agent');
            $table->ipAddress('ip');
            $table->unsignedBigInteger('shortenedurl_id');
            $table->timestamps();
            $table->foreign('shortenedurl_id')->references('id')->on('shortenedurls');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('visitors');
    }
}
