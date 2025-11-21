<?php

use App\Models\Hotel;
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
        Schema::create('hotel_pictures', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Hotel::class)->constrained()->onDelete('cascade');
            $table->string('filepath');
            $table->integer('filesize')->unsigned();
            $table->integer('position');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotel_pictures');
    }
};
