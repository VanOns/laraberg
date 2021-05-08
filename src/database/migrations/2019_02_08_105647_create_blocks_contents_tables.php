<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlocksContentsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('laraberg.models.block', \VanOns\Laraberg\Models\Block::class)::tableName(), function (Blueprint $table) {
            $table->increments('id');
            $table->string('raw_title')->nullable();
            $table->text('raw_content')->nullable();
            $table->text('rendered_content')->nullable();
            $table->string('status');
            $table->string('slug');
            $table->string('type')->default('wp_block');
            $table->timestamps();
        });

        Schema::create(config('laraberg.models.content', \VanOns\Laraberg\Models\Content::class)::tableName(), function (Blueprint $table) {
            $table->increments('id');
            $table->text('raw_content')->nullable();
            $table->text('rendered_content')->nullable();
            $table->morphs('contentable');
            $table->string('type')->default('page');
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
        Schema::drop(config('laraberg.models.block', \VanOns\Laraberg\Models\Block::class)::tableName());
        Schema::drop(config('laraberg.models.content', \VanOns\Laraberg\Models\Content::class)::tableName());
    }
}

