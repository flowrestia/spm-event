<?php
// database/seeders/AdminSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::updateOrCreate(
            ['email' => 'admin@gibei-polinema.ac.id'],
            [
                'email'    => 'admin@gibei-polinema.ac.id',
                'password' => Hash::make('Admin@2026!'),
            ]
        );

        $this->command->info('Admin user created:');
        $this->command->info('  Email   : admin@gibei-polinema.ac.id');
        $this->command->info('  Password: Admin@2026!');
    }
}
