<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('bookings', function (Blueprint $table) {
        $table->string('medicine_needed')->nullable()->after('service_type');
        $table->string('injection_status')->nullable()->after('medicine_needed');
        $table->decimal('payment_amount', 10, 2)->nullable()->after('check_out_date');
        $table->string('payment_status')->nullable()->after('payment_amount');
    });
}

    /**
     * Reverse the migrations.
     */
   public function down()
{
    Schema::table('bookings', function (Blueprint $table) {
        $table->dropColumn([
            'medicine_needed',
            'injection_status',
            'payment_amount',
            'payment_status',
        ]);
    });
}
};
