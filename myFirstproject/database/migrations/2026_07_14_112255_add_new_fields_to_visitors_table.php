<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('visitors', function (Blueprint $table) {
            // Idadagdag natin ang mga bagong column
            $table->string('contact_no')->nullable()->after('name');
            $table->string('id_type')->nullable()->after('address');
            $table->string('id_number')->nullable()->after('id_type');
            $table->string('status')->default('Checked In')->after('time_out');
        });
    }

    public function down(): void
    {
        Schema::table('visitors', function (Blueprint $table) {
            // Tatanggalin natin ang mga ito kapag nag-rollback
            $table->dropColumn(['contact_no', 'id_type', 'id_number', 'status']);
        });
    }
};