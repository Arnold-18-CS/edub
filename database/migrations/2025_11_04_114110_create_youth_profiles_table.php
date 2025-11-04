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
    Schema::create('youth_profiles', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();

        $table->string('full_name');
        $table->string('gender')->nullable();
        $table->date('birth_date')->nullable();
        $table->string('education_level')->nullable();
        $table->text('bio')->nullable();
        $table->json('skills')->nullable(); // store skills as JSON
        $table->string('availability')->nullable(); // e.g. "Full-time", "Weekends"
        $table->string('contact_number')->nullable();
        $table->string('location')->nullable();
        $table->boolean('verified')->default(false);

        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('youth_profiles');
}

};