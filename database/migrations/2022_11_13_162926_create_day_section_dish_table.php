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
        Schema::create('day_section_dish', function (Blueprint $table) {
            $table->foreignId('dish_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('day_section_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->primary(['dish_id', 'day_section_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('day_section_dish');
    }
};
