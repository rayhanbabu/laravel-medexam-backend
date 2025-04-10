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
        Schema::create('options', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('question_id');
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
            $table->string('option')->comment('The text of the option');
            $table->boolean('is_correct')->default(false)->comment('Indicates if this option is the correct answer');
            $table->integer('serial')->nullable()->comment('Optional serial number for ordering options');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->integer('status')->comment('0 = Inactive, 1 = Active'); // Adjust based on your enum/status logic
            $table->text('description')->nullable()->comment('Optional description or additional information about the option');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('options');
    }
};
