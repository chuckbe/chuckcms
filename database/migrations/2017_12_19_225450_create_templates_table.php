<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('templates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('site_id');
            $table->string('name');
            $table->string('slug');
            $table->string('hintpath');
            $table->string('path');
            $table->string('type');
            $table->string('version');
            $table->string('author');
            $table->longText('fonts');
            $table->longText('css');
            $table->longText('js');
            $table->longText('json');
            $table->integer('active');
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
        Schema::dropIfExists('templates');
    }
}
