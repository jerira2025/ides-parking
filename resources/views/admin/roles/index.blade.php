@extends('layouts.app')

@section('content')
<div class="col-md-12 col-sm-12 ">
    <div class="x_panel">
        <div class="x_title">
            <h2>Listado<small>Roles</small></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i
                            class="fa fa-wrench"></i></a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="#">Settings 1</a>
                        <a class="dropdown-item" href="#">Settings 2</a>
                    </div>
                </li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card-box table-responsive">
                        <p class="text-muted font-13 m-b-30">
                            The Buttons extension for DataTables provides a common set of options, API methods and
                            styling to display buttons on a page that will interact with a DataTable. The core library
                            provides the based framework upon which plug-ins can built.
                        </p>
                        <a href="{{ route('admin.roles.create') }}" type="button" class="btn btn-round btn-primary" style="color:white;">
                            <i class="fa fa-plus mr-1"></i> Nuevo Rol
                        </a>

                        <div class="table-responsive">
                            <table id="datatable-buttons" class="table table-striped jambo_table bulk_action table-bordered">
                                <thead>
                                    <tr class="headings">
                                        <th>
                                            <input type="checkbox" id="check-all" class="flat">
                                        </th>
                                        <th class="column-title">N°</th>
                                        <th class="column-title">Nombre del Rol</th>
                                        <th class="column-title">Estado</th>
                                        <th class="column-title no-link last"><span class="nobr">Acciones</span></th>
                                        <th class="bulk-actions" colspan="7">
                                            <a class="antoo" style="color:#fff; font-weight:500;">
                                                Bulk Actions (<span class="action-cnt"></span>) <i class="fa fa-chevron-down"></i>
                                            </a>
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($roles as $role)
                                    <tr>
                                        <td><input type="checkbox" class="flat" name="table_records"></td>
                                        <td>{{ $role->id }}</td>
                                        <td>{{ $role->name }}</td>
                                        <td>
                                            @if ($role->estado)
                                            <button type="button" class="btn btn-round btn-success btn-sm">Activo</button>
                                            @else
                                            <button type="button" class="btn btn-round btn-danger btn-sm">Inactivo</button>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn btn-sm btn-round btn-primary" style="margin-right: 5px;">
                                                <i class="fa fa-pencil"></i> Editar
                                            </a>

                                            <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" class="delete-form" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-round btn-danger">
                                                    <i class="fa fa-trash"></i> Eliminar
                                                </button>
                                            </form>

                                            <script>
                                                document.addEventListener('DOMContentLoaded', function() {
                                                    const deleteForms = document.querySelectorAll('.delete-form');

                                                    deleteForms.forEach(form => {
                                                        form.addEventListener('submit', function(e) {
                                                            e.preventDefault();
                                                            Swal.fire({
                                                                title: '¿Estás seguro?',
                                                                text: "¡Esta acción no se puede deshacer!",
                                                                icon: 'warning',
                                                                showCancelButton: true,
                                                                confirmButtonColor: '#d33',
                                                                cancelButtonColor: '#3085d6',
                                                                confirmButtonText: 'Sí, eliminar',
                                                                cancelButtonText: 'Cancelar'
                                                            }).then((result) => {
                                                                if (result.isConfirmed) {
                                                                    form.submit();
                                                                }
                                                            });
                                                        });
                                                    });
                                                });
                                            </script>

                                            @if(session('success'))
                                            <script>
                                                document.addEventListener('DOMContentLoaded', function() {
                                                    Swal.fire({
                                                        icon: 'success',
                                                        title: '¡Éxito!',
                                                        text: @json(session('success')),
                                                        timer: 2000,
                                                        timerProgressBar: true,
                                                        showConfirmButton: false,
                                                        didOpen: () => {
                                                            Swal.showLoading();
                                                        }
                                                    });
                                                });
                                            </script>
                                            @endif

                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection