<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     php artisan migrate --path='\App\Modules\Management\UserManagement\User\Database\create_users_table.php'
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 30)->nullable();
            $table->string('email', 50)->nullable();
            $table->string('password', 100)->nullable();
            $table->string('phone_number', 50)->nullable();
            $table->string('image', 100)->nullable();
            $table->string('present_address')->nullable();
            $table->string('permanent_address')->nullable();
            $table->string('designation')->nullable();
            $table->string('remember_token')->nullable();
            $table->integer('role_id')->nullable();
            $table->string('password_in_text', 50)->nullable();
            $table->string('join_date')->nullable();
            $table->bigInteger('salery')->nullable();
            $table->string('can_login')->default(1);
            $table->string('nid')->nullable();
            $table->text('comment')->nullable();
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
        Schema::dropIfExists('users');
    }
};
