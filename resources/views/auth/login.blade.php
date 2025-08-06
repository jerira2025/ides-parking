<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Parqueadero del Pueblo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            height: 100vh;
            margin: 0;
            background-color: #f4f6f9;
            display: flex;
        }

        .login-container {
            display: flex;
            flex: 1;
        }

        .login-form {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            background-color: #ffffff;
        }

        .brand-side {
            flex: 1;
            background: linear-gradient(to bottom right, #2c3e50, #3498db);
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 30px;
        }

        .brand-side h1 {
            font-size: 2.5rem;
            font-weight: bold;
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
            border-color: #3498db;
        }

        .btn-primary {
            background-color: #2980b9;
            border-color: #2980b9;
        }

        .btn-primary:hover {
            background-color: #1c5981;
            border-color: #1c5981;
        }
    </style>
</head>

<body>
    <div class="login-container">

        <!-- Columna de Marca -->
        <div class="brand-side">
            <div style="font-size: 100px;">🚗</div>
            <h1 class="mt-3">Parqueadero del Pueblo</h1>
            <p>Sistema de Gestión de Parqueo</p>
        </div>

        <!-- Columna de Login -->
        <div class="login-form">
            <div class="w-100" style="max-width: 400px;">
                <h3 class="mb-4 text-center">Iniciar Sesión</h3>

                @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo electrónico</label>
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                        @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input id="password" type="password" class="form-control" name="password" required>
                        @error('password') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
                        <label class="form-check-label" for="remember_me">
                            Recuérdame
                        </label>
                    </div>

                    <!-- Botón Login -->
                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-primary">Ingresar</button>
                    </div>

                    @if (Route::has('password.request'))
                    <div class="text-center">
                        <a href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
                    </div>
                    @endif
                </form>
            </div>
        </div>

    </div>
</body>

</html>