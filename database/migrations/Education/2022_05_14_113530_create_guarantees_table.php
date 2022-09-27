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
        Schema::create('guarantees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->default(3)->constrained('categories')->cascadeOnDelete();
            $table->string('name');
            $table->date('birth_date');
            $table->string('academic_year');
            $table->integer('cost');
            $table->date('time')->nullable();
            $table->date('exp_date')->nullable();
            $table->boolean('guaranteed')->default(false);
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
        Schema::dropIfExists('guarantees');
    }
};
