<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Project;
use App\Sprint;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::all();
        return view('projects', ['projects' => $projects]);
    }

    /**
     * Создание спринта
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
        if(isset($request->id) and !empty($request->id)){
            $sprintFound = Project::find($request->id);
            if(isset($sprintFound)){
                $sprintFound->name = $request->name;
                $sprintFound->description = $request->description;
                $sprintFound->code = $request->code;
                $sprintFound->time_start = $request->time_start;
                $sprintFound->time_end = $request->time_end;
                $sprintFound->save();
            }
            $action = "update";
        } else {
            Project::create([
                'name' => $request->name,
                'description' => $request->description,
                'code' => $request->code,
                'time_start' => $request->time_start,
                'time_end' => $request->time_end,
            ]);
            $action = "create";
        }

        return response()->json(['action' => $action]);
    }

    /**
     * Получить один спринт по ид
     * @param Request $request
     */
    public function getProject(Request $request)
    {
        $project = Project::find($request->id);
        return response()->json($project);
    }

    public function delete(Request $request){
        $project = Project::find($request->id);
        if(isset($project)){
            $project->delete();
        }
        return response()->json('delete');
    }
}
