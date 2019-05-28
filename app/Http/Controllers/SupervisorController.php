<?php

namespace App\Http\Controllers;

use auth;
use App\Building;
use App\Supervisor;
use Illuminate\Http\Request;

class SupervisorController extends Controller
{
    public function index()
    {
        // $user_type = Auth::user()->type;
        // dd($user_type);

        $supervisors = Supervisor::all();
        $stages = Building::all();

        return view('supervisor.index', compact('supervisors', 'stages'));
    }

    // public function create() // se crean en register
    // {
    // }
    // public function store(Request $request)
    // {
    // }
    // public function show($id) // se podrán ver los datos en edit
    // {
    // }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
 