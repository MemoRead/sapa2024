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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students');
            $table->date('absence_date');
            $table->string('absence_location');
            $table->boolean('is_holiday')->default(false)->nullable();
            $table->enum('absence_type', ['attendance_in', 'attendance_out'])->nullable();
            $table->time('attendance_in')->nullable();
            $table->time('attendance_out')->nullable();
            $table->enum('attendance', ['attendance', 'permission', 'sick']);
            $table->longText('proof_of_attendance')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
