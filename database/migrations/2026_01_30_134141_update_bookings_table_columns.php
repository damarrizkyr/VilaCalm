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
        //
        Schema::table('bookings', function (Blueprint $table) {
            $table->renameColumn('start_date', 'check_in');
            $table->renameColumn('end_date', 'check_out');

            $table->integer('guest_count')->after('total_price')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('bookings', function (Blueprint $table) {
            $table->renameColumn('check_in', 'start_date');
            $table->renameColumn('check_out', 'end_date');
            $table->dropColumn('guest_count');
        });
    }
};
