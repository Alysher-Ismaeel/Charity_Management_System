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
            Schema::create('stationeries', function (Blueprint $table) {
                $table->id();
                $table->foreignId('category_id')->default(3)->constrained('categories')->cascadeOnDelete();
                $table->string('name');
                $table->integer('count')->default(0);
                $table->integer('cost');
                $table->enum('size',['small','medium','big'])->default('small');
                $table->integer('donate')->default(0);
                $table->longText('content')->nullable();
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
            Schema::dropIfExists('stationeries');
        }
    };
