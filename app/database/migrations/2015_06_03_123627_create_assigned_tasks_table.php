<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssignedTasksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('assigned_tasks', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('task_id');
			$table->integer('assign_by_id');
			$table->integer('assign_to_id');
			$table->enum('accepted', array(0, 1))->default(0);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('assigned_tasks');
	}

}
