@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Cargar nuevo documento</h2>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('documentos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group mb-3">
            <label>Título</label>
            <input type="text" name="titulo" class="form-control" required>
        </div>

        <div class="form-group mb-3">
            <label>Descripción</label>
            <textarea name="descripcion" class="form-control"></textarea>
        </div>

        <!-- Zona Drag & Drop -->
        <div class="form-group mb-3">
            <label>Archivo</label>
            <div id="dropzone"
                class="border border-2 border-primary p-4 text-center rounded bg-light"
                style="cursor: pointer; position: relative;">
                <i class="fa fa-upload fa-2x d-block mb-2 text-primary"></i>
                <p class="mb-1">Arrastra el archivo aquí o haz clic para seleccionarlo</p>
                <small>Formatos permitidos: PDF, DOCX, XLSX, JPG, PNG</small>
                <input type="file" name="archivo" id="archivoInput"
                    style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer;"
                    accept=".pdf,.docx,.xlsx,.jpg,.png" required>
            </div>
            <div id="archivoNombre" class="mt-2 text-muted small"></div>
            <div id="archivoCargadoIcono" class="alert alert-success mt-2 py-2 px-3" style="display: none;">
                ✅ Archivo listo para subir
            </div>
            @error('archivo')
            <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label>Categoría</label>
            <select name="categoria_id" class="form-control" required>
                <option value="">Seleccione...</option>
                @foreach($categorias as $categoria)
                <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label>Tipo de Documento</label>
            <select name="tipo_documento_id" class="form-control" required>
                <option value="">Seleccione...</option>
                @foreach($tipos as $tipo)
                <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label>Fecha del Documento</label>
            <input type="date" name="fecha_documento" class="form-control" required>
        </div>

        <div class="form-check mb-4">
            <input type="checkbox" name="confidencial" class="form-check-input" id="confidencial">
            <label class="form-check-label" for="confidencial">Marcar como confidencial</label>
        </div>

        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('documentos.index') }}" class="btn btn-secondary">Volver</a>
    </form>
</div>
@endsection

@section('scripts')
<script>
    const dropzone = document.getElementById('dropzone');
    const archivoInput = document.getElementById('archivoInput');
    const archivoNombre = document.getElementById('archivoNombre');
    const archivoCargadoIcono = document.getElementById('archivoCargadoIcono');

    // Crear y agregar contenedor para la vista previa
    let previewContainer = document.createElement('div');
    previewContainer.id = 'previewContainer';
    previewContainer.className = 'mt-2';
    dropzone.after(previewContainer);

    function mostrarArchivo(file) {
        archivoNombre.textContent = `📎 Archivo seleccionado: ${file.name}`;
        archivoNombre.classList.add('text-success');
        archivoCargadoIcono.style.display = 'block';
        dropzone.classList.add('border-success', 'bg-success-subtle');

        // Limpiar vista previa anterior
        previewContainer.innerHTML = '';

        // Mostrar miniatura si es imagen
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'img-thumbnail mt-2';
                img.style.maxWidth = '200px';
                img.alt = 'Vista previa';
                previewContainer.appendChild(img);
            };
            reader.readAsDataURL(file);
        }
    }

    archivoInput.addEventListener('change', () => {
        if (archivoInput.files.length > 0) {
            mostrarArchivo(archivoInput.files[0]);
        }
    });

    dropzone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropzone.classList.add('border-info', 'bg-white');
    });

    dropzone.addEventListener('dragleave', () => {
        dropzone.classList.remove('border-info', 'bg-white');
    });

    dropzone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropzone.classList.remove('border-info', 'bg-white');

        const files = e.dataTransfer.files;
        if (files.length > 0) {
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(files[0]);
            archivoInput.files = dataTransfer.files;

            mostrarArchivo(files[0]);
        }
    });
</script>
@endsection