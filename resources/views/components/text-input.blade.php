<text-input class="field" inline-template
    {{ $errors->has($title) ? ":error=true" : '' }}
    title="{{ $title }}">
    <div>
    <label class="label">{{ $title }}</label>
    {{-- <label class="label">{{ $field['title'] }}</label> --}}
    <div class="control">
        <input name="{{ $title }}"
            class="input{{ $errors->has($title)? ' is-danger':'' }}"
            type="{{ $type }}"
            value="{{  old($title) }}"
            @if ($type == "number")
            min=0
            step=1
            @endif
            placeholder="{{ $title }}"
            v-on:input="clearError"
            ref="{{ $title }}"
            >
    </div>
    @if ($errors->has($title))
    <p v-if="hasError" class="help is-danger">{{ $errors->first($title) }}</p>
    @endif
    </div>
</text-input>