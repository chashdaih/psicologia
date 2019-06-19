<td>
    @if(isset($data))
    <input type="hidden" name="acts[]" value={{$data->id}} >
    @endif
    @component('components.simple-text', [
        'title'=>'Semana',
        'field'=>'semana[]',
        'errors'=>$errors,
        'type'=> 'text',
        'prev' => isset($data)?$data->semana:null,
        'maxlength' => 250
        ])@endcomponent
</td>
<td>
    @component('components.area-input', [
        'title'=>'',
        'field'=>'actividad[]',
        'errors'=>$errors,
        'type'=> 'text',
        'prev' => isset($data)?$data->actividad:null
        ])@endcomponent
</td>
<td>
    @component('components.area-input', [
        'title'=>'',
        'field'=>'competencias[]',
        'errors'=>$errors,
        'type'=> 'text',
        'prev' => isset($data)?$data->competencias:null
        ])@endcomponent
</td>