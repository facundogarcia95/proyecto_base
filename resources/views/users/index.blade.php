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

<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
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


<div class="modal fade" id="resetPassword" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dark" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('generic.reset_password')</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-light">×</span>
                </button>
            </div>

            <div class="modal-body">
                <form action="{{route('password_reset')}}" method="POST" class="was-validated">
                    {{csrf_field()}}

                    <input type="hidden" id="id" name="id" value="">
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
                { targets: 4, width: '15%', className: 'text-left', orderable: false, responsivePriority:6},
                { targets: 5, width: '15%', orderable: false, responsivePriority:1},
            ],
            order: [[0, 'asc']],
            responsive:true,
            columns: [
                {
                    title: '@lang("generic.name")',
                    name: 'user.name',
                    data: 'name',
                    className: 'text-left'
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
                    title: '@lang("generic.condition")',
                    name: 'conditions.condition_name',
                    data: 'condition_name',
                    className: 'text-left',
                    render: function (data, type, row) {
                        return data;
                    }
                },
                {
                    title: '@lang("generic.actions")',
                    name: null,
                    data: null,
                    className: 'text-left',
                    render: function (data, type, row) {

                        return `<button type="button" class="btn btn-brown rounded text-light btn-sm"
                                    data-id="${row['id']}"
                                    data-name="${row['name']}"
                                    data-type_doc="${row['type_doc']}"
                                    data-num_doc="${row['num_doc']}"
                                    data-adress="${row['adress']}"
                                    data-email="${row['email']}"
                                    data-id_rol="${row['id_rol']}"
                                    data-user="${row['user']}"
                                    data-business="${row['id_business']}"
                                    data-id_user_owner="${row['id_user_owner']}"
                                    data-toggle="modal" data-target="#editUserModal">
                                    <span data-toggle="tooltip" data-placement="bottom" title=" @lang('generic.edit') @lang('generic.user')">
                                        <i class="fa fa-edit"></i>
                                    </span>
                                </button>`;
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
            var id_business = button.data('business')
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
            modal.find('.modal-body #id_business').val(id_business).trigger('change');

            if(id_business){
                modal.find('.modal-body #select-rol').show();
            }
            modal.find('.modal-body #id_rol').val(id_rol).trigger('change');

            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body :input').inputmask();

            modal.find('.modal-body #id_rol').on('change',function (e) { 
                if($(this).val() >= 3){ //NO ES SUPER NI ESCRIBANO
                    modal.find('.modal-body #user_attached').show();
                    modal.find('.modal-body #id_business').trigger('change');
                }else{
                    modal.find('.modal-body #user_attached').hide();
                    modal.find('.modal-body #id_user_attached').val(0).trigger('change');
                }
            });

            modal.find('.modal-body #id_business').on('change',function (e) { 
                $.ajax({
                    type: "GET",
                    url: "/users_by_business",
                    data: {id_business: $(this).val()},
                    dataType: "json",
                    success: function (response) {
                        if(response.status == 200){
                            modal.find('.modal-body #id_user_attached').empty();
                            modal.find('.modal-body #id_user_attached').append(`<option value='0'>Seleccione</option>`)
                            response.data.forEach(element => {
                                modal.find('.modal-body #id_user_attached').append(`<option value='${element.id}'> ${element.name}</option>`)
                            });
                            modal.find('.modal-body #id_user_attached').val(id_user_owner).trigger('change');
                        }
                        
                    }
                });
            });
        });

        function listUsersBusiness(id_business){
           
            
        }

        $('#changeCondition').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var modal = $(this);
            modal.find('.modal-body #id').val(id);
        });

        $('#resetPassword').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var modal = $(this);
            modal.find('.modal-body #id').val(id);
        });

        //Si el rol es adjunto, debo mostrar un desplegable para que seleccione el titular.
        $("#id_rol").on('change',function (e) { 
            e.preventDefault();
            id_rol = $(this).val();
            alert(id_rol);
            if(id_rol >= 3){ //NO ES SUPER NI ESCRIBANO
                $('#user_attached').show();
                $('#id_user_attached').trigger('change');
            }else{
                $('#user_attached').hide();
                $('#id_user_attached').val(0);
            }
        });

        //Si el rol es adjunto, debo mostrar un desplegable para que seleccione el titular.
        $("#id_business").on('change',function (e) { 
            $("#select-rol").show()
            $.ajax({
                type: "GET",
                url: "/users_by_business",
                data: {id_business: $(this).val()},
                dataType: "json",
                success: function (response) {
                    if(response.status == 200){
                        $('#id_user_attached').empty();
                        $('#id_user_attached').append(`<option value='0'>Seleccione</option>`)
                        response.data.forEach(element => {
                            $('#id_user_attached').append(`<option value='${element.id}'> ${element.name}</option>`)
                        });
                        $('#id_user_attached').val(id_user_owner).trigger('change');
                    }
                }
            });
        });

    });

</script>
@endpush

@endsection
