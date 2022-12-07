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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->foreignId('tenant_id')
                  ->constrained('tenants')
                  ->onDelete('cascade');
            $table->foreignId('client_id')
                  ->nullable()
                  ->constrained('clients')
                  ->onDelete('cascade');
            $table->foreignId('table_id')
                  ->nullable()
                  ->constrained('tables')
                  ->onDelete('cascade');
            $table->float('total',12,2);
            $table->enum('status',['open', 'working', 'delivering', 'done', 'rejected', 'canceled']);
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
};
