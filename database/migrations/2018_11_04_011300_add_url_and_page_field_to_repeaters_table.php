<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUrlAndPageFieldToRepeatersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('repeaters', function (Blueprint $table) {
            $table->string('url')->nullable()->default(null)->after('slug');
            $table->string('page')->nullable()->default('default')->after('url');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('repeaters', function (Blueprint $table) {
            $table->dropColumn('url');
            $table->dropColumn('page');
        });
    }
}
