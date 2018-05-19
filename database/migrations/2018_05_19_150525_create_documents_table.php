<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nomor')->nullable();
            $table->integer('companies_id')->nullable();
            $table->integer('categories_id')->nullable();
            $table->date('date')->nullable();
            $table->string('price')->nullable();
            $table->integer('templates_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('documentfinal')->nullable();
            $table->timestamps();
            $table->softDeletes();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('documents');
    }
}
