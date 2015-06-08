<?php

class UserTaskSeeder extends Seeder{

	public function run()
	{
		$faker = Faker\Factory::create();

		foreach (range(1,100) as $index) {
			Task::create([
				'creator_id' => 1,
				'title' => $faker->sentence(3),
				'task_desc' => $faker->paragraph(2)
				]);
		}
	}
}

?>