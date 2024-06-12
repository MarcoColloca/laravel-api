<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Technology;
use App\Models\Type;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

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

        return view('admin.projects.index', compact('projects', 'types', 'technologies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()    
    {

        $types = Type::orderBy('name', 'asc')->get();

        $technologies = Technology::orderBy('name', 'asc')->get();


        return view('admin.projects.create', compact('types', 'technologies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        // VALIDATION in StoreProjectRequest


        $form_data = $request->validated();

        $new_project = new Project();

        $new_project->name = $form_data['name'];
        $new_project->link = $form_data['link'];
        $new_project->type_id = $form_data['type_id'];
        $new_project->date_of_creation = $form_data['date_of_creation'];        
        $new_project->is_public = $request->input('type');        
        $new_project->contributors = $form_data['contributors'];
        $new_project->contributors_name = $form_data['contributors_name'];
        $new_project->description = $form_data['description'];
        //$new_project->slug = $this->getUniqueSlug($new_project->name);
        $new_project->slug = Project::getUniqueSlug($new_project->name);

        //dd($new_project);

        $new_project->save();

        if($request->has('technologies'))
        {
            //$project->technologies()->attach($form_data['technologies']);

            $new_project->technologies()->attach($request->technologies);

        }



        return to_route("admin.projects.show", $new_project);
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        // eager loading
        $project->load(['type', 'type.projects']);

        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {

        $types = Type::orderBy('name', 'asc')->get();

        $project->load(['technologies']);

        $technologies = Technology::orderBy('name', 'asc')->get();


        return view("admin.projects.edit", compact("project", 'types', 'technologies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        //VALIDATION in UpdateProjectRequest

        
        $form_data = $request->validated();

        $project->fill($form_data);
        $project->slug = Project::getUniqueSlug($project->name);

        $project->save();



        /* La sincroniazzazione può essere effettuata sia prima che dopo
        if($request->has('technologies'))
        {
            $project->technologies()->sync($request->technologies);
        }else
        {
            // Se l'utente ha deselezionato tutti i tag (o non ne ha selezionato nessuno), con uno dei due metodi qui sotto
            $project->technologies()->detach();
            // $project->technologies()->sync([]);
        }
        */ 
            
            
        // Altro metodo con il null coalescing PRO.        
        $project->technologies()->sync($request->technologies ?? []);


        return to_route('admin.projects.show', $project);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return to_route('admin.projects.index');
    }
}
