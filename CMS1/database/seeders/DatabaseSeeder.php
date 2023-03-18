<?php
namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([CategoriaSeeder::class]);
        $this->call([RoleSeeder::class]);
        $this->call([UsersTableSeeder::class]);
        $this->call([ProductsTableSeeder::class]);
    }
}
