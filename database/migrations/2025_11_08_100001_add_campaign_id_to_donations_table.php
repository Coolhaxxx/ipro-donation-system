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
        Schema::table('donations', function (Blueprint $table) {
            // Add campaign_id foreign key
            $table->foreignId('campaign_id')->nullable()->after('donor_id')->constrained()->onDelete('set null');
            
            // Drop old campaign text field if it exists
            if (Schema::hasColumn('donations', 'campaign')) {
                $table->dropColumn('campaign');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->dropForeign(['campaign_id']);
            $table->dropColumn('campaign_id');
            $table->string('campaign')->default('Jamaica Hurricane Relief');
        });
    }
};
