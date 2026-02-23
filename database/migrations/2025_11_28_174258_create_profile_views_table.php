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
        Schema::create('profile_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('umkm_profile_id')->constrained()->onDelete('cascade');
            $table->string('ip_address', 45);
            $table->date('viewed_date');
            $table->timestamps();

            $table->unique(['umkm_profile_id', 'ip_address', 'viewed_date']);
            $table->index(['umkm_profile_id', 'viewed_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile_views');
    }
};
