<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hotel_settings', function (Blueprint $table) {
            $table->id();
            $table->string('hotel_name')->default('Taskra Hotel');
            $table->string('currency')->default('PHP');
            $table->string('timezone')->default('Asia/Manila');
            $table->string('language')->default('en');
            $table->boolean('task_notifications')->default(true);
            $table->boolean('issue_alerts')->default(true);
            $table->boolean('email_notifications')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hotel_settings');
    }
};