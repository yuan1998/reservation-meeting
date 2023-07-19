@if(is_array($value))
    @foreach($value as $key=>$item)
        <div style="width: 300px;word-wrap: break-word;white-space: pre-wrap;">
            {{$key}} : {{is_array($item) ? json_encode($item,JSON_UNESCAPED_UNICODE) : $item}}
        </div>
    @endforeach
@else
    <div style="width: 300px;word-wrap: break-word;white-space: pre-wrap;">
        {{$value}}
    </div>
@endif
