<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sprint extends Model
{
    
    protected $table = "sprints";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'time_start', 'time_end', 'project_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];
}
