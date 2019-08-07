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
<<<<<<< HEAD
        // $this->call(UsersTableSeeder::class);
=======
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
>>>>>>> 2d0f237... crud login logout
    }
}
