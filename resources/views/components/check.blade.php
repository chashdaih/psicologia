<div class="control">
    <label class="checkbox">
        <input type="checkbox" @if(old($field, isset($prev)?$prev:null)) checked @endif value="1" name="{{ $field }}">
         {{ $title }}
    </label>
</div>