@if (count($errors->getBags()))
<div class="container-fluid mt-2">
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->getBags() as $bag)
                @foreach ($bag->getMessages() as $messages)
                    @foreach ($messages as $message)
                        <li> @lang($message)</li>
                    @endforeach
                @endforeach
            @endforeach
        </ul>
    </div>
</div>
@endif

@if(session()->has('success'))
<div class="container-fluid mt-2">
    <div class="alert alert-success">
         @lang(session()->get('success'))
    </div>
</div>
@endif
