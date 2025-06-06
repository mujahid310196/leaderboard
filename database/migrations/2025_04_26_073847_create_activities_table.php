<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->dateTime('performed_at');   // Time and date of activity
            $table->integer('points')->default(20);  // Always 20
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
