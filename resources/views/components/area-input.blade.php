<text-input class="field" inline-template
    {{ $errors->has($title) ? ":error=true" : '' }}
    title="{{ $title }}">
    <div>
    <label class="label">{{ $field['title'] }}</label>
    <div class="control">
        <textarea name="{{ $title }}"
            class="textarea{{ $errors->has($title)? ' is-danger':'' }}"
            placeholder="{{ $field['title'] }}"
            v-on:input="clearError"
            ref="{{ $title }}"
            >{{  old($title) }}</textarea>
    </div>
    @if ($errors->has($title))
    <p v-if="hasError" class="help is-danger">{{ $errors->first($title) }}</p>
    @endif
    </div>
</text-input>