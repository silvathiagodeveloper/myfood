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
        Schema::create('profile_plan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')
                  ->constrained('profiles')
                  ->onDelete('cascade');
            $table->foreignId('plan_id')
                  ->constrained('plans')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profile_plan');
    }
};
