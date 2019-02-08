<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlocksTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('lb_blocks', function (Blueprint $table) {
            $table->increments('id');
            $table->json('title');
            $table->json('content');
            $table->string('status');
            $table->string('slug');
            $table->string('type')->default('wp_block');
            $table->string('template')->default(' ');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('lb_blocks');
    }
}