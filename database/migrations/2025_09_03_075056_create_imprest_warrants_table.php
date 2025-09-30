<?php

use App\Enums\WarrantStatus;
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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique()->nullable();
            $table->string('name');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->decimal('balance', 15, 2)->default(0);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->string('staff_number')->unique()->nullable();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('projects', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('code')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('warrants', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('doc_number')->unique();

            // Relationships
            $table->foreignId('staff_id')->constrained()->cascadeOnDelete();
            $table->foreignId('account_id')->constrained()->cascadeOnDelete();
            $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignUuid('project_id')->nullable()->constrained()->nullOnDelete();

            // Workflow Users
            $table->foreignId('prepared_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('checked_by')->nullable();
            $table->string('approved_by')->nullable();
            $table->string('signed_by')->nullable();

            // Financials
            $table->decimal('amount', 15, 2);
            $table->string('purpose')->nullable();
            $table->text('remarks')->nullable();

            // Bank / Payment
            $table->string('payee_bank')->nullable();
            $table->string('payee_account_number')->nullable();
            $table->string('paying_bank')->nullable();
            $table->string('cheque_number')->nullable();
            $table->string('memo_number')->nullable();
            $table->date('payment_date')->nullable();
            $table->date('signed_date')->nullable();

            // Status
            $table->string('status')->default(WarrantStatus::DRAFT->value);
            $table->text('status_remarks')->nullable();

            // Audit trail
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('warrant_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('warrant_id')->constrained()->cascadeOnDelete();
            $table->string('action');
            $table->text('description')->nullable();
            $table->json('changes')->nullable();
            $table->foreignId('performed_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('surrenders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('warrant_id')->constrained()->cascadeOnDelete();
            $table->string('doc_code')->unique();
            $table->unsignedInteger('sequence_number')->unique();
            $table->decimal('imprest_amount', 15, 2);
            $table->decimal('actual_spent', 15, 2)->nullable();
            // particulars
            $table->string('examination_by');
            $table->string('approved_by');
            $table->string('authorized_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surrenders');
        Schema::dropIfExists('warrant_logs');
        Schema::dropIfExists('warrants');
        Schema::dropIfExists('projects');
        Schema::dropIfExists('staff');
        Schema::dropIfExists('departments');
        Schema::dropIfExists('accounts');
    }
};
