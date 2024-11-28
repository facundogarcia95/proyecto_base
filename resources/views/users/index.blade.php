@extends('template.contenido')

@section('contenido')
@include('errors.alert')
<div class="container-fluid mt-2">
    <div class="card">
        <div class="card-header">
            <h2>@lang('specific.user_list')</h2><br />
        </div>
        <div class="card-body">
            
            <table id="table" class="table table-bordered dataTables dataTable dt-responsive nowrap" style="width: 100%">
            </table>
            <form action="{{ route('users.index') }}" method="get">
                <div class="form-group row">
                    <div class="col-12">
                        @if(Auth::user()->rol->is_admin)
                        <button type="button" class="btn btn-brown rounded text-light btn-sm pull-right"
                            data-toggle="modal" data-target="#addUserModal">
                            <span data-toggle="tooltip" data-placement="bottom"
                                title=" @lang('generic.add') @lang('generic.user')">
                                <i class="fa fa-plus"></i> @lang('generic.add')
                            </span>
                        </button>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="addUserModal" role="dialog" aria-labelledby="myModalLabel"
    style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dark modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('generic.add') @lang('generic.user')</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-light">×</span>
                </button>
            </div>

            <div class="modal-body">
                <form action="{{route('users.store')}}" method="post" class="form-horizontal was-validated"
                    enctype="multipart/form-data">
                    {{csrf_field()}}
                    @include('users.form_user', ['types_doc' => $types_doc, 'roles' => $roles])
                </form>
            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="editUserModal" role="dialog" aria-labelledby="myModalLabel"
    style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dark modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('generic.edit') @lang('generic.user')</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-light">×</span>
                </button>
            </div>

            <div class="modal-body">
                <form action="{{route('users.update','update')}}" method="post" class="form-horizontal was-validated"
                    enctype="multipart/form-data">
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

<div class="modal fade" id="changeCondition" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    style="display: none;" aria-hidden="true">
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
                    <input type="hidden" id="condition" name="condition" value="2">

                    <p>@lang('generic.messege_confirm')</p>


                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success rounded">@lang('generic.accept')</button>
                        <button type="button" class="btn btn-danger rounded"
                            data-dismiss="modal">@lang('generic.cancel')</button>
                    </div>

                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>

<div class="modal fade" id="deleteUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dark" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('generic.delete_user')</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-light">×</span>
                </button>
            </div>

            <div class="modal-body">
                <form action="{{route('users.destroy','destroy')}}" method="POST" class="was-validated">
                    {{method_field('delete')}}
                    {{csrf_field()}}

                    <input type="hidden" id="id" name="id" value="">
                    <input type="hidden" id="condition" name="condition" value="">

                    <p>@lang('generic.messege_confirm')</p>


                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success rounded">@lang('generic.accept')</button>
                        <button type="button" class="btn btn-danger rounded"
                            data-dismiss="modal">@lang('generic.cancel')</button>
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

        $('#table').DataTable({
            language: {
                url: "{{asset('js/librerias/Spanish_sym.json')}}",
                decimal: ',',
                thousands: '.',
                infoEmpty: 'No hay ningun Convenio cargado...'
            },
            processing: true,
            serverSide: true,
            searchDelay: 800,
            ajax: {
                url:  "{{ route('users_ajax') }}",
                contentType: "application/json",
            },
            info: true,
            bFilter: true,
            columnDefs: [
                { targets: 0, width: '20%',  className: 'text-left', responsivePriority:2},
                { targets: 1, width: '20%',  className: 'text-left', responsivePriority:3},
                { targets: 2, width: '15%', className: 'text-left', responsivePriority:4},
                { targets: 3, width: '15%', className: 'text-left', responsivePriority:5},
                { targets: 4, width: '15%', orderable: false, responsivePriority:1},
            ],
            order: [[0, 'asc']],
            responsive:true,
            columns: [
                {
                    title: '@lang("generic.name")',
                    name: 'user.name',
                    data: 'name',
                    className: 'text-left',
                    render: function (data, type, row) {
                        if(row.condition == 1){
                            html = `<i class="fa fa-check-circle text-success mr-3" data-toggle="tooltip" data-placement="bottom" title="@lang('generic.condition') ${row.condition_name}"></i>`
                        }else{
                            html = `<i class="fa fa-window-close text-danger mr-3" data-toggle="tooltip" data-placement="bottom" title="@lang('generic.condition') ${row.condition_name}"></i>`
                        }
                        html += row.name;
                        return html;
                    }
                },
                {
                    title: '@lang("generic.email")',
                    name: 'user.email',
                    data: 'email',
                    className: 'text-left'
                },
                {
                    title: '@lang("generic.username")',
                    name: 'user.user',
                    data: 'user',
                    className: 'text-left'
                },

                {
                    title: '@lang("generic.rol")',
                    name: 'roles.name',
                    data: 'rolname',
                    className: 'text-left'
                },
                {
                    title: '@lang("generic.actions")',
                    name: null,
                    data: null,
                    className: 'text-left',
                    render: function (data, type, row) {
                      html = ``;
                      if (row.is_super != 1){
                          html += `<button type="button" class="btn btn-brown rounded text-light btn-sm ml-2"
                                    data-id="${row['id']}"
                                    data-name="${row['name']}"
                                    data-type_doc="${row['type_doc']}"
                                    data-num_doc="${row['num_doc']}"
                                    data-cel_number="${row['cel_number']}"
                                    data-adress="${row['adress']}"
                                    data-email="${row['email']}"
                                    data-id_rol="${row['id_rol']}"
                                    data-user="${row['user']}"
                                    data-toggle="modal" data-target="#editUserModal">
                                    <span data-toggle="tooltip" data-placement="bottom" title=" @lang('generic.edit') @lang('generic.user')">
                                        <i class="fa fa-edit"></i>
                                    </span>
                                </button>`;
                      } 

                      if (row.condition == 1 && row.is_super != 1){
                        html += `<button type="button" class="btn btn-danger rounded btn-sm ml-2"
                                    data-id="${row['id']}"
                                    data-condition="2"
                                    data-toggle="modal" data-target="#changeCondition">
                                    <span data-toggle="tooltip" data-placement="bottom" title=" @lang('generic.change') @lang('generic.condition')">
                                        <i class="fa fa-times"></i>
                                    </span>
                                </button>`;
                      }else if(row.condition == 2 && row.is_super != 1){
                        html += `<button type="button" class="btn btn-success rounded btn-sm ml-2"
                                    data-id="${row['id']}"
                                    data-condition="1"
                                    data-toggle="modal" data-target="#changeCondition">
                                    <span data-toggle="tooltip" data-placement="bottom" title=" @lang('generic.change') @lang('generic.condition')">
                                        <i class="fa fa-check"></i>
                                    </span>
                                </button>
                                <button type="button" class="btn btn-danger rounded btn-sm ml-2"
                                    data-id="${row['id']}"
                                    data-condition="3"
                                    data-toggle="modal" data-target="#deleteUser">
                                    <span data-toggle="tooltip" data-placement="bottom" title=" @lang('generic.delete_user')">
                                        <i class="fa fa-trash"></i>
                                    </span>
                                </button>`;
                      }

                      return html;
                    }
                }
            ]
        });

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
            var id_rol = button.data('id_rol')
            var user = button.data('user')
            var id_user_owner = button.data('id_user_owner')
            var id = button.data('id')
            var modal = $(this)

            modal.find('.modal-body #name').val(name);
            modal.find('.modal-body #type_doc').val(type_doc).trigger('change');
            modal.find('.modal-body #num_doc').val(num_doc);
            modal.find('.modal-body #adress').val(adress);
            modal.find('.modal-body #cel_number').val(cel_number);
            modal.find('.modal-body #email').val(email);
            modal.find('.modal-body #user').val(user);
            modal.find('.modal-body #id_rol').val(id_rol).trigger('change');

            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body :input').inputmask();
        });


        $('#changeCondition').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var condition = button.data('condition');
            var modal = $(this);
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #condition').val(condition);
        });

        $('#deleteUser').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var condition = button.data('condition');
            var modal = $(this);
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #condition').val(condition);
        });

        $('#resetPassword').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var modal = $(this);
            modal.find('.modal-body #id').val(id);
        });


    });

</script>
@endpush

@endsection
