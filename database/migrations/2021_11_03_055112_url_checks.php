<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UrlChecks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('urls_checks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('url_id')->references('id')->on('urls');
            $table->string('status_code', 3)->nullable();
            $table->string('h1', 255)->nullable();
            $table->string('title', 255)->nullable();
            $table->string('description', 1000)->nullable();
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
        Schema::drop('urls_checks');
    }
}
