<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;

class ProjectController extends Controller
{
    public function index(){
		$projects = Project::orderBy('created_at', 'desc')->withCount(['tasks'=> function ($query){

		}])->get();
		return $projects->toJson();
	}

	public function store(Request $request){
		$validateData = $request->validate([
			'name' => 'required',
			'description' => 'required'
		]);

		$project = Project::create([
			'name' => $validateData['name'],
			'description' => $validateData['description']
		]);

		return response()->json('Project created!');
	}

	public function show($id){
		$project = Project::with(['tasks' => function ($query) {

        }])->find($id);

		return $project != null ? $project->toJson() : response()->json('Project not found!');
	}

	public function markAsCompleted(Project $project){
		$project->is_completed = true;
		$project->update();

		return response()->json('Project updated!');
    }

    public function delete(Project $project){
		$project->delete();

		return response()->json('Project deleted!');
	}
}
