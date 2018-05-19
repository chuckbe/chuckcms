<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->integer('template_id');
            $table->tinyInteger('isHp')->default(0);
            $table->string('title');
            $table->string('slug');
            $table->integer('active');
            $table->string('meta_title');
            $table->string('meta_og_title');
            $table->text('meta_keywords');
            $table->longText('meta_description');
            $table->longText('meta_og_description');
            $table->string('meta_og_image');
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
