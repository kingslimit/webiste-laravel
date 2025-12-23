<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 30 fake users for testing
        $users = [
            ['name' => 'Admin User', 'email' => 'admin@openlibrary.com'],
            ['name' => 'John Doe', 'email' => 'john@example.com'],
            ['name' => 'Jane Smith', 'email' => 'jane@example.com'],
            ['name' => 'Michael Johnson', 'email' => 'michael@example.com'],
            ['name' => 'Sarah Williams', 'email' => 'sarah@example.com'],
            ['name' => 'David Brown', 'email' => 'david@example.com'],
            ['name' => 'Emily Davis', 'email' => 'emily@example.com'],
            ['name' => 'Daniel Wilson', 'email' => 'daniel@example.com'],
            ['name' => 'Olivia Martinez', 'email' => 'olivia@example.com'],
            ['name' => 'James Anderson', 'email' => 'james@example.com'],
            ['name' => 'Sophia Taylor', 'email' => 'sophia@example.com'],
            ['name' => 'William Thomas', 'email' => 'william@example.com'],
            ['name' => 'Isabella Garcia', 'email' => 'isabella@example.com'],
            ['name' => 'Robert Lee', 'email' => 'robert@example.com'],
            ['name' => 'Mia Rodriguez', 'email' => 'mia@example.com'],
            ['name' => 'Christopher White', 'email' => 'chris@example.com'],
            ['name' => 'Charlotte Harris', 'email' => 'charlotte@example.com'],
            ['name' => 'Matthew Clark', 'email' => 'matthew@example.com'],
            ['name' => 'Amelia Lewis', 'email' => 'amelia@example.com'],
            ['name' => 'Andrew Walker', 'email' => 'andrew@example.com'],
            ['name' => 'Harper Hall', 'email' => 'harper@example.com'],
            ['name' => 'Joshua Allen', 'email' => 'joshua@example.com'],
            ['name' => 'Evelyn Young', 'email' => 'evelyn@example.com'],
            ['name' => 'Ryan King', 'email' => 'ryan@example.com'],
            ['name' => 'Abigail Wright', 'email' => 'abigail@example.com'],
            ['name' => 'Nathan Scott', 'email' => 'nathan@example.com'],
            ['name' => 'Ella Green', 'email' => 'ella@example.com'],
            ['name' => 'Brandon Adams', 'email' => 'brandon@example.com'],
            ['name' => 'Chloe Baker', 'email' => 'chloe@example.com'],
            ['name' => 'Tyler Nelson', 'email' => 'tyler@example.com'],
        ];

        foreach ($users as $userData) {
            User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => Hash::make('password123'), // Password sama untuk semua: password123
            ]);
        }

        $this->command->info('✅ 30 fake users created successfully!');
        $this->command->info('📧 Email: admin@openlibrary.com | Password: password123');
        $this->command->info('📧 All users password: password123');
    }
}