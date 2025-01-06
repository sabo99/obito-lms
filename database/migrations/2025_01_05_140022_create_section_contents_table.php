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
        Schema::create('section_contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_section_id')->constrained('course_sections')->cascadeOnDelete();
            $table->string('name');
            $table->text('content');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('section_contents');
    }
};
