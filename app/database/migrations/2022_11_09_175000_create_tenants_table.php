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
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->string('cnpj',15)->unique();
            $table->string('name',40)->unique();
            $table->string('url',200)->unique();
            $table->string('email',100)->unique();

            $table->foreignId('plan_id')
                  ->constrained('plans')
                  ->onDelete('cascade');

            $table->string('logo')->nullable();
            $table->enum('active',['Y','N'])->default('Y');
            $table->date('subscription_at')->nullable();
            $table->date('expires_at')->nullable();
            $table->string('subscription_id',200)->nullable();
            $table->boolean('subscription_active')->default(false);
            $table->boolean('subscription_suspended')->default(false);

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
        Schema::dropIfExists('tenants');
    }
};
