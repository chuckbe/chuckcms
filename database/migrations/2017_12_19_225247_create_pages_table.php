<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('site_id');
            $table->integer('template_id');
            $table->string('page')->nullable()->default(null);
            $table->integer('order')->default(1);
            $table->tinyInteger('isHp')->default(0);
            $table->string('title');
            $table->string('slug');
            $table->integer('active');
            $table->string('roles')->nullable()->default(null);
            $table->longText('meta');
            $table->longText('css')->nullable();
            $table->longText('js')->nullable();
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
        Schema::dropIfExists('pages');
    }
}
