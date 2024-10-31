{{-- @php $bag = (isset($bag)) ? $bag : ''; @endphp

@if ($errors->{$bag}->any())

    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->{$bag}->all() as $error)
                <li>
                    <span>{{ $error }}</span>

                </li>
            @endforeach
        </ul>
    </div>
@endif --}}

@if(count($errors) > 0)
    <ul class="list-group my-3">
        @foreach ($errors->all() as $error)
            <div class="list-group-item list-group-item-danger">{{ $error }}</div>
        @endforeach
    </ul>
@endif
