<?php

use App\Models\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('log_activities', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('reference');
            $table->string('currency');
            $table->string('gateway_provider');
            $table->float('amount');
            $table->enum('status',[Log::PENDING, Log::SUCCESSFUL, Log::FAILED]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
