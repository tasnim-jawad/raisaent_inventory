<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     php artisan migrate --path='\App\Modules\Management\AccountManagement\AccountExpense\Database\create_account_expenses_logs_table.php'
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('account_expense_logs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('account_expense_id')->nullable();
            $table->bigInteger('account_income_id')->nullable();
            $table->bigInteger('account_category_id')->nullable();
            $table->enum('type', ['income','expense'])->nullable();
            $table->string('title', 100)->nullable();
            $table->bigInteger('amount')->nullable();
            $table->text('description')->nullable();
            $table->json('details')->nullable();

            $table->bigInteger('creator')->unsigned()->nullable();
            $table->string('slug', 150)->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_expenses_logs');
    }
};
