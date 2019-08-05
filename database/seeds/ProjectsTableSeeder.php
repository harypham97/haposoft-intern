<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class ProjectsTableSeeder extends Seeder
{
    protected $faker;

    public function __construct(Faker $faker)
    {
        $this->faker = $faker;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = App\Model\User::all();
        factory(App\Model\Project::class, 30)->create()
            ->each(function ($project) use ($users) {
                $project->users()->attach(
                    $users->random()->id,
                    ['project_id' => $this->faker->numberBetween(1, 30), 'date_start' => now(), 'date_finish' => now()]);
            });
    }
}
