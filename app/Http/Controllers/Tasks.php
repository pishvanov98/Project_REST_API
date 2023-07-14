<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Tasks extends Controller
{
    public function tasksList(Request $request){
        $data=$request->all();
        if(!empty($data['user_id'])){
            $tasks = DB::table('tasks')->where('project_id','=',$request->route('id'))->where('user_id','=',$data['user_id'])->get(['id','name','user_id','status'])->toArray();
        }else{
            $tasks = DB::table('tasks')->where('project_id','=',$request->route('id'))->get(['id','name','user_id','status'])->toArray();
        }

        return $tasks;
    }
    public function storeTasks(Request $request){

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
        $task= new Task();
        $task->user_id=$data['user_id'];
        $task->name=$data['name'];
        $task->description=(!empty($data['description']) ? $data['description']:'');
        $task->status=(!empty($data['status']) ? $data['status']:'');
        $task->project_id=$request->route('id');
        $task->save();

        // $new_task=Task::findOfFail($task->id);

        return $task;

    }

    public function updateTask(Request $request){

        $validate=$request->validate([
            'user_id'=>'required|numeric',
            'name'=>'required',
        ]);
        if($validate->fails()) {
            return 'error validate';
        }

        if(empty($request->route('id'))){
            return 'error no id project';
        }
        if(empty($request->route('task_id'))){
            return 'error no id task';
        }
        $data=$request->all();

        $task=  DB::table('tasks')->where('project_id','=',$request->route('id'))->where('id','=',$request->route('task_id'))->update($data);

        $update_task=Task::findOrFail($request->route('task_id'));

        return $update_task;

    }

    public function deleteTask(Request $request){

        if(empty($request->route('id'))){
            return 'error no id project';
        }
        if(empty($request->route('task_id'))){
            return 'error no id task';
        }

        DB::table('tasks')->where('project_id','=',$request->route('id'))->where('id','=',$request->route('task_id'))->delete();
        return ['success'=>'true'];
    }

}
