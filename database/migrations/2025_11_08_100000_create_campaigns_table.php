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
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            
            // Images
            $table->string('logo')->nullable();
            $table->string('cover_image')->nullable();
            
            // Campaign Text Content
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->text('goal_text')->nullable();
            $table->text('impact_text')->nullable();
            
            // Campaign Settings
            $table->decimal('goal_amount', 12, 2)->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_default')->default(false);
            
            // Dates
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            
            $table->timestamps();
            
            // Indexes
            $table->index('is_active');
            $table->index('is_default');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
