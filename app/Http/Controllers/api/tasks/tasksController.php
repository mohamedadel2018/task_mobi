<?php

namespace App\Http\Controllers\api\tasks;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\task;
use App\Models\task_member;
use App\Models\task_files;
use App\Models\task_comment;
use Image;
class tasksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks =  task::with('members','files')->latest()->paginate(30);
        return response()->json( $tasks,200);
    }

   

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'priority_level' => 'required',
            'status' => 'required',
        ]);
        $request_data = $request->except(['task_members','attachments','comments']);
        
        // dd($request_data);
        $task = task::create($request_data);
        foreach($request->task_members as $task_member)
        {
             task_member::create([
                'task_id' => $task->id,
                'user_id' => $task_member
            ]);
        }
        // dd( $request->attachments);

        
    // Save  Files9
            if($request->has('attachments'))
            {
                foreach($request->attachments as $index=>$file ){
                    $name =  $file[1]  .'-' . $task->id  .'.' . explode('/', explode(':', substr($file[0], 0, strpos($file[0], ';')))[1])[1];
                    Image::make($file[0])->save(public_path('images/files/').$name);
    
                    $task_file = new task_files();
                    $task_file->task_id = $task->id ;
                    $task_file->destination = $name;
                    $task_file->save();
    
                }
            }

        return response()->json('Done',200);
    }

 

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, task $task)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'priority_level' => 'required',
            'status' => 'required',
           

        ]);

        $request_data = $request->except(['task_members','members']);
        
        // dd($request_data);
         $task->update($request_data);

        if(isset($request->task_members))
        {
            foreach($request->task_members as $task_member)
            {
                task_member::updateOrCreate(
                    ['task_id' => $task->id  , 'user_id' => $task_member ],
                    ['task_id' => $task->id  , 'user_id' => $task_member ]
                );
            }
        }


        if($request->has('attachments'))
        {
            foreach($request->attachments as $index=>$file ){
                $name =  $file[1]  .'-' . $task->id  .'.' . explode('/', explode(':', substr($file[0], 0, strpos($file[0], ';')))[1])[1];
                Image::make($file[0])->save(public_path('images/files/').$name);

                $task_file = new task_files();
                $task_file->task_id = $task->id ;
                $task_file->destination = $name;
                $task_file->save();

            }
        }
      

        return response()->json('Done',200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task_members = task_member::where('task_id',$id)->get();

        foreach($task_members  as $task_member)
        {
            $task_member->delete();
        }



        $task_comment = task_comment::where('task_id',$id)->get();
        foreach($task_comment  as $task_comme)
        {
            $task_comme->delete();
        }

        task::find($id)->delete(); 

        return response()->json('Done',200);

    }


    public function getSingletask($id)
    {
        return response()->json(task::with(['members','files','comments' => function ($query) {
                        $query->with('commenter')->latest();
                    }])->find($id),200);
    }



    public function filter(Request $request)
    {
        if($request->data == null){
            $tasks =  task::with('members','files')->latest()->paginate(30);
        }elseif($request->filed == 'end_date'){
            $tasks = task::whereBetween($request->filed,array($request->data[0],$request->data[1]))->with('members','files')->latest()->paginate(30);
        }
        else{
           $tasks = task::where($request->filed,'like','%'.$request->data.'%')->with('members','files')->latest()->paginate(30);
        }

        return  response()->json($tasks, 200);
    }



    public function deletefile($id)
    {
        task_files::find($id)->delete();

        return response()->json('Done',200);
    }

   


    public function addcommenttask(Request $request,$taskId)
    {
        $request->validate([
            'comment' => 'required',
        ]);
        
        $comment_data = task_comment::create([
            'task_id' => $taskId,
            'comment' => $request->comment,
            'user_id' =>  auth('sanctum')->id()
        ]);
        return response()->json(task_comment::find($comment_data->id)->with('commenter')->latest()->first()  ,200);

    }


    public function  deleteComment($id)
    {
        task_comment::find($id)->delete();

        return response()->json('Done',200);
    }

}
