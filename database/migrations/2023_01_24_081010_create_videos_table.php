<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('videos')){
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('uid');
            $table->unsignedBigInteger('post_id');
            $table->text('path');
            $table->string('processed_file');
            $table->enum('visibility', ['private', 'public']);
            $table->boolean('allow_like')->default(false);
            $table->boolean('allow_comment')->default(false);
            $table->string('processing_percentage')->default(0);
            $table->timestamps();
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
        Schema::dropIfExists('videos');
    }
}