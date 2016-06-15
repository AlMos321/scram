<?php

namespace App\Http\Controllers;

use App\Back;
use App\Http\Requests;
use App\Project;
use App\Sprint;
use App\Task;
use App\User;
use Illuminate\Http\Request;

class BackController extends Controller
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
            $backs = Back::where('project_id', '=', $_GET['project_id'])->get();
        } else {
            $backs = Back::all();
        }
        $projects = Project::all();
        return view('back', ['backs' => $backs, 'projects' => $projects]);
    }

    /**
     * Создание беклога
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
        if(isset($request->id) and !empty($request->id)){
            $back = Back::find($request->id);
            if(isset($sprintFound)){
                $back->name = $request->name;
                $back->description = $request->description;
                $back->importan = $request->importan;
                $back->demo = $request->demo;
                $back->time = $request->time;
                $back->project_id = $request->project_id;
                $back->save();
            }
            $action = "update";
        } else {
            Back::create([
                'name' => $request->name,
                'description' => $request->description,
                'importan' => $request->importan,
                'demo' => $request->demo,
                'time' => $request->time,
                'project_id' => $request->project_id,
            ]);
            $action = "create";
        }

        return response()->json(['action' => $action]);
    }

    public function delete(Request $request){
        $back = Back::find($request->id);
        if(isset($back)){
            $back->delete();
        }
        return response()->json('request_ok');
    }
    
    public function getBack(Request $request){
        $back = Back::find($request->id);
        return response()->json($back);
    }


}
