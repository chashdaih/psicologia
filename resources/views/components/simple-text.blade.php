<text-input class="field" inline-template
    {{ $errors->has($title) ? ":error=true" : '' }}
    title="{{ $title }}">
    <div>
    <div class="control">
        <input name="{{ $field }}"
            class="input{{ $errors->has($field)? ' is-danger':'' }}"
            type="{{ $type }}"
            value="{{ isset($prev) ? $prev : old($field) }}"
            @if ($type == "number")
            min=0
            step=1
            @elseif ($type == "text")
            @if(isset($maxlength))maxlength={{ $maxlength }}@endif
            @endif
            placeholder="{{ $title }}"
            v-on:input="clearError"
            ref="{{ $title }}"
            v-on:keydown.enter.prevent
            >
    </div>
    @if ($errors->has($field))
    <p v-if="hasError" class="help is-danger">{{ $errors->first($field) }}</p>
    @endif
    </div>
</text-input>