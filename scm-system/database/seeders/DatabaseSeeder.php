<?php

namespace Database\Seeders;

// database/seeders/DatabaseSeeder.php

use Database\Seeders\RoleSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class, // <-- এটি যোগ করুন
            // ...অন্যান্য সিডার যদি থাকে
        ]);
    }
}