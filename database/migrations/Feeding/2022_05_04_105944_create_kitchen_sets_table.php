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
        Schema::create('kitchen_sets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->default(2)->constrained('categories')->cascadeOnDelete();
            $table->string('name');
            $table->bigInteger('count')->default(1);
            $table->bigInteger('cost');
            $table->bigInteger('donate')->default(0);
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
        Schema::dropIfExists('kitchen_sets');
    }
};
