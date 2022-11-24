


    <input type="hidden" id="id" name="id" value="">
    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="email">@lang('form.email')</label>
            <input name="email"  type="email"  maxlength="50" class="form-control" id="email" placeholder="@lang('form.email')" required>
        </div>
        <div class="form-group col-md-4">
            <label for="name">@lang('form.name')</label>
            <input name="name" type="text" class="form-control"  maxlength="100" id="name" placeholder="@lang('form.name')" required>
        </div>
        <div class="form-group col-md-4">
            <label for="user">@lang('form.user')</label>
            <input name="user" type="text" class="form-control"  maxlength="255" id="user" placeholder="@lang('form.user')" required>
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
        <div class="form-group  col-md-4">
            <label for="num_doc">@lang('form.num_doc')</label>
            <input name="num_doc" type="text" maxlength="20" class="form-control" id="num_doc" placeholder="@lang('form.num_doc')">
        </div>
        <div class="form-group col-md-4">
            <label for="cel_number">@lang('form.cel_number')</label>
            <input data-inputmask="'mask': '(999)-15-9999999'" data-mask="" type="text" name="cel_number"  maxlength="20" class="form-control" id="cel_number" placeholder="@lang('form.cel_number')">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="adress">@lang('form.adress')</label>
            <input type="text" class="form-control"  maxlength="70" id="adress" name="adress" placeholder="@lang('form.adress')">
        </div>
        <div class="form-group col-md-4">
            <label for="id_business">@lang('form.business')</label>
            <select name="id_business" id="id_business"  class="form-control" required>
                <option value="" disabled selected>@lang('form.select')...</option>
                @foreach($business as $busine)
                    <option value="{{ $busine->id }}">{{ $busine->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-4" style="display: none;" id="select-rol">
            <label for="id_rol">@lang('form.rol')</label>
            <select name="id_rol" id="id_rol"  class="form-control" required>
                <option value="" disabled selected>@lang('form.select')...</option>
                @foreach($roles as $rol)
                    <option value="{{ $rol->id }}">{{ $rol->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-4" style="display: none;" id="user_attached">
            <label for="id_user_attached">@lang('form.user_attached')</label>
            <select name="id_user_attached" id="id_user_attached"  class="form-control" required>
                <option value="" disabled selected>@lang('form.select')...</option>
            </select>
        </div>
    </div>
    <button  type="button" data-dismiss="modal" class="btn btn-danger rounded">@lang('form.cancel') <i class="fa fa-times"></i></button>
  <button type="submit" class="btn btn-success rounded pull-right">@lang('form.save') <i class="fa fa-save"></i></button>
