@extends('layouts.app')

@section('title', 'Technologies')


@section('content')
    
    <section class="mb-5 py-5 bg-purple">
        <div class="bg-light container py-4 technologies-cotnainer">

            <h1 class="my-4 text-center text-danger"> Technologies</h1>
            <div class="text-end me-3">
                <a class="btn btn-dark mb-5" href="{{route('admin.technologies.create')}}">Add Technology</a>
            </div>
            <div class="table-container">
                <table class="table table-sm table-dark table-hover table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center" scope="col-1">Name</th>
                            <th class="text-center" scope="col-1">Slug</th>
                            <th class="text-center" scope="col-1">More Info</th>
                            <th class="text-center" scope="col-1">Modify</th>
                            <th class="text-center" scope="col-1">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($technologies as $technology)                
                            <tr class="position-relative">
                                <td class="text-center">{{$technology->name}}</td>
                                <td class="text-center">{{$technology->slug}}</td>
                                <td class="text-center"><a class="text-success" href="{{route('admin.technologies.show', $technology)}}">Info</a></td>
                                <td class="text-center"><a class="text-primary" href="{{route('admin.technologies.edit', $technology)}}">Edit</a></td>
                                <td class="text-center">
                                    <form class="item-delete-form" action="{{ route('admin.technologies.destroy', $technology) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
        
                                        <button class="btn link-danger">X</button>
        
                                        <div class="my-modal">
                                            <div class="my-modal__box">
                                                <h5 class="text-center me-5">Do you really want to delete this Technology?!</h5>
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
        </div>
    </section>
    
@endsection