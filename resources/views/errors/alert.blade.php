@if (count($errors->getBags()))
<div class="container-fluid mt-2">
    <div class="alert alert-danger">
        <p><label class="h4"><u>@lang('generic.errors_tittle')</u></label></p>
        <ul>
            @foreach ($errors->getBags() as $bag)
                <li style="list-style: none;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </li>
                @foreach ($bag->getMessages() as $messages)
                    @foreach ($messages as $message)
                        <li> @lang($message) </li>
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
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
    </div>
</div>
@endif
