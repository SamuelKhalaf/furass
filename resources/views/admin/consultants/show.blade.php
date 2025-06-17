@extends('admin.layouts.master')
@section('title', 'Consultant Details')
@section('content')
<div class="container mt-4">
    <h1>Consultant Details</h1>
    <div class="mb-3">
        <strong>User:</strong> {{ $consultant->user->name ?? '-' }} ({{ $consultant->user->email ?? '' }})
    </div>
    <div class="mb-3">
        <strong>Bio:</strong> {{ $consultant->bio }}
    </div>
    <h3>Consultations</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Student ID</th>
                <th>Scheduled At</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($consultant->consultations as $consultation)
                <tr>
                    <td>{{ $consultation->id }}</td>
                    <td>{{ $consultation->student_id }}</td>
                    <td>{{ $consultation->scheduled_at }}</td>
                    <td>{{ $consultation->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('consultants.index') }}" class="btn btn-secondary">Back to List</a>
</div>
@endsection
