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
        Schema::create('budgetviews', function (Blueprint $table) {
            $table->increments("budgetviewid");
            $table->integer("divid");
            $table->string("planned");
            $table->string("actual");
            $table->string("year");
            $table->string("isactive");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budgetviews');
    }
};
