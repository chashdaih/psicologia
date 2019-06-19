<td>
    @if(isset($data))
    <input type="hidden" name="crits[]" value={{$data->id}} >
    @endif
    @component('components.simple-text', [
        'title'=>'Criterio de acreditación',
        'field'=>'criterio[]',
        'errors'=>$errors,
        'type'=> 'text',
        'prev' => isset($data)?$data->criterio:null,
        'maxlength' => 250
        ])@endcomponent
</td>
<td>
    @component('components.area-input', [
        'title'=> null,
        'field'=>'cuando[]',
        'errors'=>$errors,
        'type'=> 'text',
        'prev' => isset($data)?$data->cuando:null,
        'maxlength' => 250
        ])@endcomponent
</td>
<td>
    @component('components.area-input', [
        'title'=>null,
        'field'=>'como[]',
        'errors'=>$errors,
        'type'=> 'text',
        'prev' => isset($data)?$data->como:null,
        'maxlength' => 250
        ])@endcomponent
</td>