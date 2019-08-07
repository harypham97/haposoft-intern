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
        $this->call([
            RolesTableSeeder::class,
            DepartmentsTableSeeder::class,
            UsersTableSeeder::class,
            CustomersTableSeeder::class,
            ProjectsTableSeeder::class,
            TasksTableSeeder::class,
            ReportsTableSeeder::class,
            AdminsTableSeeder::class
        ]);
    }
}
