<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCssJsColumnToPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('pages', 'css')) {
            Schema::table('pages', function (Blueprint $table) {
                $table->longText('css')->nullable()->after('meta');
            });
        }

        if (!Schema::hasColumn('pages', 'js')) {
            Schema::table('pages', function (Blueprint $table) {
                $table->longText('js')->nullable()->after('css');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn('js');
            $table->dropColumn('css');
        });
    }
}
