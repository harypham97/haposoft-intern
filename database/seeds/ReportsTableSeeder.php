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
        $tasks = App\Models\Task::all();
        factory(App\Models\Report::class, 10)->create()
            ->each(function ($report) use ($tasks) {
                $report->tasks()->attach(
                    $tasks->random()->id,
                    ['report_id' => $this->faker->numberBetween(1, 10)]);
            });
    }
}
