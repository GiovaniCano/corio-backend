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
        Schema::create('itemables', function (Blueprint $table) {
            $table->id();
            $table->morphs('itemable');
            $table->foreignId('item_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->decimal('quantity');
            $table->foreignId('measurement_unit_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
                // prompt the user to update itemables before delete a unit
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
        Schema::dropIfExists('itemables');
    }
};
