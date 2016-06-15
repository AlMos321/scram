<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{

    protected $table = "tasks";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'time',
        'type',
        'priority',
        'reopen',
        'reopen_description',
        'creator_id',
        'executor_id',
        'sprint_id',
        'project_id',
        'progres'
    ];

}


/*$table->increments('id');
$table->string('name');
$table->string('description');
$table->string('type');
$table->string('priority');
$table->integer('time');
$table->integer('reopen')->default(0);
$table->integer('reopen_description');

$table->integer('creator_id')->unsigned();
$table->foreign('creator_id')->references('id')->on('users')->onDelete('cascade');

$table->integer('executor_id')->unsigned();
$table->foreign('project_id')->references('id')->on('users')->onDelete('cascade');

$table->integer('sprint_id')->unsigned();
$table->foreign('sprint_id')->references('id')->on('sprints')->onDelete('cascade');
$table->timestamps();*/