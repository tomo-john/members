<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sandboxes', function (Blueprint $table) {
            $table->renameColumn('is_active', 'is_good_boy');
            $table->renameColumn('scheduled_at', 'birthday');
        });
    }

    public function down(): void
    {
        Schema::table('sandboxes', function (Blueprint $table) {
            $table->renameColumn('is_good_boy', 'is_active');
            $table->renameColumn('birthday', 'scheduled_at');
        });
    }
};
