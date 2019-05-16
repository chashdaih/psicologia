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
            'cupo_actual' => 'required|integer|min:0',
            'id_centro' => 'required',
            'id_supervisor' => 'required',
            // 'id_supervisord' => 'required',
            'periodicidad' => 'required|integer|min:0|max:4',
            'programa' => 'required',
            'tipo' => 'required',
            // program data
            'resumen' => 'required',
            'justificacion'=> 'required',
            'objetivo_g' => 'required',
            'objetivo_es' => 'required',
            'cont_tematico' => 'required',
            // 'criterios_eva' => 'required', // old
            'requisitos' => 'required',
            'referencias' => 'required',
            'estra_ev_imp' => 'required',
            'asig_emp' => 'required',
            // caracteristicas servicio
            // 'dirigido_a' => 'required', // old
            'fecha_inicio' => 'required',
            'fecha_fin' => 'required',
            'gen_horas_total' => 'required|integer|min:0',
            'gen_l'=> 'nullable|boolean',
            'gen_hora_l'=> 'nullable',
            'gen_ma'=> 'nullable|boolean',
            'gen_hora_ma'=> 'nullable',
            'gen_mi'=> 'nullable|boolean',
            'gen_hora_mi'=> 'nullable',
            'gen_j'=> 'nullable|boolean',
            'gen_hora_j'=> 'nullable',
            'gen_v'=> 'nullable|boolean',
            'gen_hora_v'=> 'nullable',
            'gen_s'=> 'nullable|boolean',
            'gen_hora_s'=> 'nullable',
            'serv_horas_total' => 'required',
            'serv_l'=> 'nullable|boolean',
            'serv_hora_l'=> 'nullable',
            'serv_ma'=> 'nullable|boolean',
            'serv_hora_ma'=> 'nullable',
            'serv_mi'=> 'nullable|boolean',
            'serv_hora_mi'=> 'nullable',
            'serv_j'=> 'nullable|boolean',
            'serv_hora_j'=> 'nullable',
            'serv_v'=> 'nullable|boolean',
            'serv_hora_v'=> 'nullable',
            'serv_s'=> 'nullable|boolean',
            'serv_hora_s'=> 'nullable',
            'pacientes_semana' => 'required',
            'minimo_pacientes_semestre' => 'required',
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
            'enfoque_servicio' => 'required',
            'otro_enfoque'=> 'nullable',
                // caracteristicas de la supervisión y evaluación
            'individual'=> 'nullable|boolean',
            'grupal'=> 'nullable|boolean',
            'colaborativa'=> 'nullable|boolean',
            'indirecta'=> 'nullable|boolean',
            'directa'=> 'nullable|boolean',
            'supervision_otra'=> 'nullable',
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
            'ensenanza_otra'=> 'nullable',
                // competencias profesionales a desarrollar
            'fundamentales'=> 'nullable|boolean',
            'entrevista'=> 'nullable|boolean',
            'c_evaluacion'=> 'nullable|boolean',
            'impresion_diagnostica'=> 'nullable|boolean',
            'implementacion_intervenciones'=> 'nullable|boolean',
            'elaboracion_documentos'=> 'nullable|boolean',
            'competencias_otra'=> 'nullable',
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
