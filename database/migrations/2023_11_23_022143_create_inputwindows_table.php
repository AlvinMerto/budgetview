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
        Schema::create('inputwindows', function (Blueprint $table) {
            $table->increments("activityid");
            $table->string("activitygrpid");
            $table->string("activitytitle");
            $table->string("initialcost")->nullable();
            $table->string("actualcost")->nullable();
            $table->string("dateofactivity")->nullable();
            $table->date("daterelease")->nullable();
            $table->date("daterecvbyoc")->nullable();
            $table->date("datereleasedbyoc")->nullable();
            $table->date("daterecvbyproc")->nullable();
            $table->string("status")->nullable();
            $table->integer("division")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inputwindows');
    }
};
