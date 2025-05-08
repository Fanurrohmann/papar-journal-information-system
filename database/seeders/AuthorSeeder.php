<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $authors = [
            [
                'name' => 'Penulis Satu',
                'email' => 'penulis1@example.com',
                'password' => Hash::make('12345'),
            ],
            [
                'name' => 'Penulis Dua',
                'email' => 'penulis2@example.com',
                'password' => Hash::make('12345'),
            ],
            [
                'name' => 'Penulis Tiga',
                'email' => 'penulis3@example.com',
                'password' => Hash::make('12345'),
            ],
            [
                'name' => 'Penulis Empat',
                'email' => 'penulis4@example.com',
                'password' => Hash::make('12345'),
            ],
            [
                'name' => 'Penulis Lima',
                'email' => 'penulis5@example.com',
                'password' => Hash::make('12345'),
            ],
        ];

        foreach ($authors as $author) {
            Author::create($author);
        }
    }
}
