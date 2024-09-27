<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('rut')->nullable();
            $table->string('nombre');
            $table->string('apellido');
            $table->string('email')->unique();  // Email (username), debe ser @ventasfix.cl
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->boolean('activo')->default(false);
        });

        DB::table('users')->insert([
            [
                'nombre' => 'Mario',
                'apellido' => 'Quevedo',
                'email' => 'mbdev@ventasfix.cl',
                'password' => Hash::make('password'),
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
