<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToVideos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('videos', function (Blueprint $table) {
            //
            $table->string('image')->nullable();
            $table->text('body')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->boolean('pinned')->default(false);
            $table->string('type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->dropColumn('image');
            $table->dropColumn('body');
            $table->dropColumn('user_id');
            $table->dropColumn('pinned');
            $table->dropColumn('type');
        });
    }
}
