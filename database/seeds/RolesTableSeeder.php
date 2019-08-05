<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            array('name' => 'USER', 'created_at' => now()),
            array('name' => 'CUSTOMER', 'created_at' => now()),
            array('name' => 'ADMIN', 'created_at' => now())
        );
        DB::table('roles')->insert($data);
    }
}
