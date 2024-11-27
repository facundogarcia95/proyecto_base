


@extends('template.contenido')

@section('contenido')
@include('errors.alert')
<div class="container-fluid mt-2">
    <div class="card">
        <div class="card-header">
            <h2>@lang('specific.permissions_list')</h2><br/>
        </div>
        <div class="card-body">
            <form action="{{ route('permissions.index') }}" method="get">
                <div class="form-group row">
                    <div class="col-12 col-md-6">
                        <div class="input-group">
                            <input type="text" id="search_text" name="searchText" value="{{ Request::get('searchText') }}" class="form-control" placeholder="@lang('generic.search')" value="">
                            <button  class="btn btn-primary" type="submit"><i class="fa fa-search"></i> @lang('generic.search')</button>
                        </div>
                    </div>
                </div>
            </form>
            <ul class="todo-list"  style="overflow-x: hidden;">
                @foreach ($roles as $rol)
                    @php
                        $permissions_rol = $permissions->where('id_rol','=',$rol->id)->values();
                    @endphp

                    <li class="itemSlide" id="{{$rol->id}}">

                        <div class="box-group" id="accordion">

                            <!--=====================================
                                CAJA GESTOR SLIDE
                            ======================================-->

                            <div class="panel box box-info">

                                <!--=====================================
                                        CABEZA DE LA CAJA GESTOR SLIDE
                                ======================================-->

                                <div class="box-header with-border">

                                    <span class="handle">
                                    <i class="fa fa-ellipsis-v"></i>
                                    <i class="fa fa-ellipsis-v"></i>
                                    </span>

                                    <h4 class="box-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{$rol->id}}">
                                            <p class="text-uppercase">{{$rol->name}}</p>
                                        </a>
                                    </h4>

                                </div>

                                <!--=====================================
                                MÓDULOS COLAPSABLES
                                ======================================-->

                                <div id="{{'collapse'.$rol->id}}" class="panel-collapse collapse collapseSlide">


                                         <!--=====================================
                                                MODIFICAR NOMBRE SLIDE
                                        ======================================-->

                                    <table id="table" class="table table-bordered table-striped dt-responsive nowrap" style="width: 100%" >
                                        <thead>
                                            <tr class="bg-dark text-light">

                                                <th></th>
                                                <th>@lang('generic.controller')</th>
                                                <th>@lang('generic.action')</th>
                                                <th>@lang('generic.name')</th>
                                                <th>@lang('generic.description')</th>
                                                <th>@lang('generic.condition')</th>
                                                <th>@lang('generic.actions')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $controller_aux = null;
                                            @endphp
                                            @foreach ($routes as $route)
                                                @php
                                                    $permission_exists = $permissions_rol->where('controller','=',$route->controller)->where('action','=',$route->action)->first();
                                                    $class_collapse = ($controller_aux == $route->controller) ? "collapse $route->controller" : "";
                                                @endphp
                                            <tr class="{{ $class_collapse }}">
                                                @if (empty($class_collapse))
                                                    <td colspan="">
                                                        <button class="btn btn-primary btn-sm btn-collapse" data-target="{{$route->controller}}">
                                                            <i class="fa fa-bars" aria-hidden="true"></i>
                                                        </button>
                                                    </td>
                                                @else
                                                    <td></td>
                                                @endif
                                                @php
                                                    $controller_aux = $route->controller;
                                                @endphp
                                                <td>{{ $route->controller }}</td>
                                                <td>{{ $route->action }}</td>
                                                <td>{{ $route->name }}</td>
                                                <td>{{ !empty($permission_exists) ? (!empty($temp = $permission_exists->description) ? $temp : Lang::get('generic.not_description') ) : Lang::get('generic.not_description') }}</td>
                                                <td class="text-center">{!!
                                                        !empty($permission_exists)
                                                        ? '<i class="fa fa-2x text-success fa-check-circle" aria-hidden="true"></i>'
                                                        : '<i class="fa fa-2x text-danger fa-times-circle" aria-hidden="true"></i>'
                                                    !!}
                                                </td>
                                                <td class="text-center">
                                                    @if(!empty($permission_exists))
                                                        <button type="button" class="btn btn-danger rounded btn-sm"
                                                            data-id="{{  Crypt::encryptString($permission_exists->id) }}"
                                                            data-toggle="modal" data-target="#changeCondition">
                                                            <span data-toggle="tooltip" data-placement="bottom" title=" @lang('generic.change') @lang('generic.condition')">
                                                                <i class="fa fa-trash"></i>
                                                            </span>
                                                        </button>
                                                    @else
                                                        <button type="button" class="btn btn-primary rounded btn-sm"
                                                            data-id=""
                                                            data-controller="{{ Crypt::encryptString($route->controller) }}"
                                                            data-action="{{ Crypt::encryptString($route->action) }}"
                                                            data-name="{{ Crypt::encryptString($route->name) }}"
                                                            data-id_rol="{{ Crypt::encryptString($rol->id) }}"
                                                            data-toggle="modal" data-target="#changeCondition">
                                                            <span data-toggle="tooltip" data-placement="bottom" title=" @lang('generic.add')">
                                                                <i class="fa fa-plus-circle"></i>
                                                            </span>
                                                        </button>
                                                    @endif
                                                </td>
                                            </tr>


                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            </div>

                        </div>

                    </li>

                @endforeach

            </ul>
        </div>
    </div>
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
                <form action="{{route('permissions.update','update')}}" method="POST" class="was-validated">
                    {{method_field('patch')}}
                    {{csrf_field()}}

                    <input type="hidden" id="id" name="id" value="">
                    <input type="hidden" id="controller" name="controller" value="">
                    <input type="hidden" id="action" name="action" value="">
                    <input type="hidden" id="name" name="name" value="">
                    <input type="hidden" id="id_rol" name="id_rol" value="">
                    <div class="form-row add-description" style="display: none;">
                        <div class="form-group col-md-12">
                            <label for="email">@lang('form.add_description')</label>
                            <input type="text" id="description" name="description" placeholder="@lang('form.description_permission')" class="form-control" value="">
                        </div>
                    </div>
                    <p>@lang('generic.messege_confirm')</p>


                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success rounded">@lang('generic.accept')</button>
                        <button type="button" class="btn btn-danger rounded" data-dismiss="modal">@lang('generic.cancel')</button>
                    </div>

                    </form>
            </div>
        <!-- /.modal-content -->
        </div>
    <!-- /.modal-dialog -->
    </div>
</div>



@push('scripts')
    <script>
        $(document).ready(function () {
            $('#changeCondition').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                var controller = button.data('controller');
                var action = button.data('action');
                var name = button.data('name');
                var id_rol = button.data('id_rol');
                var modal = $(this);
                if(!id){
                    modal.find('.modal-body .add-description').show();
                }else{
                    modal.find('.modal-body.add-description').hide();
                }
                modal.find('.modal-body #id').val(id);
                modal.find('.modal-body #controller').val(controller);
                modal.find('.modal-body #action').val(action);
                modal.find('.modal-body #name').val(name);
                modal.find('.modal-body #id_rol').val(id_rol);

            });
            $(".btn-collapse").on("click",function(){
                let clase = $(this).data("target");
                $("."+clase).collapse('toggle');
            })
        });
    </script>
@endpush

@push('css')
<link href="{{asset('css/librerias/adminlte.min.css')}}" rel="stylesheet">

@endpush

@endsection
