<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class Projects extends Controller
{
    public function info(Request $request){
        $data=$request->all();
        if(!empty($data['search'])){
            $data_search='%'.$data['search'].'%';
            $data_search = str_replace('"', '', $data_search);
            $project=  DB::table('projects')->where('user_id','=',$request->route('id'))->where('name','LIKE',$data_search)->get();
        }else{
            $project=  DB::table('projects')->where('user_id','=',$request->route('id'))->get();
        }

        return $project;
    }

    public function getProject(Request $request){

        $project=Project::findOrFail($request->route('id'));

        return $project;
    }

    public function tasksList(Request $request){

        if(!empty($data['user_id'])){
            $tasks = DB::table('tasks')->where('project_id','=',$request->route('id'))->where('user_id','=',$data['user_id'])->get(['id','name','user_id','status']);
        }else{
            $tasks = DB::table('tasks')->where('project_id','=',$request->route('id'))->get(['id','name','user_id','status']);
        }

       return json_decode(json_encode($tasks), true);
    }

    public function validate(Request $request){

        //

    }
}
