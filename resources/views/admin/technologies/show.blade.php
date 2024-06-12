@extends('layouts.app')

@section('title', 'technology')


@section('content')

<section class="mb-5 py-5 bg-purple">
    <div class="bg-light container py-4 types-cotnainer">

        <h1 class="my-4 text-center"> {{$technology->name}} </h1>
        <h4 class="text-center">{{$technology->slug}}</h4>

        <div class="row pb-5 w-100 justify-content-center">
            <div class="card p-5 my-card">
                <p>
                    <span class="fw-bold">Description:</span>
                </p>
                <p>
                    Work in Progress..
                </p>
            </div>
        </div>
    </div>
</section>

@endsection