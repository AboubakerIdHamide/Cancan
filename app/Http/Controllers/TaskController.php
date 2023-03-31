<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function index()
    {
        $tasks= Task::all();
        $data=[
            "status"=>200,
            "tasks"=>$tasks,
        ];
        return response()->json($data, 200);
    }

    public function show(Task $task)
    {
        $data=[
            "status"=>200,
            "task"=>$task,
        ];
        return response()->json($data);
    }

    public function store(Request $req)
    {
        $validator=Validator::make($req->all(), [
            "name"=>"required|min:3|max:195",
            "description"=>"required|min:20|max:500",
            "status"=>"required|string",
            "date_debut"=>"required|date",
            "date_fin"=>"required|date",
            "project_id"=>"required|string"
        ]);

        if($validator->fails()){
            return response()->json([
                "status"=>422,
                "errors"=>$validator->messages(),
            ], 422);
        }else{
            $task=Task::create([
                "name"=>$req->name,
                "description"=>$req->description,
                "status"=>$req->status,
                "date_debut"=>$req->date_debut,
                "date_fin"=>$req->date_fin,
                "project_id"=>$req->project_id
            ]);

            if($task){
                return response()->json([
                    "status"=>200,
                    "message"=>"Task Added Successfullly",
                ]);
            }else{
                return response()->json([
                    "status"=>500,
                    "message"=>"SomeThing Want Wrong While Adding The Task",
                ], 500);
            }
        }
    }

    public function update(Task $task, Request $req)
    {
        $validator=Validator::make($req->all(), [
            "name"=>"required|min:3|max:195",
            "description"=>"required|min:20|max:500",
            "status"=>"required|string",
            "date_debut"=>"date",
            "date_fin"=>"date",
            "project_id"=>"string"
        ]);

        if($validator->fails()){
            return response()->json([
                "status"=>422,
                "errors"=>$validator->messages(),
            ], 422);
        }else{
            $task->update([
                "name"=>$req->name,
                "description"=>$req->description,
                "status"=>$req->status,
                "date_debut"=>$req->date_debut,
                "date_fin"=>$req->date_fin,
                "project_id"=>$req->project_id
            ]);

            if($task){
                return response()->json([
                    "status"=>200,
                    "message"=>"Task Updated Successfullly",
                ]);
            }else{
                return response()->json([
                    "status"=>500,
                    "message"=>"SomeThing Want Wrong While Updating The Task",
                ], 500);
            }
        }
    }

    public function destroy(Task $task)
    {
        $deleted=$task->delete();
        $data=[];
        if($deleted){
            $data["status"]=200;
            $data["message"]="Task Deleted Successfully";
        }else{
            $data["status"]=500;
            $data["message"]="SomeThing Want Wrong While Deleting The Task";
        }
        return response()->json($data);
    }
}
