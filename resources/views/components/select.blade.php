<text-input class="field" inline-template
    {{ $errors->has($title) ? ":error=true" : '' }}
    title="{{ $title }}">
    <div>
    <label class="label">{{ $title }}</label>
    <div class="control">
        <div class="select">
            <select name="{{ $field }}">
                @foreach ($options as $option)
                <option value="{{ $option->primary_key }}"
                    @if(old($field, isset($prev)?$prev:null))
                        @if ($option->primary_key == old($field, isset($prev)?$prev:null) )
                        selected="selected"
                        @endif
                    @else
                        @if (isset($id) && $option->primary_key == $id )
                        selected="selected"
                        @endif
                    @endif

                    >{{ str_limit($option->full_name, 100) }}</option>
                @endforeach
            </select>
        </div>
    </div>
    @if ($errors->has($title))
    <p v-if="hasError" class="help is-danger">{{ $errors->first($title) }}</p>
    @endif
    </div>
</text-input>