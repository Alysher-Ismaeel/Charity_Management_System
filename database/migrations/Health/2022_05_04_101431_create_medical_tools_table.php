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
        Schema::create('medical_tools', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->default(1)->constrained('categories')->cascadeOnDelete();
            $table->string('name');
            $table->integer('cost');
            $table->integer('donate')->default(0);
            $table->integer('count')->default(1);
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
        Schema::dropIfExists('medical_tools');
    }
};
