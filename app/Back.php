<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Back extends Model
{

    protected $table = "backlogs";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'demo', 'importan', 'time', 'project_id'
    ];

}
