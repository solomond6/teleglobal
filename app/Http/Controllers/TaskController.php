<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //fetch and paginate all task list
        $tasks = Task::paginate(10);
        
        //get all users
        $users = User::pluck('name','id');
        return view('tasks.index', compact('tasks', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if($request->isMethod('post')){

            //validate the request
            $this->validate($request, [
                'name' => 'required',
                'description' => 'required',
                'user_id' => 'required',
            ]);

            $data = $request->all();

            //build the task object
            $task = new Task;
            $task->name = $data['name'];
            $task->description = $data['description'];
            $task->user_id = $data['user_id'];
            $task->status = 'in_progres';


            //redirect to index after saving new task or not
            if($task->save()){
                return redirect()->back()->with('success', 'Task Created Successfully');
            }else{
                return redirect()->back()->with('error', 'Error cccured when creating task, kindly try again.');
            }
        }

        $currencyList = Currency::pluck('title','code');

        return view('tasks.index', compact('tasks', 'users'));
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id=null)
    {
        if($request->isMethod('post')){
            $data = $request->all();

            try{

                //update the task with the edited data
                $updated = Task::where(['id'=>$id])->update(['status'=>$data['status'], 'name'=>$data['name'], 'description'=>$data['description']]);


                //redirect to index after edit or not
                if($updated){
                    return redirect()->back()->with('success', 'Task Updated Successfully');
                }else{
                    return redirect()->back()->with('error', 'Error occcured when updating task, kindly try again.');
                }

            }catch(\Exception $ex){

                //catch exceptions
                return redirect()->back()->with('error', 'Error occcured when updating task, kindly try again.');
            }
            
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id = null)
    {
        //check if the request is post
        if($request->isMethod('post')){
            $data = $request->all();

            try{

                // update the task
                $updated = Task::where(['id'=>$data['id']])->update(['status'=>$data['status']]);


                //redirect to index after update
                if($updated){
                    return redirect()->back()->with('success', 'Task Updated Successfully');
                }else{
                    return redirect()->back()->with('error', 'Error occcured when updating task, kindly try again.');
                }

            }catch(\Exception $ex){

                return redirect()->back()->with('error', 'Error occcured when updating task, kindly try again.');
            }
            
        }
    }


    public function delete(Request $request, $id=null){

        if(!empty($id)){
            $data = $request->all();
            
            //delete the task
            $deleted = Task::where(['id'=>$id])->delete();

            //redirect to index after delete or not
            if($deleted){
                return redirect()->back()->with('success', 'Task Deleted Successfully');
            }else{
                return redirect()->back()->with('error', 'Error cccured when deleting task, kindly try again.');
            }
        }
    }

}
