<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('chargingtos', function (Blueprint $table) {
            $table->increments("chargeid");
            $table->string("activitygrpid");
            $table->integer("actualcost");
            $table->integer("chargewhat");
            $table->integer("chargeto");
            $table->integer("chargetype");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chargingtos');
    }
};
