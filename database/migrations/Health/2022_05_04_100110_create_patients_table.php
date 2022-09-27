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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->default(1)->constrained('categories')->cascadeOnDelete();
            $table->string('name');
            $table->date('birth_date');
            $table->string('medical_condition');
            $table->bigInteger('cost');
            $table->integer('donate')->default(0);
            $table->enum('gender',['female','male'])->default('male');
            $table->longText('description')->nullable();
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
        Schema::dropIfExists('patients');
    }
};
