<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Technology;
use App\Models\Type;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $types = Type::orderBy('name', 'asc')->get();
        $technologies = Technology::orderBy('name', 'asc')->get();

        //$projects = Project::all();
        $query = Project::with(['type', 'type.projects']); // 3 query. la 1° prende i project, la 2° prende i tipi associati a quel project, la 3° prende tutti i progetti associati al tipo indicato



        $filters = $request->all();
        
        // dump($filters);

        if(isset($filters['project_status'])) 
        {
            $query->where('is_public', $filters['project_status']);
        }




        if(isset($filters['type_id']) && $filters['type_id'] === 'none')
        {
            $query->where('type_id', null);
        }
        elseif(isset($filters['type_id']))
        {
            $query->where('type_id', $filters['type_id']);
        }
            
            


        if(isset($filters['technologies']))
        {
            $query->whereHas('technologies', function (Builder $query) use($filters) {

                $query->whereIn('id', $filters['technologies']);
                
            });
        }


        // $public_projects = Project::where('is_public', '=' ,0)->get();

        // $private_projects = Project::where('is_public', 1)->get();


        $projects = $query->get();

        return view('guest.projects.index', compact('projects', 'types', 'technologies'));
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {

        // $projects = Project::with(['type', 'type.projects'])->get();
        //dd($project);

        $project->load(['type', 'type.projects']);
        

        return view('guest.projects.show', compact('project'));
    }









    /** Unused CRUD Functions */


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        //
    }
}
