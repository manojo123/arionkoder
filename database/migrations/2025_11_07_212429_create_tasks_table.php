<?php

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
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
            $table->string('title')->index();
            $table->text('description')->nullable();
            $table->string('priority')->default(TaskPriority::Low->value)->comment('TaskPriority Enum values')->index();
            $table->string('status')->default(TaskStatus::Backlog->value)->comment('TaskStatus Enum values')->index();
            $table->date('due_date')->nullable()->index();
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
