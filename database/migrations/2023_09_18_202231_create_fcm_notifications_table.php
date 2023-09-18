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
        Schema::create('fcm_notifications', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('auth_id')->nullable();
            $table->string('auth_type');
            $table->string('device_id')->nullable();
            $table->string('action')->nullable();
            $table->unsignedBigInteger('action_id')->nullable();
            $table->boolean('seen')->default(false);

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fcm_notifications');
    }
};
