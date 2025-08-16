@extends('admin.layouts.master')
@section('title', 'Consultation Note Details')
@section('content')
<div class="container mt-4">
    <h1>Consultation Note Details</h1>
    <div class="mb-3">
        <strong>Consultation ID:</strong> {{ $note->consultation_id }}
    </div>
    <div class="mb-3">
        <strong>Notes:</strong> {{ $note->notes }}
    </div>
    <a href="{{ route('consultation-notes.index') }}" class="btn btn-secondary">Back to List</a>
</div>
@endsection
