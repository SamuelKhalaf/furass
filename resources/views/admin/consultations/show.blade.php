@extends('admin.layouts.master')
@section('title', 'Consultation Details')
@section('content')
<div class="container mt-4">
    <h1>Consultation Details</h1>
    <div class="mb-3">
        <strong>Consultant:</strong> {{ $consultation->consultant->user->name ?? '-' }}
    </div>
    <div class="mb-3">
        <strong>Student:</strong> {{ $consultation->student->user->name ?? '-' }}
    </div>
    <div class="mb-3">
        <strong>Scheduled At:</strong> {{ $consultation->scheduled_at }}
    </div>
    <div class="mb-3">
        <strong>Status:</strong> {{ $consultation->status }}
    </div>
    <div class="mb-3">
        <strong>Zoom Meeting ID:</strong> {{ $consultation->zoom_meeting_id }}<br>
        <strong>Zoom Join URL:</strong> {{ $consultation->zoom_join_url }}<br>
        <strong>Zoom Start URL:</strong> {{ $consultation->zoom_start_url }}<br>
        <strong>Zoom Password:</strong> {{ $consultation->zoom_password }}
    </div>
    <h3>Consultation Notes</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Notes</th>
            </tr>
        </thead>
        <tbody>
            @foreach($consultation->notes as $note)
                <tr>
                    <td>{{ $note->id }}</td>
                    <td>{{ $note->notes }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('consultations.index') }}" class="btn btn-secondary">Back to List</a>
</div>
@endsection
