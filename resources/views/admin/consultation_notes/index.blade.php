@extends('admin.layouts.master')
@section('title', 'Consultation Notes')
@section('content')
<div class="container mt-4">
    <h1>Consultation Notes</h1>
    <a href="{{ route('consultation-notes.create') }}" class="btn btn-primary mb-3">Add Note</a>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Consultation ID</th>
                <th>Notes</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($notes as $note)
                <tr>
                    <td>{{ $note->id }}</td>
                    <td>{{ $note->consultation_id }}</td>
                    <td>{{ $note->notes }}</td>
                    <td>
                        <a href="{{ route('consultation-notes.show', $note->id) }}" class="btn btn-info btn-sm">Show</a>
                        <a href="{{ route('consultation-notes.edit', $note->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('consultation-notes.destroy', $note->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $notes->links() }}
</div>
@endsection
