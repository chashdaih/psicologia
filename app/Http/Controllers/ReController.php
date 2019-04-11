<?php

namespace App\Http\Controllers;

use App\Bread;
use App\Re;
use Illuminate\Http\Request;

class ReController extends Controller
{
    public function index()
    {
        $doc_code = 're';
        $mBread = new Bread('fe', 'fe5', $doc_code);
        $bread = collect($mBread->bread_array);
        $records = Re::all(); //TODO pagination
        $target = "paciente";
        return view('procedures.3.fe.list', compact('records', 'bread', 'doc_code','target'));

    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Re $re)
    {
        //
    }

    public function edit(Re $re)
    {
        //
    }

    public function update(Request $request, Re $re)
    {
        //
    }

    public function destroy(Re $re)
    {
        //
    }
}
