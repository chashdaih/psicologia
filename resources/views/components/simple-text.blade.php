<text-input class="field" inline-template
    {{ $errors->has($title) ? ":error=true" : '' }}
    title="{{ $title }}">
    <div>
    <div class="control">
        <input name="{{ $field }}"
            class="input{{ $errors->has($field)? ' is-danger':'' }}"
            type="{{ $type }}"
            value="{{  old($field) }}"
            @if ($type == "number")
            min=0
            step=1
            @endif
            placeholder="{{ $title }}"
            v-on:input="clearError"
            ref="{{ $title }}"
            >
    </div>
    @if ($errors->has($field))
    <p v-if="hasError" class="help is-danger">{{ $errors->first($field) }}</p>
    @endif
    </div>
</text-input>