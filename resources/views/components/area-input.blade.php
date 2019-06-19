<text-input class="field" inline-template
    {{ $errors->has($field) ? ":error=true" : '' }}
    title="{{ $title }}">
    <div>
    <label class="label">{{ $title }}</label>
    <div class="control">
        <textarea name="{{ $field }}"
            class="textarea{{ $errors->has($field)? ' is-danger':'' }}"
            placeholder="{{ $title }}"
            v-on:input="clearError"
            ref="{{ $title }}"
            @if(isset($required) && $required) required @endif
            @if(isset($maxlength))maxlength={{ $maxlength }}@endif
            >{{  old($field, isset($prev)?$prev:null) }}</textarea>
    </div>
    @if ($errors->has($field))
    <p v-if="hasError" class="help is-danger">{{ $errors->first($field) }}</p>
    @endif
    </div>
</text-input>