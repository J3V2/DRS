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
        Schema::create('drs_documents', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_number'); // Refer to the generated tracking number by the user itself
            $table->string('title');
            $table->string('type');
            $table->string('status'); // pending, received, released, and terminal
            $table->string('action');
            $table->string('author'); // Refer to the user who created the document
            $table->string('originating_office'); // Refer to the user's office
            $table->string('current_office'); // Refer to the current office that handles the document
            $table->string('designated_office'); // Refer to the designated office of the document
            $table->binary('file_attach')->nullable(); // Refer to file attachment
            $table->string('drive')->nullable(); // Refer to OneDrive links
            $table->mediumText('remarks')->nullable(); // Refer to remarks of the user of the documents
            $table->unsignedBigInteger('received_by')->nullable(); // Refer to the user who received the document
            $table->unsignedBigInteger('released_by')->nullable(); // Refer to the user who released the document
            $table->unsignedBigInteger('terminal_by')->nullable(); // Refer to the user who marked the document as terminal
            $table->timestamps();

            // Adding foreign key constraints
            $table->foreign('received_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('released_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('terminal_by')->references('id')->on('users')->onDelete('set null');
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
