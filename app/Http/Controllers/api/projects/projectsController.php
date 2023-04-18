<?php

namespace App\Http\Controllers\api\projects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\project;
use App\Models\project_member;


class projectsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      $projects =  project::with('members')->latest()->paginate(30);
      return response()->json( $projects,200);
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
            'project_members' => 'required',

        ]);
        $request_data = $request->except(['project_members']);
        
        // dd($request_data);
        $project = project::create($request_data);
        foreach($request->project_members as $project_member)
        {
             project_member::create([
                'project_id' => $project->id,
                'user_id' => $project_member
            ]);
        }

        return response()->json('Done',200);

    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, project $project)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            // 'project_members' => 'required',

        ]);

        $request_data = $request->except(['project_members','members']);
        
        // dd($request_data);
         $project->update($request_data);

        if(isset($request->project_members))
        {
            foreach($request->project_members as $project_member)
            {
                project_member::updateOrCreate(
                    ['project_id' => $project->id  , 'user_id' => $project_member ],
                    ['project_id' => $project->id  , 'user_id' => $project_member ]
                );
            }
        }
      

        return response()->json('Done',200);


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $project_members = project_member::where('project_id')->get();

        foreach($project_members  as $project_member)
        {
            $project_member->delete();
        }
        project::find($id)->delete(); 

        return response()->json('Done',200);
        
    }



    public function getSingleProject($id)
    {
        return response()->json(project::with('members')->find($id),200);
    }
}
