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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('task_id')->nullable()->constrained('tasks');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('priority')->default('low')->comment('Low, Medium, High, Critical');
            $table->string('status')->default('pending')->comment('Backlog, To Do, In Progress, Review, Done, Blocked');
            $table->date('due_date')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('modified_by')->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
