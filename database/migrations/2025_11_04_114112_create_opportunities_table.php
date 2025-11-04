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
    Schema::create('opportunities', function (Blueprint $table) {
        $table->id();
        $table->foreignId('organization_id')->constrained()->cascadeOnDelete();

        $table->string('title');
        $table->text('description');
        $table->text('requirements')->nullable();
        $table->string('type')->nullable(); // internship, volunteering, training
        $table->date('start_date')->nullable();
        $table->date('end_date')->nullable();
        $table->date('deadline')->nullable();
        $table->integer('duration_weeks')->nullable();
        $table->integer('available_slots')->default(1);
        $table->boolean('approved')->default(false); // verified by admin

        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('opportunities');
}
};