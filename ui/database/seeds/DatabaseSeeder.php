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
        DB::table('roles')->insert([
            ['name' => 'Administrateur'],
            ['name' => 'Préposé aux clients résidentiels'],
            ['name' => 'Préposé aux clients d\'affaires']
        ]);

        DB::table('pages')->insert([
            ['uri' => '/clients/residential'],
            ['uri' => '/clients/business'],
            ['uri' => '/security']
        ]);

        DB::table('access')->insert([
            ['id_role' => 1, 'id_page' => 1],
            ['id_role' => 1, 'id_page' => 2],
            ['id_role' => 1, 'id_page' => 3],
            ['id_role' => 2, 'id_page' => 2],
            ['id_role' => 3, 'id_page' => 3],
        ]);

        DB::table('users')->insert([
           [
               'username' => 'Administrateur', 'email' => 'twotimesagnew@gmail.com', 'salt' => $alt = hash('sha256', 'banana'),
               'password' => hash('sha256', "123456$alt"), 'role' => 1, 'created_at' => date('Y-m-d H:i:s'),
               'hash_version' => 'sha256'
           ],
           [
               'username' => 'Utilisateur1', 'email' => 'twotimesagnew@gmail.com', 'salt' => $alt = hash('sha256', 'mango'),
               'password' => hash('sha256', "qwerty$alt"), 'role' => 2, 'created_at' => date('Y-m-d H:i:s'),
               'hash_version' => 'sha256'
           ],
           [
               'username' => "Utilisateur2", 'email' => 'twotimesagnew@gmail.com', 'salt' => $alt = hash('sha256', 'pineapple'),
               'password' => hash('sha256', "asdfgh$alt"), 'role' => 3, 'created_at' => date('Y-m-d H:i:s'),
               'hash_version' => 'sha256'
           ]
        ]);

        DB::table('settings')->insert([
            'pass_attempts' => 5,
            'pass_attempts_delay' => 10,
            'pass_struct' => '',
            '2fa' => false
        ]);
    }
}
