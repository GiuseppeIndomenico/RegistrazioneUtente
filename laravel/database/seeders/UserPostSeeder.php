<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\Hash;

class UserPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Creazione di 3 utenti
        $users = [
            [
                'name' => 'Mario Rossi',
                'email' => 'mario@example.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Luca Bianchi',
                'email' => 'luca@example.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Giulia Verdi',
                'email' => 'giulia@example.com',
                'password' => Hash::make('password'),
            ]
        ];

        // Ciclo per creare utenti e associarli ai post
        foreach ($users as $userData) {
            $user = User::create($userData);

            // Creiamo 2 post per ogni utente
            Post::create([
                'user_id' => $user->id,
                'title' => 'Primo post di ' . $user->name,
                'content' => 'Questo è il contenuto del primo post di ' . $user->name,
            ]);

            Post::create([
                'user_id' => $user->id,
                'title' => 'Secondo post di ' . $user->name,
                'content' => 'Questo è il contenuto del secondo post di ' . $user->name,
            ]);
        }
    }
}
