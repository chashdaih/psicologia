<td>
    @if(isset($data))
    <input type="hidden" name="insitu[]" value={{$data->id}} >
    @endif
    <related-input inline-template
    @if(isset($data) && $data->full_name != null) old-value=1 @endif
    >
        <div>
            <div class="control">
                <label class="checkbox">
                    <input v-model="selected" type="checkbox" value="1">
                    Otro supervisor
                </label>
            </div>
            <span v-show="selected">
                @component('components.text-input', [
                    'title'=>'Nombre completo',
                    'field'=>'full_name[]',
                    'errors'=>$errors,
                    'type'=> 'text',
                    'prev' => isset($data)?$data->full_name:null
                    ])@endcomponent
                @component('components.text-input', [
                    'title'=>'Adscripción',
                    'field'=>'ascription[]',
                    'errors'=>$errors,
                    'type'=> 'text',
                    'prev' => isset($data)?$data->ascription:null
                    ])@endcomponent
                @component('components.text-input', [
                    'title'=>'Nombramiento',
                    'field'=>'nomination[]',
                    'errors'=>$errors,
                    'type'=> 'text',
                    'prev' =>isset($data)?$data->nomination:null
                    ])@endcomponent
                @component('components.text-input', [
                    'title'=>'Teléfono',
                    'field'=>'phone[]',
                    'errors'=>$errors,
                    'type'=> 'text',
                    'prev' => isset($data)?$data->full_name:null
                    ])@endcomponent
                @component('components.text-input', [
                    'title'=>'Celular',
                    'field'=>'cellphone[]',
                    'errors'=>$errors,
                    'type'=> 'text',
                    'prev' => isset($data)?$data->cellphone:null
                    ])@endcomponent
                @component('components.text-input', [
                    'title'=>'Correo electrónico',
                    'field'=>'email[]',
                    'errors'=>$errors,
                    'type'=> 'email',
                    'prev' => isset($data)?$data->email:null
                    ])@endcomponent
                @component('components.text-input', [
                    'title'=>'Número de trabajador / número de cuenta / RFC',
                    'field'=>'worker_number[]',
                    'errors'=>$errors,
                    'type'=> 'text',
                    'prev' => isset($data)?$data->worker_number:null
                    ])@endcomponent
            </span>
            <span v-show="!selected">
                {{-- <div class="control">
                    <div class="select">
                        <select name="reg_sup_id[]">
                            @foreach ($supervisors as $option)
                            <option value="{{ $option->primary_key }}"
                                @if (isset($data))
                                    @if($data->reg_sup_id == $option->primary_key)
                                    selected="selected"
                                    @endif
                                @else
                                    @if($user_id == $option->primary_key)
                                    selected="selected"
                                    @endif
                                @endif
                                >{{ $option->full_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div> --}}
                <sups-auto field="reg_sup_id[]"
                    :sups="{{$supervisors}}"
                    @if(isset($data))
                    :user="{{$data->reg_sup_id}}"
                    @else
                    :user="{{$user_id}}"
                    @endif
                ></sups-auto>
            </span>
        </div>
    </related-input>
</td>