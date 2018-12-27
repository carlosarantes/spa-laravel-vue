<?php

use App\User;
use Illuminate\Database\Seeder;

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
        	'name'  => 'Carlos Augusto',
            'email' => 'admin@sysvendas.com',
            'type'  => 'admin',
        	'password' => bcrypt('10203040')
        ]);

        User::create([
        	'name'  => 'Funcionario 1',
            'email' => 'funcionario@gmail.com',
            'type'  => 'comum',
        	'password' => bcrypt('10203040')
        ]);
    }
}
