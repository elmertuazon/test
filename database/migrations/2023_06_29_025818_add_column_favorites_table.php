<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnFavoritesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('favorites', function (Blueprint $table) {
            $table->dropForeign(["post_id"]);
            $table->dropColumn('post_id');
            $table->foreignId('favoritable_id')->after('user_id');
            $table->string('favoritable_type')->after('favoritable_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('favorites', function (Blueprint $table) {
            $table->dropColumn("favoritable_id");
            $table->dropColumn("favoritable_type");
        });
    }
}
