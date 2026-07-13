<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('donor_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('incident_id')->nullable()->constrained()->onDelete('set null');
            $table->string('title');
            $table->text('description');
            $table->enum('category', ['food', 'water', 'medicine', 'clothing', 'shelter_materials', 'hygiene', 'other']);
            $table->integer('quantity');
            $table->string('unit')->default('pieces');
            $table->enum('status', ['pledged', 'collected', 'delivered'])->default('pledged');
            $table->string('pickup_location')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

   
        Schema::create('volunteer_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('incident_id')->constrained()->onDelete('cascade');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->enum('category', ['search_rescue', 'medical_aid', 'food_distribution', 'shelter_setup', 'logistics', 'other']);
            $table->enum('status', ['open', 'in_progress', 'completed'])->default('open');
            $table->integer('volunteers_needed')->default(1);
            $table->integer('volunteers_assigned')->default(0);
            $table->string('location_name')->nullable();
            $table->timestamps();
        });

  
        Schema::create('volunteer_task_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('volunteer_task_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['assigned', 'completed'])->default('assigned');
            $table->timestamp('assigned_at')->useCurrent();
            $table->timestamps();
            $table->unique(['volunteer_task_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('volunteer_task_assignments');
        Schema::dropIfExists('volunteer_tasks');
        Schema::dropIfExists('donations');
    }
};
