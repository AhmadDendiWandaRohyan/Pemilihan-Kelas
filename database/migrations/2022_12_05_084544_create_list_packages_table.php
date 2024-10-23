<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('list_packages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description')->nullable();
            $table->string('package_number');
            $table->date('date_open');
            $table->date('date_expired');
            $table->time('time_open');
            $table->string('status')->default('1');
            $table->string('maximum')->nullable();
            $table->string('nilai_mtk')->nullable();
            $table->string('nilai_fisika')->nullable();
            $table->string('nilai_kimia')->nullable();
            $table->string('nilai_biologi')->nullable();
            $table->string('nilai_sosiologi')->nullable();
            $table->string('nilai_ekonomi')->nullable();
            $table->string('nilai_sejarah')->nullable();
            $table->string('nilai_geografi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('list_packages');
    }
};