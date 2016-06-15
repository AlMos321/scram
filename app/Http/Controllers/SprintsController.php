<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Project;
use App\Sprint;
use App\Task;
use App\User;
use Illuminate\Http\Request;

class SprintsController extends Controller
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
        if(isset($_GET['project_id'])){
            $sprints = Sprint::where('project_id', '=', $_GET['project_id'])->get();
        } else {
            $sprints = Sprint::all();
        }
        $users = User::all();
        $projects = Project::all();
        $tasks = Task::all();
        return view('sprints', ['sprints' => $sprints, 'projects' => $projects, 'users' => $users, 'tasks' => $tasks]);
    }

    /**
     * Создание спринта
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
        if(isset($request->id) and !empty($request->id)){
            $sprintFound = Sprint::find($request->id);
            if(isset($sprintFound)){
                $sprintFound->name = $request->name;
                $sprintFound->description = $request->description;
                $sprintFound->time_start = $request->time_start;
                $sprintFound->time_end = $request->time_end;
                $sprintFound->project_id = $request->select_project;
                $sprintFound->save();
            }
            $action = "update";
        } else {
            Sprint::create([
                'name' => $request->name,
                'description' => $request->description,
                'time_start' => $request->time_start,
                'time_end' => $request->time_end,
                'project_id' => $request->select_project,
            ]);
            $action = "create";
        }

        return response()->json(['action' => $action]);
    }

    /**
     * Получить один спринт по ид
     * @param Request $request
     */
    public function getSprint(Request $request)
    {
        $sprint = Sprint::find($request->id);
        return response()->json($sprint);
    }


    public function gant(){
        return view('sprint_gant');
    }


    public function sprintGant(){
        
        if(isset($_GET['id'])){
            $id = $_GET['id'];

            $sprints = Sprint::where('project_id','=', $id)->get();
            if(isset($sprints)){
                $data = [];
                foreach ($sprints as $s){
                    $start = date(strtotime($s->time_start));
                    $end = date(strtotime($s->time_end));

                    $duration = $end - $start;
                    $duration =  round($duration/(60*60*24));
                    $data[] = ['id' => $s->id, 'text' => $s->name, 'start_date' => $s->time_start,
                        'duration' => $duration, 'order' => 1, 'progress' => 0.4, 'open' => true];
                }
                
                return response()->json(['data' => $data]);
            }

        } else {
            return redirect()->back();
        }
        
    }
    
    
}
