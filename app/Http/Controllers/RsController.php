<?php

namespace App\Http\Controllers;

use App\Bread;
use App\FE3FDG;
use App\Rs as Doc;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class RsController extends Controller
{
    protected $process = 'fe';
    protected $number = '7';
    protected $doc_code = 'rs';

    public function index()
    {
        $doc_code = $this->doc_code;
        $mBread = new Bread($this->process, $this->process.$this->number, $doc_code);
        $bread = collect($mBread->bread_array);
        $records = Doc::all(); //TODO where supervisor / student = auth, pagination
        return view('procedures.3.fe.7.rs.index', compact('records', 'bread'));
    }

    public function create()
    {
        $fields = $this->getFields();
        $values = new Doc();
        $code = $this->doc_code;
        $mBread = new Bread($this->process, $this->process.$this->number, $code);
        $bread = collect($mBread->bread_array);
        return view('procedures.3.fe.create', compact('bread', 'fields', 'values', 'code'));
    }

    protected function getFields()
    {
        $json = file_get_contents($this->dirname_r(__DIR__, 2).'/fields/'.$this->doc_code.'.json');
        $fields = json_decode($json, true);

        $patients = FE3FDG::select('id', DB::raw("CONCAT(name, ' ', last_name, ' ', mothers_name) AS name"))->get(); // TODO where supervisor or student match somewhere...
        
        $fields['patient_id']['options'] = $patients;

        return $fields;
    }

    public function store(Request $request)
    {
        $validated = $this->validateDoc($request);
        Doc::create($validated);
        return response(200);
    }

    protected function validateDoc($request)
    {
        foreach ($request->except('_token', 'student_id') as $data => $value) {
            $valids[$data] = "required";
        }
        return $request->validate($valids);
    }

    public function show(Rs $rs)
    {
        //
    }

    public function edit(Rs $rs)
    {
        //
    }

    public function update(Request $request, Rs $rs)
    {
        //
    }

    public function destroy(Rs $rs)
    {
        //
    }

    protected function dirname_r($path, $count=1){
        if ($count > 1) {
           return dirname($this->dirname_r($path, --$count));
        } else {
           return dirname($path);
        }
    }
}
