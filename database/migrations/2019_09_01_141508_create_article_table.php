<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->nullable();
            $table->string('name');
            $table->text('content')->nullable();
            $table->string('type')->nullable();
            $table->string('status')->nullable();
            $table->string('thumb')->nullable();
            $table->dateTime('created')->nullable();
            $table->string('created_by')->nullable();
            $table->dateTime('modified')->nullable();
            $table->string('modified_by')->nullable();
            $table->date('publish_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article');
    }
}
