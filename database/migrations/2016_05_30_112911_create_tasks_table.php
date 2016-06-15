<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description');
            $table->string('type');
            $table->string('priority');
            $table->integer('time');
            $table->integer('project_id');
            $table->integer('reopen')->nullable();
            $table->integer('reopen_description')->nullable();

            $table->string('progres');

            $table->integer('creator_id')->unsigned();
            $table->foreign('creator_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('executor_id')->unsigned();
            $table->foreign('executor_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('sprint_id')->unsigned();
            $table->foreign('sprint_id')->references('id')->on('sprints')->onDelete('cascade');
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
        Schema::drop('tasks');
    }
}
