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
    Schema::create('applications', function (Blueprint $table) {
        $table->id();
        $table->foreignId('opportunity_id')->constrained()->cascadeOnDelete();
        $table->foreignId('youth_profile_id')->constrained()->cascadeOnDelete();

        $table->string('status')->default('Pending'); // Pending, Accepted, Rejected, Completed
        $table->text('cover_letter')->nullable();
        $table->date('applied_on')->useCurrent();

        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('applications');
}

};
