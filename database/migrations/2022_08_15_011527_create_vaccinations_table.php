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
        Schema::create('vaccinations', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('dose')->default('1');
            $table->date('date');
            $table->foreignId('society_id')->constrained('societies');
            $table->foreignId('spot_id')->nullable()->constrained('spots');
            $table->foreignId('vaccine_id')->nullable()->constrained('vaccines');
            $table->foreignId('doctor_id')->nullable()->constrained('medicals');
            $table->foreignId('officer_id')->nullable()->constrained('medicals');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vaccinations');
    }
};
