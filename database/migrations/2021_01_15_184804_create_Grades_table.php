<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGradesTable extends Migration {

	public function up()
	{
		Schema::create('grades', function(Blueprint $table) {
			$table->id();
			$table->timestamps();
			$table->string('Name');
        	$table->text('Notes')->nullable();

			$table->bigInteger('created_by')->unsigned();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');


		});
	}

	public function down()
	{
		Schema::drop('Grades');
	}
}
