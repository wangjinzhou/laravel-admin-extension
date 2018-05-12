<div class="btn-group" data-toggle="buttons">
    @foreach($options as $option => $label)
        <label class="btn btn-default btn-sm {{ \Request::get('is_verify', '0') == $option ? 'active' : '' }}">
            <input type="radio" class="is_verify" value="{{ $option }}">{{$label}}
        </label>
    @endforeach
</div>