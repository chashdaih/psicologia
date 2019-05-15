<text-input class="field" inline-template
    {{ $errors->has($title) ? ":error=true" : '' }}
    title="{{ $title }}">
    <div>
    <label class="label">{{ $title }}</label>
    <div class="control">
        <div class="select">
            <select name="{{ $field }}"  >
                {{-- <option value="0" disabled>Seleccione una opción</option> --}}
                @foreach ($options as $option)
                <option :value="{{ $option->primary_key }}">{{ $option->full_name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    @if ($errors->has($title))
    <p v-if="hasError" class="help is-danger">{{ $errors->first($title) }}</p>
    @endif
    </div>
</text-input>