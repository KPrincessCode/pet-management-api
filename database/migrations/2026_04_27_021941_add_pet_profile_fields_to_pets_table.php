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
    Schema::table('pets', function (Blueprint $table) {
        $table->string('breed')->nullable()->after('type');
        $table->string('gender')->nullable()->after('age');
        $table->decimal('weight', 8, 2)->nullable()->after('gender');
        $table->string('medicine_needed')->nullable()->after('weight');
        $table->string('injection_status')->nullable()->after('medicine_needed');
        $table->text('conditions')->nullable()->after('injection_status');
    });
}

public function down(): void
{
    Schema::table('pets', function (Blueprint $table) {
        $table->dropColumn([
            'breed',
            'gender',
            'weight',
            'medicine_needed',
            'injection_status',
            'conditions'
        ]);
    });
}
};
