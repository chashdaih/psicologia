<text-input class="field" inline-template
    {{ $errors->has($title) ? ":error=true" : '' }}
    title="{{ $title }}">
    <div>
    <label class="label">{{ $title }}</label>
    <div class="control">
        <div class="select">
            <select name="{{ $field }}">
                @foreach ($options as $key=>$value)
                <option value="{{ $key }}"
                    @if(old($field, isset($prev)?$prev:null))
                        @if ($key == old($field, isset($prev)?$prev:null) )
                        selected="selected"
                        @endif
                    @endif
                    >{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>
    @if ($errors->has($title))
    <p v-if="hasError" class="help is-danger">{{ $errors->first($title) }}</p>
    @endif
    </div>
</text-input>