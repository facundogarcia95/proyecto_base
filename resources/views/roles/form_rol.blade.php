


    <input type="hidden" id="id" name="id" value="">
    <div class="form-row mb-4">
        <div class="form-group col-md-3 text-center">
            <label for='is_admin'>@lang('form.is_admin'):</label>
            <div class="w-100 ml-2">
                <div class="toggle-btn active">
                    <input type="checkbox" name="is_admin" id="is_admin" class="cb-value" />
                    <span class="round-btn"></span>
                </div>
            </div>
        </div>
        <div class="form-group col-md-4">
            <label for="name">@lang('form.name')</label>
            <input name="name" type="text" class="form-control"  maxlength="100" id="name" placeholder="@lang('form.name')" required>
        </div>
        <div class="form-group col-md-5">
            <label for="description">@lang('form.description')</label>
            <input name="description" type="text" class="form-control"  maxlength="255" id="description" placeholder="@lang('form.description')" required>
        </div>

    </div>

<button  type="button" data-dismiss="modal" class="btn btn-danger rounded">@lang('form.cancel') <i class="fa fa-times"></i></button>
<button type="submit" class="btn btn-success rounded pull-right">@lang('form.save') <i class="fa fa-save"></i></button>
