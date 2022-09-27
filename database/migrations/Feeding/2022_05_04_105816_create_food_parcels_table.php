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
        Schema::create('food_parcels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->default(2)->constrained('categories')->cascadeOnDelete();
            $table->enum('size',['Small','Medium','Large'])->default('Small');
            $table->integer('count')->default(0);
            $table->integer('cost');
            $table->integer('donate')->default(0);
            $table->longText('content');
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
        Schema::dropIfExists('food_parcels');
    }
};
