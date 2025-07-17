@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 ">
        <div class="x_panel">
            <div class="x_title">
                <h2>Nuevo<small>Usuario</small></h2>
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


                <form action="{{ route('admin.usuarios.store') }}" method="post" class="form-label-left input_mask">
                    @csrf


                    <div class="col-md-12 col-sm-12 form-group has-feedback">
                        <input type="text" class="form-control has-feedback-left @error('name') is-invalid @enderror"
                            id="name" name="name" placeholder="Nombre del Usuario" value="{{ old('name') }}"
                            oninput="this.value = this.value.toUpperCase().replace(/[^A-ZÁÉÍÓÚÑ\s]/g, '')">
                        <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                        @error('name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6 col-sm-6 form-group has-feedback">
                        <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                        <select class="form-control has-feedback-left" name="roles[]" id="roles">
                            <option selected disabled value="">Roles</option>
                            @foreach($roles as $role)
                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                        @error('roles')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6 col-sm-6 form-group has-feedback">
                        <input type="email" class="form-control has-feedback-left" id="email" name="email"
                            placeholder="Correo" value="{{ old('email') }}">
                        <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
                        @error('email')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="col-md-6 col-sm-12 form-group has-feedback position-relative">
                        <input type="password"
                            class="form-control has-feedback-left @error('password') is-invalid @enderror"
                            id="password" name="password" placeholder="Contraseña">
                        <span class="fa fa-lock form-control-feedback left" aria-hidden="true"></span>
                        <span class="fa fa-eye toggle-password position-absolute" toggle="#password"
                            style="right: 15px; top: 10px; cursor: pointer;"></span>
                        @error('password')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6 col-sm-12 form-group has-feedback position-relative">
                        <input type="password"
                            class="form-control has-feedback-left @error('password_confirmation') is-invalid @enderror"
                            id="password_confirmation" name="password_confirmation"
                            placeholder="Confirmar Contraseña">
                        <span class="fa fa-lock form-control-feedback left" aria-hidden="true"></span>
                        <span class="fa fa-eye toggle-password position-absolute" toggle="#password_confirmation"
                            style="right: 15px; top: 10px; cursor: pointer;"></span>
                        @error('password_confirmation')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>


                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            document.querySelectorAll('.toggle-password').forEach(function(toggle) {
                                toggle.addEventListener('click', function() {
                                    const input = document.querySelector(this.getAttribute('toggle'));
                                    const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                                    input.setAttribute('type', type);
                                    this.classList.toggle('fa-eye');
                                    this.classList.toggle('fa-eye-slash');
                                });
                            });
                        });
                    </script>




                    <div class="ln_solid"></div>
                    <div class="form-group row">
                        <div class="col-md-12 col-sm-12  offset-md-5"><br><br><br>
                            <button type="submit" class="btn btn-round btn-success">Registrar</button>
                            <button class="btn btn-round btn-secondary" type="reset">Reset</button>
                            <a href="{{ route('admin.usuarios.index') }}" class="btn btn-round btn-danger">Cancelar</a>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection