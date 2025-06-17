@extends('admin.layouts.master')
@section('title', 'Edit Consultation Note')
@section('content')
<div class="container mt-4">
    <h1>Edit Consultation Note</h1>
    <form action="{{ route('consultation-notes.update', $note->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="consultation_id" class="form-label">Consultation</label>
            <select name="consultation_id" id="consultation_id" class="form-control" required>
                <option value="">Select Consultation</option>
                @foreach($consultations as $consultation)
                    <option value="{{ $consultation->id }}" {{ $note->consultation_id == $consultation->id ? 'selected' : '' }}>
                        ID: {{ $consultation->id }} | {{ $consultation->scheduled_at }}
                    </option>
                @endforeach
            </select>
            @error('consultation_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="notes" class="form-label">Notes</label>
            <textarea name="notes" id="notes" class="form-control" required>{{ old('notes', $note->notes) }}</textarea>
            @error('notes')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('consultation-notes.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
