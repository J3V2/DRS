<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('drs_documents', function (Blueprint $table) {
            DB::statement('ALTER TABLE drs_documents MODIFY file_attach LONGBLOB');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            DB::statement('ALTER TABLE documents MODIFY file_attach LONGBLOB');
        });
    }
};
