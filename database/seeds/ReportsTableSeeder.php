<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class ReportsTableSeeder extends Seeder
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
        $tasks = App\Model\Task::all();
        factory(App\Model\Report::class, 20)->create()
            ->each(function ($report) use ($tasks) {
                $report->tasks()->attach(
                    $tasks->random()->id,
                    ['report_id' => $this->faker->numberBetween(1, 20), 'name' => $this->faker->name, 'description' => $this->faker->text, 'time' => now()]);
            });
    }
}
