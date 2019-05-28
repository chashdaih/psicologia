<td>
    @if(isset($data))
    <input type="hidden" name="crits[]" value={{$data->id}} >
    @endif
    @component('components.simple-text', [
        'title'=>'Criterios de acreditación',
        'field'=>'criterio[]',
        'errors'=>$errors,
        'type'=> 'text',
        'prev' => isset($data)?$data->criterio:null
        ])@endcomponent
</td>
<td>
    @component('components.simple-text', [
        'title'=>'¿Cuándo se mide?',
        'field'=>'cuando[]',
        'errors'=>$errors,
        'type'=> 'text',
        'prev' => isset($data)?$data->cuando:null
        ])@endcomponent
</td>
<td>
    @component('components.simple-text', [
        'title'=>'¿Cómo se mide?',
        'field'=>'como[]',
        'errors'=>$errors,
        'type'=> 'text',
        'prev' => isset($data)?$data->como:null
        ])@endcomponent
</td>