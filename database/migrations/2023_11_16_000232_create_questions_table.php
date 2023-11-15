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
        Schema::create('questions', function (Blueprint $table) {
            $table->string('id', 40)->primary()->index();
            $table->string('questions');
            $table->string('topic_id', 50);
            $table->string('option_a', 50);
            $table->string('option_b', 50);
            $table->string('option_c', 50);
            $table->string('option_d', 50);
            $table->string('option_e', 50);
            $table->string('answer', 30);
            $table->string('created_by', 40);
            $table->string('updated_by', 40);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
