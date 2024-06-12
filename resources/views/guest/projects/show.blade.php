@extends('layouts.app')
@section('title', 'Project')


@section('content')

<section class="mb-5 py-5 bg-purple">
    <div class="bg-light container py-4 projects-cotnainer">

        <h1 class="my-4 text-center"> {{$project->name}} </h1>

        <div class="row pb-5 w-100 justify-content-center">
            <div class="card p-5 my-card">
                <p>
                    <span class="fw-bold">Created:</span> {{$project->date_of_creation}}
                </p>

                <p>
                    <span class="fw-bold">Type of Project:</span> {{$project->is_public === 0 ? 'Public' : 'Private'}} {{$project->type?->name ? ' - ' . $project->type->name: ''}}
                </p>

                @if (count($project->technologies) > 0)
                <ul class="d-flex gap-3 flex-wrap">
                    @foreach ($project->technologies as $technology)                    
                    <li class="text-warning fw-bold">
                        {{$technology->name}}
                    </li>
                    @endforeach
                </ul>
                @endif



                <p>
                    <a class="link link-primary" href="{{$project->link}}">Link al progetto</a>
                </p>

                <p>
                    <span class="fw-bold">Contributors:</span> {{$project->contributors}}
                </p>

                @if($project->contributors > 0)           
                <p>
                    <span class="fw-bold">Contributors names:</span> <br> 
                    {{$project->contributors_name}}
                </p>
                @endif
                
                <div class="accordion accordion-flush" id="projectDescriptionAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button 
                             class="accordion-button collapsed" 
                             type="button" 
                             data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" 
                             aria-expanded="false" aria-controls="flush-collapseOne"
                            >
                                Project Description
                            </button>
                        </h2>
                        @if ($project->description !== null)                        
                            <div id="flush-collapseOne" class="accordion-collapse collapse"
                                data-bs-parent="#projectDescriptionAccordion">
                                <div class="accordion-body">
                                    {{$project->description}}
                                </div>
                            </div>
                        @else
                        <div id="flush-collapseOne" class="accordion-collapse collapse"
                                data-bs-parent="#projectDescriptionAccordion">
                                <div class="accordion-body">
                                    This project has not a Description yet. We will update it as soon as possible.
                                </div>
                            </div>
                        @endif
                    </div>
                </div>               
            </div>

            @if($project->type)
            <div class="related-project-container mt-5">
                <h2 class="mb-3">Related Projects:</h2>
                <ul>
                    @foreach ($project->type->projects as $current_project)
                    <li>
                        <h5>
                            <a href="{{route('guest.projects.show', $current_project)}}">{{$current_project->name}}</a>
                        </h5>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>
    </div>

    
    
</section>

@endsection