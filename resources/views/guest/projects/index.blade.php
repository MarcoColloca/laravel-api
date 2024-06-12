@extends('layouts.app')
@section('title', 'Projects')


@section('content')

<section class="mb-5 py-5 bg-purple">
    <div class="bg-light container py-4 projects-cotnainer">

        <h1 class="my-4 text-center text-danger"> My Projects</h1>

        <div class="projects-filter pb-5">
            <form action="{{route('guest.projects.index')}}" method="GET">


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


        <table class="table table-dark table-hover table-bordered">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Slug</th>
                    <th scope="col">Date of Creation</th>
                    <th colspan="2" scope="col">Type of Project</th>
                    <th colspan="2" scope="col">Technologies</th>
                    <th scope="col">Contributors</th>
                    <th scope="col">More Info</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($projects as $project)                
                    <tr class="position-relative">
                        <td>{{$project->name}}</td>
                        <td>{{$project->slug}}</td>
                        <td>{{$project->date_of_creation}}</td>
                        <td>{{$project->is_public === 0 ? 'Public' : 'Private'}}</td>
                        <td>{{$project->type?->name ? $project->type->name : ''}}</td>
                        <td class="text-center">{{count($project->technologies)}}</td>
                        <td>{{implode(', ', $project->technologies->pluck('name')->all())}}</td>
                        <td class="text-center">{{$project->contributors}}</td>
                        <td class="text-center"><a class="text-success"
                                href="{{route('guest.projects.show', $project)}}">Info</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>

@endsection