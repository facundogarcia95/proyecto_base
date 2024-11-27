
@extends('template.contenido')

@section('contenido')
@include('errors.alert')
<div class="container-fluid mt-2">
    <div class="card">
        <div class="card-header">
            <h2>@lang('specific.roles_list')</h2><br/>
        </div>
        <div class="card-body">
            <form action="{{ route('roles.index') }}" method="get">
                <div class="form-group row">
                    <div class="col-12 col-md-6">
                        <div class="input-group">
                            <input type="text" id="search_text" name="searchText" value="{{ Request::get('searchText') }}" class="form-control" placeholder="@lang('generic.search')" value="">
                            <button  class="btn btn-primary" type="submit"><i class="fa fa-search"></i> @lang('generic.search')</button>
                        </div>

                    </div>
                    <div class="col-12 col-md-6">
                        @if(Auth::user()->rol->is_admin)
                            <button type="button" class="btn btn-primary rounded text-light btn-sm pull-right"  data-toggle="modal" data-target="#addRolModal">
                                <span data-toggle="tooltip" data-placement="bottom" title=" @lang('generic.add') @lang('generic.rol')">
                                        <i class="fa fa-plus"></i> @lang('generic.add') @lang('generic.rol')
                                </span>
                            </button>
                        @endif
                    </div>
                </div>
            </form>
            <table id="table" class="table table-bordered table-striped  dt-responsive nowrap" style="width: 100%" >
                <thead>
                    <tr class="bg-dark text-light">
                        <th>@lang('generic.name')</th>
                        <th>@lang('generic.description')</th>
                        <th>@lang('generic.is_admin')</th>
                        <th>@lang('generic.condition')</th>
                        <th>@lang('generic.actions')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $rol)
                        <tr>
                            <td>{{ $rol->name }}</td>
                            <td>{{ $rol->description }}</td>
                            <td class="text-center">
                               @if ($rol->is_admin)
                                    <i class="fa fa-check-circle fa-2x text-success" aria-hidden="true"></i>
                               @else
                                    <i class="fa fa-times text-danger" aria-hidden="true"></i>
                               @endif
                            </td>
                            <td>
                                @lang("generic.{$rol->getCondition->name}")
                            </td>
                            <td>
                                @if(Auth::user()->rol->is_admin)
                                    <button type="button" class="btn btn-primary rounded text-light btn-sm"
                                        data-id="{{ Crypt::encryptString($rol->id) }}"
                                        data-name="{{ $rol->name }}"
                                        data-description="{{ $rol->description }}"
                                        data-is_admin="{{ $rol->is_admin }}"
                                        data-toggle="modal" data-target="#editRolModal">
                                        <span data-toggle="tooltip" data-placement="bottom" title=" @lang('generic.edit') @lang('generic.rol')">
                                            <i class="fa fa-edit"></i>
                                        </span>
                                    </button>
                                    @if($rol->condition == 1)
                                        <button type="button" class="btn btn-danger rounded btn-sm"
                                            data-id="{{  Crypt::encryptString($rol->id) }}"
                                            data-toggle="modal" data-target="#changeCondition">
                                            <span data-toggle="tooltip" data-placement="bottom" title=" @lang('generic.change') @lang('generic.condition')">
                                                <i class="fa fa-times"></i>
                                            </span>
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-success rounded btn-sm"
                                            data-id="{{  Crypt::encryptString($rol->id) }}"
                                            data-toggle="modal" data-target="#changeCondition">
                                            <span data-toggle="tooltip" data-placement="bottom" title=" @lang('generic.change') @lang('generic.condition')">
                                                <i class="fa fa-check"></i>
                                            </span>
                                        </button>
                                        <button type="button" class="btn btn-danger rounded btn-sm"
                                            data-id="{{  Crypt::encryptString($rol->id) }}"
                                            data-toggle="modal" data-target="#deleteRole">
                                            <span data-toggle="tooltip" data-placement="bottom" title=" @lang('generic.delete_role')">
                                                <i class="fa fa-trash"></i>
                                            </span>
                                        </button>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{$roles->appends(request()->query())->links()}}<label class="pull-right ">@lang('generic.total_records'): {{$roles->total()}} </label>
        </div>
    </div>
</div>

<div class="modal fade" id="addRolModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dark modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('generic.add') @lang('generic.rol')</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-light">×</span>
                </button>
            </div>

            <div class="modal-body">
                <form action="{{route('roles.store')}}" method="post" class="form-horizontal was-validated" enctype="multipart/form-data" >
                    {{csrf_field()}}
                    @include('roles.form_rol',[])
                </form>
            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="editRolModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dark modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('generic.edit') @lang('generic.rol')</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-light">×</span>
                </button>
            </div>

            <div class="modal-body">
                <form action="{{route('roles.update','update')}}" method="post" class="form-horizontal was-validated" enctype="multipart/form-data">
                    {{method_field('patch')}}
                    {{csrf_field()}}
                        @include('roles.form_rol', [])
                </form>
            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="changeCondition" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dark" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('generic.change_status')</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-light">×</span>
                </button>
            </div>

            <div class="modal-body">
                <form action="{{route('roles.destroy','destroy')}}" method="POST" class="was-validated">
                    {{method_field('delete')}}
                    {{csrf_field()}}

                    <input type="hidden" id="id" name="id" value="">
                    <input type="hidden" name="condition" value="2">

                        <p>@lang('generic.messege_confirm')</p>


                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success rounded">@lang('generic.accept')</button>
                        <button type="button" class="btn btn-danger rounded" data-dismiss="modal">@lang('generic.cancel')</button>
                    </div>

                    </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteRole" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dark" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('generic.delete_role')</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-light">×</span>
                </button>
            </div>

            <div class="modal-body">
                <form action="{{route('roles.destroy','destroy')}}" method="POST" class="was-validated">
                    {{method_field('delete')}}
                    {{csrf_field()}}

                    <input type="hidden" id="id" name="id" value="">
                    <input type="hidden" name="condition" value="3">

                        <p>@lang('generic.messege_confirm')</p>


                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success rounded">@lang('generic.accept')</button>
                        <button type="button" class="btn btn-danger rounded" data-dismiss="modal">@lang('generic.cancel')</button>
                    </div>

                    </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')

    <script>
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();

            /*AGREGAR EN VENTANA MODAL*/
            $('#addRolModal').on('show.bs.modal', function (event) {
                var modal = $(this);
                modal.find('.modal-body .toggle-btn').removeClass('active');
            });

            /*EDITAR EN VENTANA MODAL*/
            $('#editRolModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget)
                var name = button.data('name')
                var description = button.data('description')
                var is_admin = button.data('is_admin')
                var id = button.data('id')
                var modal = $(this)
                modal.find('.modal-body #name').val(name);
                modal.find('.modal-body #description').val(description);
                modal.find('.modal-body #id').val(id);
                modal.find('.modal-body #is_admin').removeAttr("checked");
                modal.find('.modal-body .toggle-btn').removeClass('active');
                if(is_admin){
                    modal.find('.modal-body #is_admin').attr("checked",true);
                    modal.find('.modal-body .toggle-btn').addClass('active');
                }
            });

            $('#changeCondition').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                var modal = $(this);
                modal.find('.modal-body #id').val(id);
            });

            $('#deleteRole').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                var modal = $(this);
                modal.find('.modal-body #id').val(id);
            });

            //$('input.cb-value').prop("checked", true);
            $('.cb-value').on("click",function() {
                var mainParent = $(this).parent('.toggle-btn');
                if($(mainParent).find('input.cb-value').is(':checked')) {
                    $(mainParent).addClass('active');
                    $(this).attr("checked",true)
                } else {
                    $(mainParent).removeClass('active');
                    $(this).removeAttr("checked");
                }
            });

        });
    </script>
@endpush

@push('css')
    <link href="{{asset('css/librerias/toggleswitch.css')}}" rel="stylesheet">
@endpush

@endsection
