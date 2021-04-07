<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert($this->getData());
    }

    private function getData():array
    {
        $data = [];
        $data[] = [
            'name' => 'Admin',
            'email' => 'nantonov@mail.ru',
            'password' => Hash::make('temp12345'),
            'is_admin' => true,
            'created_at' => now(),
            'updated_at' => now()
        ];

        return $data;
    }
}
