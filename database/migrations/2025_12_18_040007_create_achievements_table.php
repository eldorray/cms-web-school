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
        Schema::create('achievements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->enum('type', ['akademik', 'non_akademik', 'sekolah'])->default('akademik');
            $table->enum('level', ['sekolah', 'kecamatan', 'kota', 'provinsi', 'nasional', 'internasional'])->default('kota');
            $table->string('rank')->nullable();
            $table->string('participant_name')->nullable();
            $table->string('participant_class')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->date('achievement_date')->nullable();
            $table->year('year');
            $table->boolean('is_published')->default(true);
            $table->timestamps();

            $table->index(['school_id', 'year', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('achievements');
    }
};
