@extends('layouts.app')

@section('content')

<section class="mb-5 py-5 bg-purple">
    <div class="bg-light container py-4 projects-cotnainer">

        <div>
            <h1 class="my-4 text-center text-danger"> My Projects</h1>
            
            <p>
                @if(request('trash'))
                    <a class="btn btn-outline-dark text-decoration-none" href="{{route('admin.projects.index')}}">Projects</a>
                @else
                    <a class="btn btn-outline-dark text-decoration-none" href="{{route('admin.projects.index', ['trash' => 1])}}">Trash {{$trashed}}</a>
                @endif
            </p>
        </div>

        @if(!request('trash'))
        <div class="projects-filter">
            <form action="{{route('admin.projects.index')}}" method="GET">


            <label class="form-label fw-bold" for="project_status">Is Public?</label>
                <select class="form-control" name="project_status" id="project_status">
                    <option value="">-</option>
                    <option value="0">Yes</option>
                    <option value="1">No</option>
                </select>


                <div class="form-group mb-3">
                    <label class="form-label fw-bold" for="type_id">Type of Project</label>
                    <select class="form-control" name="type_id" id="type_id">
                        <option value="">-- Select Type --</option>
                        <option value="none">None</option>
                        @foreach ($types as $type)                        
                            <option @selected($type->id == old('type_id')) value="{{$type->id}}">{{$type->name}}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group mb-3 ">
                    <label class="form-label fw-bold" for="technology_id">Select Project technologies</label>

                    <div class="d-flex gap-2">

                        @foreach ($technologies as $technology)                        
                            <div class="form-check ">
                                <input @checked(in_array($technology->id, old('technologies', []))) name="technologies[]"
                                    class="form-check-input" type="checkbox" value="{{$technology->id}}"
                                    id="technology-{{$technology->id}}">
                                <label class="form-check-label" for="technology-{{$technology->id}}">
                                    {{$technology->name}}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>


                <button class="btn btn-dark">Filtra</button>
            </form>
        </div>
        @endif

        @if(!request('trash'))
        <div class="text-end me-3">
            <a class="btn btn-dark mb-5" href="{{route('admin.projects.create')}}">Add Project</a>
        </div>
        @endif

        <table class="table table-dark table-hover table-bordered">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Date of Creation</th>
                    <th colspan="2" scope="col">Type of Project</th>
                    <th scope="col">Technologies</th>
                    <th scope="col">Contributors</th>
                    <th scope="col">Info</th>                    
                    <th scope="col">Modify</th>                    
                    <th scope="col">Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($projects as $project)                
                    <tr class="position-relative">
                        <td>{{$project->name}}</td>
                        <td>{{$project->date_of_creation}}</td>
                        <td>{{$project->is_public === 0 ? 'Public' : 'Private'}}</td>
                        <td>{{$project->type?->name ? $project->type->name : ''}}</td>
                        <td>{{implode(', ', $project->technologies->pluck('name')->all())}}</td>
                        <td class="text-center">{{$project->contributors}}</td>
                        <td class="text-center"><a class="text-success"
                            @if(!$project->trashed())
                                href="{{route('admin.projects.show', $project)}}">Info</a>
                            @endif
                        </td>
                        <td class="text-center">
                            {{-- Nascosto nel Cestino --}}
                            @if(!$project->trashed())
                                <a class="text-primary" href="{{route('admin.projects.edit', $project)}}">Edit</a>
                            @elseif($project->trashed())
                                <form class="item-delete-form" action="{{ route('admin.projects.restore', $project)}}"
                                    method="POST">
                                    @csrf
                                    <button class="btn link-warning">Restore</button>

                                    <div class="my-modal">
                                        <div class="my-modal__box">
                                            <h5 class="text-center me-5">Do you really want to restore this Project?!</h5>
                                            <span class="link link-danger my-modal-yes mx-5">Yes</span>
                                            <span class="link link-success my-modal-no">No</span>
                                        </div>
                                    </div>

                                </form>
                            @endif
                        </td>
                        <td class="text-center">
                            <form class="item-delete-form" action="{{ !$project->trashed() ? route('admin.projects.destroy', $project) : route('admin.projects.forceDestroy', $project)}}"
                                method="POST">
                                @csrf
                                @method('DELETE')

                                <button class="btn link-danger">X</button>

                                <div class="my-modal">
                                    <div class="my-modal__box">
                                        <h5 class="text-center me-5">Do you really want to delete this Project?!</h5>
                                        <span class="link link-danger my-modal-yes mx-5">Yes</span>
                                        <span class="link link-success my-modal-no">No</span>
                                    </div>
                                </div>

                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
@endsection