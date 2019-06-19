<text-input class="field" inline-template
    {{ $errors->has($field) ? ":error=true" : '' }}
    title="{{ $title }}"
    type="{{ $type }}"
    >
    <div>
    <label class="label">{{ $title }}</label>
    <div class="control">
        <input name="{{ $field }}"
            class="input{{ $errors->has($field)? ' is-danger':'' }}"
            type="{{ $type }}"
            value="{{ isset($prev) ? $prev : old($field) }}"
            @if ($type == "number")
            min=0
            max=255
            step=1
            @elseif ($type == "text")
            @if(isset($maxlength))maxlength={{ $maxlength }}@endif
            @endif
            placeholder="{{ $title }}"
            v-on:input="clearError"
            ref="{{ $title }}"
            @if(isset($required) && $required) required @endif
            v-on:keypress="isNumber($event)"
            {{-- v-on:change="isNumber" --}}
            @if(!isset($send))
            v-on:keydown.enter.prevent
            @endif
            >
    </div>
    @if ($errors->has($field))
    <p v-if="hasError" class="help is-danger">{{ $errors->first($field) }}</p>
    @endif
    </div>
</text-input>