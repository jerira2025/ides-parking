@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 ">
        <div class="x_panel">
            <div class="x_title">
                <h2>Modificar<small>Rol</small></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                            aria-expanded="false"><i class="fa fa-wrench"></i></a>
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
                <br />

                @if($errors->any())
                <div class="alert alert-danger">
                    <strong>Errores:</strong>
                    <ul>
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif


                <form action="{{ route('admin.roles.update', $role->id) }}" method="POST" class="form-label-left input_mask">
                    @csrf
                    @method('PUT')
                    <div class="col-md-12 col-sm-12 form-group has-feedback">
                        <input type="text" class="form-control has-feedback-left"
                            id="nombre" name="nombre"
                            placeholder="Nombre del Rol"
                            oninput="this.value = this.value.toUpperCase().replace(/[^A-ZÁÉÍÓÚÑ\s]/g, '')">
                        <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                    </div>


                    <div class="ln_solid"></div>
                    <div class="form-group row">
                        <div class="col-md-12 col-sm-12  offset-md-0"><br><br><br>
                            <button type="submit" class="btn btn-success">Guardar</button>
                            <button class="btn btn-primary" type="reset">Reset</button>
                            <a href="{{ route('admin.roles.index') }}" class="btn btn-round btn-danger">Cancelar</a>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection