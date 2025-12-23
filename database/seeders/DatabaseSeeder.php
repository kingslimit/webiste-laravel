<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('🌱 Starting database seeding...');
        $this->command->newLine();

        $this->call([
            UserSeeder::class,
            ReadingHistorySeeder::class,
        ]);

        $this->command->newLine();
        $this->command->info('🎉 Database seeding completed!');
        $this->command->newLine();
        $this->command->info('📝 Summary:');
        $this->command->info('   - 30 fake users created');
        $this->command->info('   - 400 reading history records created');
        $this->command->newLine();
        $this->command->info('🔑 Test Login:');
        $this->command->info('   Email: admin@openlibrary.com');
        $this->command->info('   Password: password123');
        $this->command->newLine();
        $this->command->info('💡 Tip: All users have password "password123"');
    }
}