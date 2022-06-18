


    <input type="hidden" id="id" name="id" value="">
    <div class="form-row">
        <div class="form-group col-md-6">
        <label for="email">@lang('form.email')</label>
        <input name="email"  type="email"  maxlength="50" class="form-control" id="email" placeholder="@lang('form.email')">
        </div>
        <div class="form-group col-md-6">
        <label for="name">@lang('form.name')</label>
        <input name="name" type="text" class="form-control"  maxlength="100" id="name" placeholder="@lang('form.name')">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="type_doc">@lang('form.type_doc')</label>
            <select name="type_doc" id="type_doc"  class="form-control">
                <option value="" disabled selected>@lang('form.select')...</option>
                @foreach($types_doc as $type)
                    <option value="{{ $type }}">{{ $type }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group  col-md-8">
            <label for="num_doc">@lang('form.num_doc')</label>
            <input name="num_doc" type="text" maxlength="20" class="form-control" id="num_doc" placeholder="@lang('form.num_doc')">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="adress">@lang('form.adress')</label>
            <input type="text" class="form-control"  maxlength="70" id="adress" name="adress" placeholder="@lang('form.adress')">
        </div>
        <div class="form-group col-md-4">
            <label for="cel_number">@lang('form.cel_number')</label>
            <input data-inputmask="'mask': '(999)-15-9999999'" data-mask="" type="text" name="cel_number"  maxlength="20" class="form-control" id="cel_number" placeholder="@lang('form.cel_number')">
        </div>
        <div class="form-group col-md-4">
            <label for="idrol">@lang('form.rol')</label>
            <select name="idrol" id="idrol"  class="form-control">
                <option value="" disabled selected>@lang('form.select')...</option>
                @foreach($roles as $rol)
                    <option value="{{ $rol->id }}">{{ $rol->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <button  type="button" data-dismiss="modal" class="btn btn-danger rounded">@lang('form.cancel') <i class="fa fa-times"></i></button>
  <button type="submit" class="btn btn-success rounded pull-right">@lang('form.save') <i class="fa fa-save"></i></button>
