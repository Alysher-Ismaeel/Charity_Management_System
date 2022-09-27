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
        Schema::create('takeouts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('amount');
            $table->string('reason');
            $table->foreignId('admin_id')->constrained('admins')->cascadeOnDelete();
            $table->foreignId('charity_box_id')->constrained('charity_boxes')->cascadeOnDelete();
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
        Schema::dropIfExists('takeouts');
    }
};
