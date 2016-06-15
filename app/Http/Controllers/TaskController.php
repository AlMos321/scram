<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Project;
use App\Sprint;
use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
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
     * Создание задания
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
        $sprint = Sprint::find($request->sprint_id);
        $project_id = $sprint->project_id;
        if(isset($request->id) and !empty($request->id)){
            $sprintFound = Task::find($request->id);
            if(isset($sprintFound)){
                $sprintFound->name = $request->name;
                $sprintFound->description = $request->description;
                $sprintFound->time = $request->time;
                $sprintFound->type = $request->type;
                $sprintFound->priority = $request->priority;
                $sprintFound->reopen = $request->reopen;
                $sprintFound->reopen_description = $request->reopen_description;
                $sprintFound->creator_id = Auth::User()->id;
                $sprintFound->executor_id = $request->executor_id;
                $sprintFound->sprint_id = $request->sprint_id;
                $sprintFound->progres = $request->progres;
                $sprintFound->project_id = $project_id;
                $sprintFound->save();
            }
            $action = "update";
        } else {
            Task::create([
                'name' => $request->name,
                'description' => $request->description,
                'time' => $request->time,
                'type' => $request->type,
                'priority' => $request->priority,
                'reopen' => $request->reopen,
                'reopen_description' => $request->reopen_description,
                'creator_id' => Auth::User()->id,
                'executor_id' => $request->executor_id,
                'sprint_id' => $request->sprint_id,
                'progres' => $request->progres,
                'project_id' => $project_id,
            ]);
            $action = "create";
        }

        return response()->json(['action' => $action]);
    }

    /**
     * Получить одино задание по ид
     * @param Request $request
     */
    public function getTask(Request $request)
    {
        $task = Task::find($request->id);
        return response()->json($task);
    }

    public function onWork(Request $request)
    {
        $task = Task::find($request->id);
        if(isset($task)){
            $task->progres = "work";
            $task->save();
        }
        return response()->json('change');
    } 
    
    
    public function onFinish(Request $request)
    {
        $task = Task::find($request->id);
        if(isset($task)){
            $task->progres = "finish";
            $task->save();
        }
        return response()->json('change');
    }
    
    public function gant(){
        return view('gant');
    }

    //{id:1, text:"Project #2", start_date:"06/06/2016", duration:10,order:1, progress:0.4, open: true},

    public function getGant(Request $request){
        $project = Project::find($request->id);
        if(isset($project)){
            $start = date(strtotime($project->time_start));
            $end = date(strtotime($project->time_end));

            $duration = $end - $start;
            $duration =  round($duration/(60*60*24));
            $data = [];
            $data[] = ['id' => $project->id, 'text' => $project->name, 'start_date' => $project->time_start, 
                'duration' => $duration, 'order' => 1, 'progress' => 0.4, 'open' => true];
            
            return response()->json(['data' => $data]);
        }
    }
}
