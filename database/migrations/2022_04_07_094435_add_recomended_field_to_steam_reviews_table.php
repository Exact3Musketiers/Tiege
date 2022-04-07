<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRecomendedFieldToSteamReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('steam_reviews', function (Blueprint $table) {
            $table->boolean('recomended');
        });

        DB::table('steam_reviews')->update([
            'recomended' => false
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('steam_reviews', function (Blueprint $table) {
            $table->dropColumn("recomended");
        });
    }
}
