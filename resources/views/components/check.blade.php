<div class="control">
    <label class="checkbox">
        <input type="checkbox" @if(old($field)) checked @endif value="1" name="{{ $field }}">
         {{ $title }}
    </label>
</div>