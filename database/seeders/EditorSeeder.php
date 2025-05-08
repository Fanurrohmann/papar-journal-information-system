<?php

namespace Database\Seeders;

use App\Models\Editor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EditorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $editors = [
            [
                'name' => 'Editor Satu',
                'email' => 'editor1@example.com',
                'password' => Hash::make('12345'),
            ],
            [
                'name' => 'Editor Dua',
                'email' => 'editor2@example.com',
                'password' => Hash::make('12345'),
            ],
            [
                'name' => 'Editor Tiga',
                'email' => 'editor3@example.com',
                'password' => Hash::make('12345'),
            ],
        ];

        foreach ($editors as $editor) {
            Editor::create($editor);
        }
    }
}
