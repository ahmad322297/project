<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->text('img_url');
            $table->date('exp_date');
            $table->foreignId('category_id')->references('id')->on('categories')->cascadeOnDelete();;
            $table->integer('quantity')->default(1);
            $table->integer('price');
            $table->foreignId('user_id')->references('id')->on('users');
            $table->Integer('views')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
