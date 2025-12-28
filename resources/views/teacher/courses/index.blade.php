@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Mes Cours</h2>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('courses.create') }}" class="btn btn-primary mb-3">Déposer un nouveau cours</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Titre</th>
                <th>Type</th>
                <th>Module</th>
                <th>Groupe</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($courses as $course)
                <tr>
                    <td>{{ $course->titre }}</td>
                    <td>{{ $course->type }}</td>
                    <td>{{ $course->module->nom ?? 'N/A' }}</td>
                    <td>{{ $course->groupe->nom ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('courses.edit', $course) }}" class="btn btn-sm btn-warning">Modifier</a>
                        <form action="{{ route('courses.destroy', $course) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ce cours?')">
                                Supprimer
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection