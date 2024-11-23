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
        Schema::create('logAktivitas', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('UserID'); // Make this unsigned to match the 'users' table
            $table->string('aksi');
            $table->text('detail')->nullable();
            $table->softDeletes();
            $table->timestamps();
            // Define the foreign key relationship
            $table->foreign('UserID')
                ->references('UserID')
                ->on('users')
                ->onDelete('cascade');
        });
    }
    // BEGIN
    // INSERT INTO `log_aktivitas`(`UserID`, `aksi`, `detail` `created_at`) VALUES (P_UserID,P_title,P_deskrip,P_created_at)
    // END
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_aktivitas');
    }
};
