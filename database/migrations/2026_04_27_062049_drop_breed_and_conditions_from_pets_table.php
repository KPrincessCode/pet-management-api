<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pets', function (Blueprint $table) {
            if (Schema::hasColumn('pets', 'breed')) {
                $table->dropColumn('breed');
            }

            if (Schema::hasColumn('pets', 'conditions')) {
                $table->dropColumn('conditions');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pets', function (Blueprint $table) {
            $table->string('breed')->nullable();
            $table->text('conditions')->nullable();
        });
    }
};