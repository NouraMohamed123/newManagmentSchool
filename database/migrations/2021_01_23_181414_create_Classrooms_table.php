<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClassroomsTable extends Migration {

	public function up()
	{
		Schema::create('classrooms', function(Blueprint $table) {
			$table->id();
			$table->string('Name_Class');
			$table->bigInteger('Grade_id')->unsigned();



			$table->bigInteger('created_by')->unsigned();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');


			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('Classrooms');
	}
}
