<?php
namespace Database\Seeders; 

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            ['name' => 'Admin', 'slug' => 'admin', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Depo', 'slug' => 'depo', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Distributor', 'slug' => 'distributor', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}