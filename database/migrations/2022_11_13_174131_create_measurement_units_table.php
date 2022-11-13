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
        Schema::create('measurement_units', function (Blueprint $table) {
            $table->id();
            $table->string('name', 25);
            $table->string('abbreviation', 4)->nullable();
            $table->foreignId('measurement_type_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->decimal('convertion')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
            
            $table->unique(['name', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('measurement_units');
    }
};
