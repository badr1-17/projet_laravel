@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Déposer un cours</h2>

    <form method="POST" action="{{ route('courses.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="titre">Titre *</label>
            <input type="text" name="titre" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control" rows="3"></textarea>
        </div>

        <div class="form-group">
            <label for="type">Type *</label>
            <select name="type" class="form-control" required>
                <option value="cours">Cours</option>
                <option value="td">TD</option>
                <option value="tp">TP</option>
                <option value="projet">Projet</option>
            </select>
        </div>

        <div class="form-group">
            <label for="module_id">Module *</label>
            <select name="module_id" class="form-control" required>
                <option value="">Choisir un module</option>
                @foreach($modules as $module)
                    <option value="{{ $module->id }}">{{ $module->nom }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="groupe_id">Groupe *</label>
            <select name="groupe_id" class="form-control" required>
                <option value="">Choisir un groupe</option>
                @foreach($groupes as $groupe)
                    <option value="{{ $groupe->id }}">{{ $groupe->nom }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="fichier">Fichier *</label>
            <input type="file" name="fichier" class="form-control-file" required>
        </div>

        <button type="submit" class="btn btn-primary">Déposer</button>
    </form>
</div>
@endsection