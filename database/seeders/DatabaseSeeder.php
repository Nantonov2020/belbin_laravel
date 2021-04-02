<?php

namespace Database\Seeders;

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
        $this->call([
            AdminSeeder::class,
            CompaniesSeeder::class,
            DepartmentsSeeder::class,
            UsersSeeder::class,
            WorkersSeeder::class,
            HRWorkersSeeder::class,
            QuestionnairesSeeder::class,
            TestUnitsSeeder::class
        ]);
    }
}
