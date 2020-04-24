<?php

/**
 * @author César Escudero <cedaesca@gmail.com>
 * @package cedaesca\UrlShortener
 * @copyright © 2020 César Escudero, all rights reserved worldwide
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShortenedurlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shortenedurls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_by')->nullable();
            $table->string('code')->unique();
            $table->string('target');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->timestampsTz();
            $table->softDeletesTz();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shortenedurls');
    }
}
