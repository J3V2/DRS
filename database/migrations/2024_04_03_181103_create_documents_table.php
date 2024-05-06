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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_number'); // refer to the generate tracking number by the user itself
            $table->string('title');
            $table->string('type');
            $table->string('status'); // available, pending, received, released and terminal
            $table->string('action');
            $table->string('author'); // refer to the user who create the document
            $table->string('originating_office'); // refer to the users office
            $table->string('current_office'); // refer to current office that handle that document
            $table->string('designated_office'); // refer to designated office of the document
            $table->binary('file_attach'); // refer to file attachment
            $table->string('drive'); // refer to onedrive links
            $table->mediumText('remarks'); // refer to remarks of user of the documents
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
