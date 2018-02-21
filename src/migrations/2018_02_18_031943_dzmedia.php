<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Dzmedia extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('media', function(Blueprint $table)
      {
        $table->increments('id');
        $table->string('media_title');
        $table->bigInteger('media_author')->default(0);
        $table->dateTime('media_date');
        $table->dateTime('media_date_gmt');
        $table->dateTime('closing_date');
        $table->text('media_content');
        $table->string('media_slug');
        $table->string('media_type');
        $table->string('media_url');
        $table->string('media_extension')->default("");
        $table->string('media_status')->default('publish');
        $table->bigInteger('media_parent')->default(0);
        $table->string('guid')->default('');
        $table->string('postcode')->default('');
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
      Schema::drop('media');
    }
}
