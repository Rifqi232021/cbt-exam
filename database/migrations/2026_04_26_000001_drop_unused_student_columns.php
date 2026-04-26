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
        if (Schema::hasColumn('students', 'email') || Schema::hasColumn('students', 'student_id')) {
            Schema::table('students', function (Blueprint $table) {
                if (Schema::hasColumn('students', 'email')) {
                    $table->dropColumn('email');
                }
                if (Schema::hasColumn('students', 'student_id')) {
                    $table->dropColumn('student_id');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            if (!Schema::hasColumn('students', 'email')) {
                $table->string('email')->unique()->nullable();
            }
            if (!Schema::hasColumn('students', 'student_id')) {
                $table->string('student_id')->unique()->nullable();
            }
        });
    }
};
