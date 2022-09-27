<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('food_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->default(2)->constrained('categories')->cascadeOnDelete();
            $table->string('name');
            $table->integer('cost');
            $table->integer('count')->default(1);
            $table->integer('donate')->default(0);
            $table->text('image')->nullable();
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
        Schema::dropIfExists('food_sections');
    }
};
