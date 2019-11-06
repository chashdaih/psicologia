<?php

namespace App\Http\Controllers;

use App\Supervisor;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function reception($centerId) {
        return DB::table('fe3fdg')
        ->select('file_number', 'created_at', 'user_id', 'name', 'last_name', 'mothers_name', 'birthdate', 'gender', 'marital_status')
        // ->join('supervisores', 'fe3fdg.user_id', 'supervisores.id_supervisor')
        ->where('center_id', $centerId)
        ->get();
    }

    public function supervisors()
    {
        return Supervisor::all();
    }
}
