<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTypeRequest;
use App\Http\Requests\UpdateTypeRequest;
use App\Models\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
{   
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $types = Type::all();

        return view('admin.types.index', compact('types'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTypeRequest $request)
    {
        $form_data = $request->validated();

        $new_type = new Type();
        $new_type->name = $form_data['name'];
        $new_type->slug = Type::getUniqueSlug($new_type->name);


        // dd($new_type);
        $new_type->save();

        return to_route("admin.types.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(Type $type)
    {
        return view('admin.types.show', compact('type'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Type $type)
    {
        return view("admin.types.edit", compact("type"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTypeRequest $request, Type $type)
    {
        $form_data = $request->validated();

        $type->fill($form_data);

        $type->slug = Type::getUniqueSlug($type->name);

        $type->save();

        return to_route('admin.types.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Type $type)
    {
        $type->delete();

        return to_route('admin.types.index');
    }
}
