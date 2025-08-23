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
        Schema::create('albums', function (Blueprint $table) {
            $table->id();
            $table->string('remote_id')->nullable();
            $table->timestamp('date_add')->nullable();
            $table->timestamp('date_over')->nullable();
            $table->timestamp('date_upd')->nullable();
            $table->enum('status', ['live', 'longterm'])->default('live');
            $table->foreignId('venue_id')->constrained()->onDelete('cascade');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('albums');
    }
};
