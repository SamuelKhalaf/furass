@extends('admin.layouts.master')
@section('title', 'Edit Consultation')
@section('content')
<div class="container mt-4">
    <h1>Edit Consultation</h1>
    <form action="{{ route('consultations.update', $consultation->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="consultant_id" class="form-label">Consultant</label>
            <select name="consultant_id" id="consultant_id" class="form-control" required>
                <option value="">Select Consultant</option>
                @foreach($consultants as $consultant)
                    <option value="{{ $consultant->id }}" {{ $consultation->consultant_id == $consultant->id ? 'selected' : '' }}>{{ $consultant->user->name ?? '-' }}</option>
                @endforeach
            </select>
            @error('consultant_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="student_id" class="form-label">Student</label>
            <select name="student_id" id="student_id" class="form-control" required>
                <option value="">Select Student</option>
                @foreach($students as $student)
                    <option value="{{ $student->id }}" {{ $consultation->student_id == $student->id ? 'selected' : '' }}>{{ $student->user->name ?? '-' }}</option>
                @endforeach
            </select>
            @error('student_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="scheduled_at" class="form-label">Scheduled At</label>
            <input type="datetime-local" name="scheduled_at" id="scheduled_at" class="form-control" value="{{ old('scheduled_at', $consultation->scheduled_at ? date('Y-m-d\TH:i', strtotime($consultation->scheduled_at)) : '') }}" required>
            @error('scheduled_at')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <input type="text" name="status" id="status" class="form-control" value="{{ old('status', $consultation->status) }}" required>
            @error('status')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="zoom_meeting_id" class="form-label">Zoom Meeting ID</label>
            <input type="text" name="zoom_meeting_id" id="zoom_meeting_id" class="form-control" value="{{ old('zoom_meeting_id', $consultation->zoom_meeting_id) }}">
            @error('zoom_meeting_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="zoom_join_url" class="form-label">Zoom Join URL</label>
            <input type="url" name="zoom_join_url" id="zoom_join_url" class="form-control" value="{{ old('zoom_join_url', $consultation->zoom_join_url) }}">
            @error('zoom_join_url')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="zoom_start_url" class="form-label">Zoom Start URL</label>
            <input type="url" name="zoom_start_url" id="zoom_start_url" class="form-control" value="{{ old('zoom_start_url', $consultation->zoom_start_url) }}">
            @error('zoom_start_url')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="zoom_password" class="form-label">Zoom Password</label>
            <input type="text" name="zoom_password" id="zoom_password" class="form-control" value="{{ old('zoom_password', $consultation->zoom_password) }}">
            @error('zoom_password')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('consultations.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
