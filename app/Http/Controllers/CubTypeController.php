<?php

namespace App\Http\Controllers;

use App\CubType;
use Illuminate\Http\Request;

class CubTypeController extends Controller
{

    public function index()
    {
        $types = CubType::all();

        return view('calendar.cub_type.index', compact('types'));
    }

    public function create()
    {
        return view('calendar.cub_type.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required', 
            'description' => 'required',
        ]);
        
        CubType::create(collect($request)->toArray());

        return redirect()->route('cub_type.index')->with('success', 'Tipo registrado exitosamente');
    }

    public function show(CubType $cubType)
    {
        //
    }

    public function edit(CubType $cubType)
    {
        return view('calendar.cub_type.create', ['type' => $cubType]);
    }
    public function update(Request $request, CubType $cubType)
    {
        $this->validate($request, [
            'name' => 'required', 
            'description' => 'required',
        ]);

        $cubType->update($request->all());

        return redirect()->route('cub_type.index')->with('success', 'Tipo actualizado exitosamente');
    }

    public function destroy(CubType $cubType)
    {
        dd($cubType);

        $cubType->delete();
        
        return redirect()->route('cub_type.index')->with('success', 'Tipo borrado exitosamente');
    }
}
