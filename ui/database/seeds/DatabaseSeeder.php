<?php

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
        DB::table('role')->insert([
            ['name' => 'Administrateur'],
            ['name' => 'Préposé aux clients résidentiels'],
            ['name' => 'Préposé aux clients d\'affaires']
        ]);

        DB::table('users')->insert([
           [
               'username' => 'Administrateur', 'email' => 'admin1@sobersec.com', 'salt' => $alt = hash('sha256', 'banana'),
               'password' => hash('sha256', "123456$alt"), 'role' => 1, 'created_at' => date('Y-m-d H:i:s'),
               'hash_version' => 'sha256'
           ],
           [
               'username' => 'Utilisateur1', 'email' => 'user1@sobersec.com', 'salt' => $alt = hash('sha256', 'mango'),
               'password' => hash('sha256', "qwerty$alt"), 'role' => 2, 'created_at' => date('Y-m-d H:i:s'),
               'hash_version' => 'sha256'
           ],
           [
               'username' => "Utilisateur2", 'email' => 'user2@sobersec.com', 'salt' => $alt = hash('sha256', 'pineapple'),
               'password' => hash('sha256', "asdfgh$alt"), 'role' => 3, 'created_at' => date('Y-m-d H:i:s'),
               'hash_version' => 'sha256'
           ]
        ]);

        DB::table('settings')->insert([
            'pass_attempts' => 5,
            'pass_attempts_delay' => 10,
        ]);
        $table->integer('pass_attempts');
        $table->integer('pass_attempts_delay');
        $table->string('pass_struct');
    }
}
