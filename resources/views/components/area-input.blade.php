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
            >{{  old($field) }}</textarea>
    </div>
    @if ($errors->has($field))
    <p v-if="hasError" class="help is-danger">{{ $errors->first($field) }}</p>
    @endif
    </div>
</text-input>