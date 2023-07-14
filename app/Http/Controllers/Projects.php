<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class Projects extends Controller
{
    public function info(Request $request){
        $data=$request->all();
        if(!empty($data['search'])){
            $data_search='%'.$data['search'].'%';
            $data_search = str_replace('"', '', $data_search);
            $project=  DB::table('projects')->where('user_id','=',$request->route('id'))->where('name','LIKE',$data_search)->get()->toArray();
        }else{
            $project=  DB::table('projects')->where('user_id','=',$request->route('id'))->get()->toArray();
        }

        return $project;
    }

    public function getProject(Request $request){

        $project=Project::findOrFail($request->route('id'));

        return $project;
    }


    public function store(Request $request){

        $validate=$request->validate([
            'user_id'=>'required|numeric',
            'name'=>'required',
        ]);

        //Project::create($request->all());
        if($validate->fails()) {
            return 'error validate';
        }
        $data=$request->all();
        $project= new Project();
        $project->user_id=$data['user_id'];
        $project->name=$data['name'];
        $project->description=(!empty($data['description']) ? $data['description']:'');
        $project->save();

        //$new_proj=Project::findOfFail($project->id);

       return $project;

    }

    public function updateProject(Request $request){

        $validate=$request->validate([
            'user_id'=>'required|numeric',
            'name'=>'required',
        ]);

        if($validate->fails()) {
            return 'error validate';
        }

        $data=$request->all();
        if(empty($request->route('id'))){
            return 'error no id project';
        }
        $project = Project::findOrFail($request->route('id'));
        $project->user_id=$data['user_id'];
        $project->name=$data['name'];
        $project->description=(!empty($data['description']) ? $data['description']:'');
        $project->update();

        return $project;

    }

    public function deleteProject(Request $request){

        if(empty($request->route('id'))){
            return 'error no id project';
        }
        $project=Project::findOrFail($request->route('id'));
        $project->delete();
        return ['success'=>'true'];
    }

}
