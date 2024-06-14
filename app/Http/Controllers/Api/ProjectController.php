<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request){

        // creo una variabile per definire gli elementi da inserire in ogni  pagina
        $per_page = $request->perPage ?? 6;


        // Creo una variabile in cui salvo i progetti con le relative relazioni, facendomi ritornare i risultati impaginati
        $results = Project::with('type', 'technologies')->paginate($per_page);

        // Ritorno i risultati trasformandoli in formato json
        return response()->json([
            'results' => $results
        ]);            
    }
    
    
    public function show(Project $project){


        $project->load(['type', 'type.projects', 'technologies']);

        $results = $project;

        return response()->json([
            'success' => true,
            'results' => $results
        ]);            
    
    }
}
