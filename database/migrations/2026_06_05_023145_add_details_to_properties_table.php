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
        Schema::table('properties', function (Blueprint $table) {
            $table->text('description')->nullable();
            $table->integer('bedrooms')->nullable();
            $table->integer('bathrooms')->nullable();
            $table->integer('area')->nullable(); // Luas (m2)
            $table->integer('floors')->nullable(); // Jumlah lantai
            $table->string('garage')->nullable(); // Garasi
            $table->integer('year_built')->nullable(); // Tahun bangun
            $table->string('certificate')->nullable(); // Sertifikat
            $table->integer('electricity')->nullable(); // Daya listrik (Watt)
            $table->string('water_source')->nullable(); // Sumber air
            $table->text('facilities')->nullable(); // Fasilitas (JSON array)
            $table->text('images')->nullable(); // Kumpulan foto URL tambahan (JSON array)
            $table->integer('views')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn([
                'description', 'bedrooms', 'bathrooms', 'area', 'floors', 
                'garage', 'year_built', 'certificate', 'electricity', 
                'water_source', 'facilities', 'images', 'views'
            ]);
        });
    }
};
