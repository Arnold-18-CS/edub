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
        Schema::table('opportunities', function (Blueprint $table) {
            // Eligibility Criteria Fields
            $table->integer('min_age')->nullable()->after('available_slots');
            $table->integer('max_age')->nullable()->after('min_age');
            $table->string('required_education_level')->nullable()->after('max_age');
            $table->json('required_skills')->nullable()->after('required_education_level');
            $table->string('preferred_location')->nullable()->after('required_skills');
            
            // Publishing Status
            $table->enum('status', ['draft', 'published', 'closed'])->default('draft')->after('approved');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('opportunities', function (Blueprint $table) {
            $table->dropColumn([
                'min_age',
                'max_age',
                'required_education_level',
                'required_skills',
                'preferred_location',
                'status'
            ]);
        });
    }
};

