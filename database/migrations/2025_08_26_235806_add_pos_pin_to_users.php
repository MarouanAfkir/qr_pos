<?php

// database/migrations/2025_01_01_000001_add_pos_pin_to_users.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('pos_code', 32)->nullable()->unique()->after('email');
            $table->string('pos_pin')->nullable()->after('pos_code'); // hashed
        });
        // tinker or seeder
        //create a user with pos_code and pos_pin
        $user = new \App\Models\User();
        $user->name = 'Cashier 1';
        $user->email = 'cash@gmail.com';
        $user->password = \Illuminate\Support\Facades\Hash::make('password');
        $user->pos_code = 'CASHIER1';
        $user->pos_pin  = \Illuminate\Support\Facades\Hash::make('1234');
        $user->save();
    }
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['pos_code', 'pos_pin']);
        });
    }
};
