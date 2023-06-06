<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class CreateUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
                ['name'=>'staff',
                'email' => 'staff@gmailcom',
                'password' => bcrypt('123456'),
                'role' => 0
                ],
                ['name'=>'student',
                'email' => 'student@gmail.com',
                'password' => bcrypt('123456'),
                'role' => 1
                ],
                ['name'=>'Admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('123456'),
                'role' => 2
                ]
        ];
        foreach($users as $user)
        {
            User::create($user);
        }
    }
}
