<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     php artisan migrate --path='/app/Modules/Management/AccountManagement/AccountExpense/Database/create_account_expenses_table.php'
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('account_expenses', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('account_category_id')->nullable();
            $table->string('title', 100)->nullable();
            $table->bigInteger('amount')->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('is_approved')->default(0);
            $table->enum('user_type', ['admin', 'employee'])->nullable();
            $table->tinyInteger('is_seen')->default(0);
            $table->bigInteger('customer_id')->nullable();
            $table->date('date')->nullable();
            $table->string('document')->nullable();
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
        Schema::dropIfExists('account_expenses');
    }
};
