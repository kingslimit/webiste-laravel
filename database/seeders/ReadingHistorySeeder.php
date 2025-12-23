<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\ReadingHistory;
use Carbon\Carbon;

class ReadingHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Popular books from Internet Archive
        $books = [
            [
                'id' => 'atomichabits_202011',
                'title' => 'Atomic Habits',
                'author' => 'James Clear'
            ],
            [
                'id' => 'sapiens_brief_history_humankind',
                'title' => 'Sapiens: A Brief History of Humankind',
                'author' => 'Yuval Noah Harari'
            ],
            [
                'id' => 'nineteeneightyfour00orwe',
                'title' => '1984',
                'author' => 'George Orwell'
            ],
            [
                'id' => 'greatgatsby00fitz',
                'title' => 'The Great Gatsby',
                'author' => 'F. Scott Fitzgerald'
            ],
            [
                'id' => 'prideandprejudice',
                'title' => 'Pride and Prejudice',
                'author' => 'Jane Austen'
            ],
            [
                'id' => 'tokillamockingbir00lee',
                'title' => 'To Kill a Mockingbird',
                'author' => 'Harper Lee'
            ],
            [
                'id' => 'educated_memoir',
                'title' => 'Educated: A Memoir',
                'author' => 'Tara Westover'
            ],
            [
                'id' => 'becoming_michelle_obama',
                'title' => 'Becoming',
                'author' => 'Michelle Obama'
            ],
            [
                'id' => 'alchemist00coel',
                'title' => 'The Alchemist',
                'author' => 'Paulo Coelho'
            ],
            [
                'id' => 'harrypotterstone00rowl',
                'title' => 'Harry Potter and the Philosopher\'s Stone',
                'author' => 'J.K. Rowling'
            ],
            [
                'id' => 'thinkingfastands00dahn',
                'title' => 'Thinking, Fast and Slow',
                'author' => 'Daniel Kahneman'
            ],
            [
                'id' => 'subtle_art_not_giving',
                'title' => 'The Subtle Art of Not Giving a F*ck',
                'author' => 'Mark Manson'
            ],
            [
                'id' => 'animal_farm_orwell',
                'title' => 'Animal Farm',
                'author' => 'George Orwell'
            ],
            [
                'id' => 'brave_new_world',
                'title' => 'Brave New World',
                'author' => 'Aldous Huxley'
            ],
            [
                'id' => 'lord_of_the_flies',
                'title' => 'Lord of the Flies',
                'author' => 'William Golding'
            ],
        ];

        $users = User::all();

        if ($users->isEmpty()) {
            $this->command->error('❌ No users found! Please run UserSeeder first.');
            return;
        }

        $this->command->info('🤖 Generating reading history...');

        // Generate 400 reading history records
        $totalRecords = 400;
        $progressBar = $this->command->getOutput()->createProgressBar($totalRecords);

        for ($i = 0; $i < $totalRecords; $i++) {
            $book = $books[array_rand($books)];
            $user = $users->random();

            // Distribusi waktu:
            // 30% - Last 7 days (trending minggu ini)
            // 40% - Last 30 days (trending bulan ini)
            // 30% - Last 365 days (trending tahun ini)

            $randomValue = rand(1, 100);

            if ($randomValue <= 30) {
                // Last 7 days
                $daysAgo = rand(0, 7);
            } elseif ($randomValue <= 70) {
                // Last 30 days
                $daysAgo = rand(8, 30);
            } else {
                // Last 365 days
                $daysAgo = rand(31, 365);
            }

            $randomHours = rand(0, 23);
            $randomMinutes = rand(0, 59);

            ReadingHistory::create([
                'user_id' => $user->id,
                'book_identifier' => $book['id'],
                'book_title' => $book['title'],
                'book_author' => $book['author'],
                'book_cover' => "https://archive.org/services/img/{$book['id']}",
                'action_type' => rand(1, 10) <= 8 ? 'viewed' : 'downloaded', // 80% viewed, 20% downloaded
                'accessed_at' => Carbon::now()
                    ->subDays($daysAgo)
                    ->subHours($randomHours)
                    ->subMinutes($randomMinutes),
            ]);

            $progressBar->advance();
        }

        $progressBar->finish();
        $this->command->newLine();
        $this->command->info('✅ 400 reading history records created successfully!');
        $this->command->info('📊 Distribution: 30% this week, 40% this month, 30% this year');
    }
}