<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le cours</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0"><i class="fas fa-edit"></i> Modifier le cours</h4>
                            <a href="{{ route('teacher.courses.index') }}" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-arrow-left"></i> Retour
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('teacher.courses.update', $course) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="mb-3">
                                <label for="title" class="form-label">Titre du cours *</label>
                                <input type="text" class="form-control" id="title" name="title" 
                                       value="{{ old('title', $course->title) }}" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="description" class="form-label">Description *</label>
                                <textarea class="form-control" id="description" name="description" 
                                          rows="3" required>{{ old('description', $course->description) }}</textarea>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="module_id" class="form-label">Module *</label>
                                    <select class="form-select" id="module_id" name="module_id" required>
                                        <option value="" disabled>Choisir un module</option>
                                        @foreach($modules as $module)
                                            <option value="{{ $module->id }}" 
                                                {{ old('module_id', $course->module_id) == $module->id ? 'selected' : '' }}>
                                                {{ $module->name ?? $module->nom ?? 'Module ' . $module->id }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="groupe" class="form-label">Groupe *</label>
                                    <select class="form-select" id="groupe" name="groupe" required>
                                        <option value="" disabled>Choisir un groupe</option>
                                        <option value="groupe_1" {{ old('groupe', $course->groupe) == 'groupe_1' ? 'selected' : '' }}>Groupe 1</option>
                                        <option value="groupe_2" {{ old('groupe', $course->groupe) == 'groupe_2' ? 'selected' : '' }}>Groupe 2</option>
                                        <option value="groupe_3" {{ old('groupe', $course->groupe) == 'groupe_3' ? 'selected' : '' }}>Groupe 3</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="file_type" class="form-label">Type de fichier *</label>
                                    <select class="form-select" id="file_type" name="file_type" required>
                                        <option value="" disabled>Choisir le type</option>
                                        <option value="PDF" {{ old('file_type', $course->file_type) == 'PDF' ? 'selected' : '' }}>PDF</option>
                                        <option value="Word" {{ old('file_type', $course->file_type) == 'Word' ? 'selected' : '' }}>Word</option>
                                        <option value="PowerPoint" {{ old('file_type', $course->file_type) == 'PowerPoint' ? 'selected' : '' }}>PowerPoint</option>
                                        <option value="Image" {{ old('file_type', $course->file_type) == 'Image' ? 'selected' : '' }}>Image</option>
                                        <option value="Video" {{ old('file_type', $course->file_type) == 'Video' ? 'selected' : '' }}>Vidéo</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="file" class="form-label">Nouveau fichier (optionnel)</label>
                                    <input type="file" class="form-control" id="file" name="file" 
                                           accept=".pdf,.doc,.docx,.ppt,.pptx,.jpg,.jpeg,.png,.mp4">
                                    <small class="text-muted">
                                        Fichier actuel: 
                                        <a href="{{ Storage::url('public/' . $course->file_path) }}" target="_blank">
                                            {{ basename($course->file_path) }}
                                        </a>
                                    </small>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('teacher.courses.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Annuler
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Enregistrer les modifications
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>