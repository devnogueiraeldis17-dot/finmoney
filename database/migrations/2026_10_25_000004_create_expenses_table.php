<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('launch_id')->constrained('launches')->restrictOnDelete();
            $table->foreignId('category_id')->constrained('categories')->restrictOnDelete();
            $table->string('name', 180);
            $table->text('description')->nullable();
            $table->decimal('value', 12, 2);
            $table->unsignedSmallInteger('installments')->default(1);
            $table->unsignedSmallInteger('installment_number')->default(1);
            $table->uuid('installment_group')->nullable();
            $table->date('due_date');
            $table->timestamps();
            $table->index(['user_id', 'due_date']);
            $table->index('installment_group');
        });
    }

    public function down(): void { Schema::dropIfExists('expenses'); }
};
