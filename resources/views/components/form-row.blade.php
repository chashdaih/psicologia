<th>{{$title}}</th>
<td>
    <div class="field">
        <div class="control">
            <input type="number" min="0" max="6" required name="{{$field}}" value="{{old($field, $inst[$field])}}" class="input {{$errors->has($field)? ' is-danger':'' }}" placeholder="0 - 6">
        </div>
        @if ($errors->has($field))
        <p class="help is-danger">{{ $errors->first($field) }}</p>
        @endif
    </div>
</td>