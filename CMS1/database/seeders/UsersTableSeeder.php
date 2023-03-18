<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        User::create([
            'name' => 'Admin Admin',
            'email' => 'admin@gmail.com',
            //'email_verified_at' => now(),
            'password' => Hash::make('admin123'),
            'ci' => '9795858',
            'telefono' => '65949863',
            'created_at' => now(),
            'updated_at' => now()
        ])->assignRole('Admin');    
    }
}
