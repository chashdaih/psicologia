<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConfiguracionController extends Controller
{
    public function index()
    {
        return view('configuracion');
    }

    public function update(Request $request)
    {
        $data = [
            'semestres' => json_decode($request->semestres),
            'semestre_activo' => $request->semestre_activo,
        ];
        $this->writeConfig('globales', $data);
        return redirect()->route('configuracion.index')->with('success', 'La configuración se actualizó.');
    }

    function writeConfig($filename, $data)
    {
        $ogData = config($filename);
        foreach ($data as $key => $value) {
            $ogData[$key] = $value;
        }
        $filePath = config_path().'/'.$filename.'.php';
        \file_put_contents($filePath, "<?php\n return ".var_export($ogData,1)." ;");
        \Illuminate\Support\Facades\Artisan::call('cache:clear');
    }
}
