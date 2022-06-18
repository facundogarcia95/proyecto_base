
@extends('dashboard.dashboard')

@section('contenido')

@include('errors.alert')
<div class="container-fluid mt-2">
    <div class="card">
        <div class="card-header">
            <h2>@lang('specific.user_list')</h2><br/>
            @if(Auth::user()->is_admin)
                <button class="btn btn-primary btn-lg rounded" type="button" data-toggle="modal" data-target="#abrirmodal">
                    <i class="fa fa-plus"></i> @lang('generic.add') @lang('generic.user')
                </button>
            @endif
        </div>
        <div class="card-body">
            <form action="{{ route('users.index') }}" method="get">
                <div class="form-group row">
                    <div class="col-12 col-md-6">
                        <div class="input-group">
                            <input type="text" id="search_text" name="searchText" value="{{ Request::get('searchText') }}" class="form-control" placeholder="@lang('generic.search')" value="">
                            <button  class="btn btn-primary" type="submit"><i class="fa fa-search"></i> @lang('generic.search')</button>
                        </div>

                    </div>
                    <div class="col-12 col-md-6">
                        <button type="button" class="btn btn-primary rounded text-light btn-sm pull-right"  data-toggle="modal" data-target="#addUserModal">
                            <span data-toggle="tooltip" data-placement="bottom" title=" @lang('generic.add') @lang('generic.user')">
                                    <i class="fa fa-plus"></i> @lang('generic.add') @lang('generic.user')
                            </span>
                        </button>
                    </div>
                </div>
            </form>
            <table id="table" class="table table-bordered table-striped  dt-responsive nowrap" style="width: 100%" >
                <thead>
                    <tr class="bg-dark text-light">

                        <th>@lang('generic.name')</th>
                        <th>@lang('generic.email')</th>
                        <th>@lang('generic.username')</th>
                        <th>@lang('generic.rol')</th>
                        <th>@lang('generic.condition')</th>
                        <th>@lang('generic.actions')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->user }}</td>
                            <td>{{ $user->rol->name }}</td>
                            <td>{{ $user->condition }}</td>
                            <td>
                                <button type="button" class="btn btn-primary rounded text-light btn-sm"
                                    data-id="{{ $user->id }}"
                                    data-name="{{ $user->name }}"
                                    data-type_doc="{{ $user->type_doc }}"
                                    data-num_doc="{{ $user->num_doc }}"
                                    data-email="{{ $user->email }}"
                                    data-idrol="{{ $user->idrol }}"
                                    data-user="{{ $user->user }}"
                                    data-adress="{{ $user->adress }}"
                                    data-cel_number="{{ $user->cel_number }}"
                                    data-toggle="modal" data-target="#editUserModal">
                                    <span data-toggle="tooltip" data-placement="bottom" title=" @lang('generic.edit') @lang('generic.user')">
                                        <i class="fa fa-edit"></i>
                                    </span>
                                </button>
                                @if($user->condition == 'Active')
                                    <button type="button" class="btn btn-danger rounded btn-sm"
                                        data-id="{{ $user->id }}"
                                        data-toggle="modal" data-target="#changeCondition">
                                        <span data-toggle="tooltip" data-placement="bottom" title=" @lang('generic.change') @lang('generic.condition')">
                                            <i class="fa fa-trash"></i>
                                        </span>
                                    </button>
                                @else
                                    <button type="button" class="btn btn-success rounded btn-sm"
                                        data-id="{{ $user->id }}"
                                        data-toggle="modal" data-target="#changeCondition">
                                        <span data-toggle="tooltip" data-placement="bottom" title=" @lang('generic.change') @lang('generic.condition')">
                                            <i class="fa fa-check"></i>
                                        </span>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{$users->appends(request()->query())->links()}}<label class="pull-right ">@lang('generic.total_records'): {{$users->total()}} </label>
        </div>
    </div>
</div>

<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dark modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('generic.add') @lang('generic.user')</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-light">×</span>
                </button>
            </div>

            <div class="modal-body">
                <form action="{{route('users.store')}}" method="post" class="form-horizontal was-validated" enctype="multipart/form-data" >
                    {{csrf_field()}}
                    @include('users.form_user', ['types_doc' => $types_doc, 'roles' => $roles])
                </form>
            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dark modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('generic.edit') @lang('generic.user')</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-light">×</span>
                </button>
            </div>

            <div class="modal-body">
                <form action="{{route('users.update','update')}}" method="post" class="form-horizontal was-validated" enctype="multipart/form-data">
                    {{method_field('patch')}}
                    {{csrf_field()}}
                        @include('users.form_user', ['types_doc' => $types_doc, 'roles' => $roles])
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
                <form action="{{route('users.destroy','destroy')}}" method="POST" class="was-validated">
                    {{method_field('delete')}}
                    {{csrf_field()}}

                    <input type="hidden" id="id" name="id" value="">

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

            $('[data-toggle="tooltip"]').tooltip();

            /*EDITAR USUARIO EN VENTANA MODAL*/
            $('#editUserModal').on('show.bs.modal', function (event) {

                var button = $(event.relatedTarget)

                var name = button.data('name')
                var type_doc = button.data('type_doc')
                var num_doc = button.data('num_doc')
                var adress = button.data('adress')
                var cel_number = button.data('cel_number')
                var email = button.data('email')
                var idrol = button.data('idrol')
                var user = button.data('user')
                var id = button.data('id')
                var modal = $(this)

                modal.find('.modal-body #name').val(name);
                modal.find('.modal-body #type_doc').val(type_doc);
                modal.find('.modal-body #num_doc').val(num_doc);
                modal.find('.modal-body #adress').val(adress);
                modal.find('.modal-body #cel_number').val(cel_number);
                modal.find('.modal-body #email').val(email);
                modal.find('.modal-body #idrol').val(idrol);
                modal.find('.modal-body #user').val(user);
                modal.find('.modal-body #id').val(id);
                modal.find('.modal-body :input').inputmask();

            });


            $('#changeCondition').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                var modal = $(this);
                modal.find('.modal-body #id').val(id);
            });


        });
    </script>
@endpush

@endsection
