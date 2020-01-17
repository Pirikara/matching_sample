<?php

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
        //
        DB::table('users')->insert([
            ['name' => 'Alice',
            'email' => 'c@example.com',
            'sex' => '0',
            'self_introduction' => '初めまして、Aliceです',
            'img_name' => 'sample001.jpg',
            'password' => bcrypt('1111aaaa'),
            ],
            ['name' => 'Barry',
            'email' => 'd@example.com',
            'sex' => '1',
            'self_introduction' => '初めまして、Barryです',
            'img_name' => 'sample002.jpg',
            'password' => bcrypt('1111aaaa'),
            ],
            ['name' => 'Cameron',
            'email' => 'e@example.com',
            'sex' => '0',
            'self_introduction' => '初めまして、Cameronです',
            'img_name' => 'sample003.jpg',
            'password' => bcrypt('1111aaaa'),
            ],
            ['name' => 'Daniel',
            'email' => 'f@example.com',
            'sex' => '0',
            'self_introduction' => '初めまして、Danielです',
            'img_name' => 'sample004.jpg',
            'password' => bcrypt('1111aaaa'),
            ],
        ]);
    }
}
