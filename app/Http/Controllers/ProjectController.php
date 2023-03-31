<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    public function index()
    {
        $projects= Project::all();
        $data=[
            "status"=>200,
            "projects"=>$projects,
        ];
        return response()->json($data, 200);
    }

    public function show(Project $project)
    {
        $data=[
            "status"=>200,
            "project"=>$project,
        ];
        return response()->json($data);
    }

    public function store(Request $req)
    {
        $validator=Validator::make($req->all(), [
            "name"=>"required|min:3|max:195",
            "description"=>"required|min:20|max:500",
        ]);

        if($validator->fails()){
            return response()->json([
                "status"=>422,
                "errors"=>$validator->messages(),
            ], 422);
        }else{
            $project=Project::create([
                "name"=>$req->name,
                "description"=>$req->description,
            ]);

            if($project){
                return response()->json([
                    "status"=>200,
                    "message"=>"Project Added Successfullly",
                ]);
            }else{
                return response()->json([
                    "status"=>500,
                    "message"=>"SomeThing Want Wrong While Adding The Project",
                ], 500);
            }
        }
    }

    public function update(Project $project, Request $req)
    {
        $validator=Validator::make($req->all(), [
            "name"=>"required|min:3|max:195",
            "description"=>"required|min:20|max:500",
        ]);

        if($validator->fails()){
            return response()->json([
                "status"=>422,
                "errors"=>$validator->messages(),
            ], 422);
        }else{
            $project->update([
                "name"=>$req->name,
                "description"=>$req->description,
            ]);

            if($project){
                return response()->json([
                    "status"=>200,
                    "message"=>"Project Updated Successfullly",
                ]);
            }else{
                return response()->json([
                    "status"=>500,
                    "message"=>"SomeThing Want Wrong While Updating The Project",
                ], 500);
            }
        }
    }

    public function destroy(Project $project)
    {
        $deleted=$project->delete();
        $data=[];
        if($deleted){
            $data["status"]=200;
            $data["message"]="Project Deleted Successfully";
        }else{
            $data["status"]=500;
            $data["message"]="SomeThing Want Wrong While Deleting The Project";
        }
        return response()->json($data);
    }
}
