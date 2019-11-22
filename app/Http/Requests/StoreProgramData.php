<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProgramData extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // program
            'cupo' => 'nullable|integer|min:0|max:255', //
            'id_centro' => 'required|min:1|max:50',
            'id_supervisor' => 'required|min:1',
            'periodicidad' => 'nullable|integer|min:0|max:4', //
            'programa' => 'required|max:250', //
            'tipo' => 'required',
            'semestre_activo' => 'required',
            // program data
            'resumen' => 'nullable',
            'justificacion'=> 'nullable',
            'objetivo_g' => 'nullable',
            'objetivo_es' => 'nullable',
            'cont_tematico' => 'nullable',
            'requisitos' => 'nullable',
            'referencias' => 'nullable',
            'estra_ev_imp' => 'nullable',
            'asig_emp' => 'nullable',
            // caracteristicas servicio
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date',
            'gen_horas_total' => 'nullable|integer|min:0|max:255',
            'gen_l'=> 'nullable|boolean',
            'gen_hora_l'=> 'nullable|string|max:255',
            'gen_ma'=> 'nullable|boolean',
            'gen_hora_ma'=> 'nullable|string|max:255',
            'gen_mi'=> 'nullable|boolean',
            'gen_hora_mi'=> 'nullable|string|max:255',
            'gen_j'=> 'nullable|boolean',
            'gen_hora_j'=> 'nullable|string|max:255',
            'gen_v'=> 'nullable|boolean',
            'gen_hora_v'=> 'nullable|string|max:255',
            'gen_s'=> 'nullable|boolean',
            'gen_hora_s'=> 'nullable|string|max:255',
            'serv_horas_total' => 'nullable|integer|min:0|max:255',
            'serv_l'=> 'nullable|boolean',
            'serv_hora_l'=> 'nullable|string|max:255',
            'serv_ma'=> 'nullable|boolean',
            'serv_hora_ma'=> 'nullable|string|max:255',
            'serv_mi'=> 'nullable|boolean',
            'serv_hora_mi'=> 'nullable|string|max:255',
            'serv_j'=> 'nullable|boolean',
            'serv_hora_j'=> 'nullable|string|max:255',
            'serv_v'=> 'nullable|boolean',
            'serv_hora_v'=> 'nullable|string|max:255',
            'serv_s'=> 'nullable|boolean',
            'serv_hora_s'=> 'nullable|string|max:255',
            'pacientes_semana' => 'nullable|integer|min:0|max:255',
            'minimo_pacientes_semestre' => 'nullable|integer|min:0|max:255',
            'primer_contacto'=> 'nullable',
            'admision'=> 'nullable|boolean',
            'evaluacion'=> 'nullable|boolean',
            'orientacion'=> 'nullable|boolean',
            'intervencion'=> 'nullable|boolean',
            'egreso'=> 'nullable|boolean',
                //problematica atendida
            'depresion'=> 'nullable|boolean',
            'duelo'=> 'nullable|boolean',
            'psicosis'=> 'nullable|boolean',
            'epilepsia'=> 'nullable|boolean',
            'demencia'=> 'nullable|boolean',
            'emocionales_niños'=> 'nullable|boolean',
            'emocionales_ad'=> 'nullable|boolean',
            'desarrollo_niños'=> 'nullable|boolean',
            'conductuales_niños'=> 'nullable|boolean',
            'conductuales_ad'=> 'nullable|boolean',
            'autolesion'=> 'nullable|boolean',
            'ansiedad'=> 'nullable|boolean',
            'estres'=> 'nullable|boolean',
            'sexualidad'=> 'nullable|boolean',
            'violencia'=> 'nullable|boolean',
            'sustancias'=> 'nullable|boolean',
            'p_intervencion'=> 'nullable|boolean',
            'enfoque_servicio' => 'required|integer|min:0|max:255',
            'otro_enfoque'=> 'nullable|string|max:255',
                // caracteristicas de la supervisión y evaluación
            'individual'=> 'nullable|boolean',
            'grupal'=> 'nullable|boolean',
            'colaborativa'=> 'nullable|boolean',
            'indirecta'=> 'nullable|boolean',
            'directa'=> 'nullable|boolean',
            'supervision_otra'=> 'nullable|string|max:255',
                // estratedias de enseñanza y supervisión
            'observacion'=> 'nullable|boolean',
            'juego_roles'=> 'nullable|boolean',
            'modelamiento'=> 'nullable|boolean',
            'moldeamiento'=> 'nullable|boolean',
            'cascada'=> 'nullable|boolean',
            'auto_supervision'=> 'nullable|boolean',
            'equipo_reflexivo'=> 'nullable|boolean',
            'con_colegas'=> 'nullable|boolean',
            'analisis_caso'=> 'nullable|boolean',
            'ensenanza_otra'=> 'nullable|string|max:255',
                // competencias profesionales a desarrollar
            'fundamentales'=> 'nullable|boolean',
            'entrevista'=> 'nullable|boolean',
            'c_evaluacion'=> 'nullable|boolean',
            'impresion_diagnostica'=> 'nullable|boolean',
            'implementacion_intervenciones'=> 'nullable|boolean',
            'elaboracion_documentos'=> 'nullable|boolean',
            'competencias_otra'=> 'nullable|string|max:255',
                // estrategias de evaluación de competencias
            'formativa'=> 'nullable|boolean',
            'integrativa'=> 'nullable|boolean',
            'contextual'=> 'nullable|boolean',
            'holistica'=> 'nullable|boolean',
            'plural'=> 'nullable|boolean',
            'reflexiva'=> 'nullable|boolean',
            // TODO fix this
            // // programa semana
            // 'semana.*' => 'required',
            // 'actividad.*' => 'required',
            // 'competencias.*' => 'required',
            // // evaluate students
            // 'e1.*' => 'required',
            // 'e2.*' => 'required',
            // 'e3.*' => 'required',
        ];
    }
}
