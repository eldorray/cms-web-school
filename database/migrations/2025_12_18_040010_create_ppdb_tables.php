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
        Schema::create('ppdb_periods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('academic_year');
            $table->date('start_date');
            $table->date('end_date');
            $table->text('requirements')->nullable();
            $table->text('description')->nullable();
            $table->integer('quota')->nullable();
            $table->boolean('is_active')->default(false);
            $table->timestamps();

            $table->index(['school_id', 'is_active']);
        });

        Schema::create('ppdb_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->cascadeOnDelete();
            $table->foreignId('ppdb_period_id')->constrained()->cascadeOnDelete();
            $table->string('registration_number')->unique();
            $table->string('student_name');
            $table->string('nisn')->nullable();
            $table->date('birth_date');
            $table->string('birth_place');
            $table->enum('gender', ['L', 'P']);
            $table->string('religion')->nullable();
            $table->text('address');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('previous_school')->nullable();
            $table->string('parent_name');
            $table->string('parent_phone');
            $table->string('parent_email')->nullable();
            $table->string('parent_occupation')->nullable();
            $table->text('parent_address')->nullable();
            $table->json('documents')->nullable();
            $table->enum('status', ['pending', 'verified', 'accepted', 'rejected', 'enrolled'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();

            $table->index(['school_id', 'ppdb_period_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ppdb_registrations');
        Schema::dropIfExists('ppdb_periods');
    }
};
