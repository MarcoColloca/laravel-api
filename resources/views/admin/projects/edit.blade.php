@extends('layouts.app')

@section('title', 'Character')

@section('content')
<section class="mt-5 pt-5">
    <div class="container bg-dark py-4">
        <h1 class="title text-center text-warning">Edit project:  </h1>
        <h3 class="title text-center text-warning">{{$project->name}}</h3>
    </div>
</section>


<section class="mb-5 py-5">
    <div class="bg-dark text-light container py-4">
        <form action="{{ route('admin.projects.update', $project) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div class="mb-3">
                <label for="name" class="form-label fw-bold">Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Insert your name's project"
                    value="{{ old('name', $project->name) }}">
            </div>

            <!-- Link -->
            <div class="mb-3">
                <label for="link" class="form-label fw-bold">Link</label>
                <input type="text" class="form-control" id="link" name="link" placeholder="Insert your link's project"
                    value="{{ old('link', $project->link) }}">
            </div>

            <!-- Date of Creation -->
            <div class="mb-3">
                <label for="date_of_creation" class="form-label fw-bold">Date of Creation</label>
                <input type="date" class="form-control" id="date_of_creation" name="date_of_creation" placeholder="Insert date"
                    value="{{ old('date_of_creation', $project->date_of_creation) }}">
            </div>

            <!-- Public or Private -->
            <div class="mb-3">
                <label for="floatingSelect">Type</label>
                <select class="form-select" id="type" name="type" aria-label="Floating label select example">
                    @if ($project->is_public === 0)                
                        <option selected value="0">Public</option>
                        <option value="1">Private</option>
                    @else
                        <option value="0">Public</option>
                        <option selected value="1">Private</option>
                    @endif
                </select>        
            </div>

            <!-- Type of Project -->
            <div class="form-group mb-3">
                <label for="type_id">Type of Project</label>
                <select class="form-control" name="type_id" id="type_id">
                    <option value="">-- Seleziona Categoria --</option>
                    @foreach ($types as $type)                        
                        <option @selected($type->id == old('type_id', $project->type_id)) value="{{$type->id}}">{{$type->name}}</option>
                    @endforeach
                </select>
            </div>


            <!-- Technologies in Project -->
            <div class="form-group mb-3 ">
                <label for="technology_id">Select Project Technologies</label>
                <!-- @dump($project->technologies) -->
                <!-- @dump($project->technologies->pluck('id')) -->
                <!-- @dump($project->technologies->pluck('id')->all()) -->
                <div class="d-flex gap-2">
                                        
                    @foreach ($technologies as $technology)                        
                        <div class="form-check ">
                            <input @checked( in_array($technology->id, old('technologies', $project->technologies->pluck('id')->all()))) name="technologies[]" class="form-check-input" type="checkbox" value="{{$technology->id}}" id="technology-{{$technology->id}}">
                            <label class="form-check-label" for="technology-{{$technology->id}}">
                                {{$technology->name}}
                            </label>
                        </div>
                    @endforeach
                </div>                    
            </div>



            <!-- Number of Contributors -->
            <div class="mb-3">
                <label for="contributors" class="form-label fw-bold">Number of Contributors</label>
                <input type="number" class="form-control" id="contributors" name="contributors" placeholder="Insert value"
                    value="{{ old('contributors', $project->contributors) }}">
            </div>
            
            <!-- Names of Contributors -->
            <div class="mb-3">
                <label for="contributors_name" class="form-label fw-bold">Contributors Names (if any)</label>
                <textarea class="form-control" id="contributors_name" name="contributors_name"
                    placeholder="Contributor, Contributor, Contributor">{{old('contributors_name', $project->contributors_name)}}
                </textarea>
            </div>

            <!-- Description -->
            <div class="mb-3">
                <label for="description" class="form-label fw-bold">Description</label>
                <textarea class="form-control" id="description" name="description"
                    placeholder="Describe your project">{{old('description', $project->description)}}
                </textarea>
            </div>

            <button class="btn btn-primary">Edit</button>
        </form>
    </div>

    <div class="container mt-4">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</section>
@endsection