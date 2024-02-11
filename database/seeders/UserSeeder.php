<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Samet ALTUNDAĞ',
            'email' => 'smt@gmail.com',
            'password' => bcrypt('123456')
        ]);

        User::create([
            'name' => 'Anibal Bilişim',
            'email' => 'anibal@bilisim.com',
            'password' => bcrypt('123456')
        ]);
    }
}
