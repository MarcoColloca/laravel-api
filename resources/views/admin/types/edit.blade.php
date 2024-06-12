@extends('layouts.app')

@section('title', 'Edit Type')

@section('content')
<section class="mt-5 pt-5">
    <div class="container bg-dark py-4">
        <h1 class="title text-center text-success">Edit this Type!</h1>
    </div>
</section>


<section class="mb-5 py-5">
    <div class="bg-dark text-light container py-4">
        <form action="{{ route('admin.types.update', $type) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label fw-bold">Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Insert your new type"
                    value="{{ old('name', $type->name) }}">
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