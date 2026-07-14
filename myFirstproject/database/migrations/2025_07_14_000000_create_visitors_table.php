<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visitors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->string('person_to_visit');
            $table->string('purpose');
            $table->date('visit_date');
            $table->dateTime('time_in');
            $table->dateTime('time_out')->nullable();
            $table->timestamps();

            $table->index('visit_date');
            $table->index('name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visitors');
    }
};